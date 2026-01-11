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
        
        // Check if conversation already exists
        $existingConversation = Conversation::where(function ($query) use ($recipientId) {
            $query->where('user1_id', Auth::id())
                  ->where('user2_id', $recipientId);
        })->orWhere(function ($query) use ($recipientId) {
            $query->where('user1_id', $recipientId)
                  ->where('user2_id', Auth::id());
        })->first();

        if ($existingConversation) {
            return redirect()->route('conversations.show', $existingConversation);
        }

        return view('conversations.create', compact('recipient'));
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

        return view('conversations.show', compact('conversation'));
    }
}
