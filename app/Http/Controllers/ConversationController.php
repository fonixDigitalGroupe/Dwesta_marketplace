<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $conversations = Auth::user()->conversations;
        return view('conversations.index', compact('conversations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $recipientId = $request->query('recipient_id');
        $recipient = User::findOrFail($recipientId);
        $prefilledMessage = $request->query('message', '');
        $annonceId = $request->query('annonce_id');
        
        // Check if conversation already exists
        $conversation = Conversation::where(function ($query) use ($recipientId) {
            $query->where('user1_id', Auth::id())
                  ->where('user2_id', $recipientId);
        })->orWhere(function ($query) use ($recipientId) {
            $query->where('user1_id', $recipientId)
                  ->where('user2_id', Auth::id());
        })->first();

        // Create if it doesn't exist
        if (!$conversation) {
            $conversation = Conversation::create([
                'user1_id' => Auth::id(),
                'user2_id' => $recipientId,
                'annonce_id' => $annonceId,
                'last_message_at' => now(),
            ]);
        } else if ($annonceId) {
            // Update the pinned product if provided
            $conversation->update(['annonce_id' => $annonceId]);
        }

        // Always redirect to the WhatsApp-style show view
        return redirect()->route('conversations.show', [
            'conversation' => $conversation->id,
            'layout' => request('layout')
        ])
            ->with('show_annonce_preview', true)
            ->with('prefilled_message', $prefilledMessage);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'annonce_id' => 'nullable|exists:annonces,id',
        ]);

        $recipientId = $request->input('recipient_id');

        // Check again for existing conversation
        $conversation = Conversation::where(function ($query) use ($recipientId) {
                $query->where('user1_id', Auth::id())
                      ->where('user2_id', $recipientId);
            })->orWhere(function ($query) use ($recipientId) {
                $query->where('user1_id', $recipientId)
                      ->where('user2_id', Auth::id());
            })->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'user1_id' => Auth::id(),
                'user2_id' => $recipientId,
                'annonce_id' => $request->input('annonce_id'),
                'last_message_at' => now(),
            ]);
        } else if ($request->input('annonce_id') && !$conversation->annonce_id) {
            // Update annonce if there is none
            $conversation->update(['annonce_id' => $request->input('annonce_id')]);
        }

        $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'content' => $request->input('message'),
        ]);

        $conversation->update(['last_message_at' => now()]);

        return redirect()->route('conversations.show', $conversation);
    }

    /**
     * Display the specified resource.
     */
    public function show(Conversation $conversation)
    {
        // Authorization check
        if ($conversation->user1_id !== Auth::id() && $conversation->user2_id !== Auth::id()) {
            abort(403);
        }

        $conversation->load(['messages.sender', 'user1', 'user2', 'annonce']);
        
        // Mark messages as read
        $conversation->messages()
            ->where('sender_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $conversations = Auth::user()->conversations;

        return view('conversations.show', compact('conversation', 'conversations'));
    }

    /**
     * Détacher le produit épinglé de la conversation
     */
    public function removeAnnonce(Conversation $conversation)
    {
        if ($conversation->user1_id !== Auth::id() && $conversation->user2_id !== Auth::id()) {
            abort(403);
        }

        $conversation->update(['annonce_id' => null]);

        return redirect()->route('conversations.show', $conversation);
    }

    /**
     * Supprimer une conversation
     */
    public function destroy(Conversation $conversation)
    {
        if ($conversation->user1_id !== Auth::id() && $conversation->user2_id !== Auth::id()) {
            abort(403);
        }

        // Supprimer les messages associés (ou ils seront supprimés en cascade si configuré en BD)
        $conversation->messages()->delete();
        $conversation->delete();

        return redirect()->route('conversations.index')->with('success', 'Discussion supprimée avec succès.');
    }
}
