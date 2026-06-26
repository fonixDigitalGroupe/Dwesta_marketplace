<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagerieController extends Controller
{
    /**
     * Identité de la messagerie : TOUJOURS le compte Karnou (admin principal),
     * quel que soit le membre du staff connecté. Ainsi tout le staff voit les
     * mêmes conversations et envoie au nom de « Karnou ».
     */
    private function karnouId(): int
    {
        $karnou = User::where('email', 'admin@karnou.com')->first()
            ?? User::whereHas('roles', fn ($q) => $q->where('name', 'admin'))->first();

        return $karnou ? $karnou->id : (int) Auth::id();
    }

    /**
     * Page d'envoi + liste des conversations de l'admin.
     */
    public function index(Request $request)
    {
        $adminId = $this->karnouId();
        $folder = $request->get('folder') === 'sent' ? 'sent' : 'inbox';

        // Destinataires possibles (hors admin)
        $users = User::where('id', '!=', $adminId)
            ->whereDoesntHave('roles', fn ($q) => $q->where('name', 'admin'))
            ->with('vendeur')
            ->orderBy('prenom')
            ->get();

        // Conversations impliquant l'admin
        $query = Conversation::where(function ($q) use ($adminId) {
            $q->where('user1_id', $adminId)->orWhere('user2_id', $adminId);
        });

        // Filtre selon l'expéditeur du dernier message :
        // Réception = dernier message reçu (≠ admin) ; Envoyés = dernier message de l'admin.
        $lastSenderSub = '(select sender_id from messages where messages.conversation_id = conversations.id order by created_at desc limit 1)';
        if ($folder === 'sent') {
            $query->whereRaw("$lastSenderSub = ?", [$adminId]);
        } else {
            $query->whereRaw("$lastSenderSub <> ?", [$adminId]);
        }

        $conversations = $query->with([
                'user1', 'user2',
                'messages' => fn ($q) => $q->latest()->limit(1),
            ])
            ->orderByDesc('last_message_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.messagerie.index', compact('users', 'conversations', 'adminId', 'folder'));
    }

    /**
     * Affiche le détail d'une conversation DANS l'admin (pas côté marketplace).
     */
    public function show(Conversation $conversation)
    {
        $adminId = $this->karnouId();

        if ($conversation->user1_id != $adminId && $conversation->user2_id != $adminId) {
            abort(403);
        }

        $other = $conversation->user1_id == $adminId ? $conversation->user2 : $conversation->user1;

        // Marque comme lus les messages reçus
        $conversation->messages()
            ->where('sender_id', '!=', $adminId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = $conversation->messages()->with('sender')->orderBy('created_at')->get();

        return view('admin.messagerie.show', compact('conversation', 'other', 'messages', 'adminId'));
    }

    /**
     * Répond dans une conversation depuis l'admin.
     */
    public function reply(Request $request, Conversation $conversation)
    {
        $adminId = $this->karnouId();

        if ($conversation->user1_id != $adminId && $conversation->user2_id != $adminId) {
            abort(403);
        }

        $request->validate([
            'message' => 'required|string|max:5000',
        ], [
            'message.required' => 'Le message est obligatoire.',
        ]);

        $conversation->messages()->create([
            'sender_id' => $adminId,
            'content'   => $request->input('message'),
        ]);

        $conversation->update(['last_message_at' => now()]);

        return redirect()->route('admin.messagerie.show', $conversation)->with('success', 'Réponse envoyée.');
    }

    /**
     * Supprime une conversation (et ses messages via cascade).
     */
    public function destroy(Conversation $conversation)
    {
        $adminId = $this->karnouId();

        if ($conversation->user1_id != $adminId && $conversation->user2_id != $adminId) {
            abort(403);
        }

        $conversation->messages()->delete();
        $conversation->delete();

        return redirect()->route('admin.messagerie.index', ['folder' => request('folder', 'inbox')])
            ->with('success', 'Conversation supprimée.');
    }

    /**
     * Envoie un message à un utilisateur précis, à tous les vendeurs ou à tous les clients.
     */
    public function send(Request $request)
    {
        $request->validate([
            'mode'         => 'required|in:user,vendeurs,clients',
            'message'      => 'required|string|max:5000',
            'recipient_id' => 'required_if:mode,user|nullable|exists:users,id',
        ], [
            'message.required'      => 'Le message est obligatoire.',
            'recipient_id.required_if' => 'Veuillez choisir un destinataire.',
        ]);

        $adminId = $this->karnouId();
        $content = $request->input('message');

        // Détermine la liste des destinataires selon le mode
        if ($request->mode === 'user') {
            $recipients = User::where('id', $request->recipient_id)->pluck('id');
        } elseif ($request->mode === 'vendeurs') {
            $recipients = User::has('vendeur')->where('id', '!=', $adminId)->pluck('id');
        } else { // clients
            $recipients = User::doesntHave('vendeur')
                ->whereDoesntHave('roles', fn ($q) => $q->where('name', 'admin'))
                ->where('id', '!=', $adminId)
                ->pluck('id');
        }

        $count = 0;
        foreach ($recipients as $userId) {
            $this->deliver($adminId, $userId, $content);
            $count++;
        }

        if ($count === 0) {
            return back()->with('error', "Aucun destinataire trouvé pour cet envoi.");
        }

        $label = $request->mode === 'user' ? 'Message envoyé' : ($count . ' message(s) envoyé(s)');

        return back()->with('success', "{$label} avec succès.");
    }

    /**
     * Trouve (ou crée) la conversation entre l'admin et l'utilisateur, puis crée le message.
     */
    private function deliver(int $adminId, int $userId, string $content): void
    {
        $conversation = Conversation::where(function ($q) use ($adminId, $userId) {
            $q->where('user1_id', $adminId)->where('user2_id', $userId);
        })->orWhere(function ($q) use ($adminId, $userId) {
            $q->where('user1_id', $userId)->where('user2_id', $adminId);
        })->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'user1_id'        => $adminId,
                'user2_id'        => $userId,
                'last_message_at' => now(),
            ]);
        }

        $conversation->messages()->create([
            'sender_id' => $adminId,
            'content'   => $content,
        ]);

        $conversation->update(['last_message_at' => now()]);
    }
}
