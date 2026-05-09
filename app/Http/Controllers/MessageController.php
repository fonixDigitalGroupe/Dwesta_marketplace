<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Conversation $conversation)
    {
        // Authorization check
        if ($conversation->user1_id !== Auth::id() && $conversation->user2_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'content' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240',
            'annonce_id' => 'nullable|exists:annonces,id',
        ]);

        $data = [
            'sender_id' => Auth::id(),
            'content' => $request->input('content') ?? '',
            'annonce_id' => $request->input('annonce_id'),
        ];

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $mime = $file->getMimeType();
            
            if (str_starts_with($mime, 'image/')) {
                $data['image_path'] = $file->store('messages/images', 'public');
            } else {
                $data['file_path'] = $file->store('messages/files', 'public');
            }
        }

        // Ensure we have at least something to send
        if (trim($data['content']) === '' && !isset($data['image_path']) && !isset($data['file_path']) && !isset($data['annonce_id'])) {
            if ($conversation->annonce_id) {
                // If the user hasn't typed anything but a product is linked, we send a minimalist interest message
                $data['content'] = 'Bonjour, je suis intéressé(e) par votre annonce.';
                $data['annonce_id'] = $conversation->annonce_id;
            } else {
                return back()->with('error', 'Le message ne peut pas être vide.');
            }
        }

        $message = $conversation->messages()->create($data);

        $conversation->update(['last_message_at' => now()]);

        // Broadcasting event would go here

        return redirect()->route('conversations.show', $conversation);
    }

    /**
     * Supprimer un message (uniquement le sien)
     */
    public function destroy(Conversation $conversation, Message $message)
    {
        if ($message->sender_id !== Auth::id()) {
            abort(403);
        }

        $message->delete();

        return redirect()->route('conversations.show', $conversation)
            ->with('success', 'Message supprimé.');
    }
}
