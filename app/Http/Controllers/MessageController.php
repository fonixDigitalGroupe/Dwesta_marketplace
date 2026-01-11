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
            'content' => 'required|string',
        ]);

        $message = $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        $conversation->update(['last_message_at' => now()]);

        // Broadcasting event would go here

        return redirect()->route('conversations.show', $conversation);
    }
}
