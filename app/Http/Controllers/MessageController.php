<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display list of conversations (inbox).
     */
    public function index()
    {
        $user = Auth::user();
        
        $conversations = Conversation::forUser($user->id)
            ->with(['userOne', 'userTwo', 'lastMessage'])
            ->get()
            ->sortByDesc(function ($conversation) {
                return $conversation->lastMessage?->created_at;
            });

        return view('messages.index', compact('conversations'));
    }

    /**
     * Show a specific conversation.
     */
    public function show(Conversation $conversation)
    {
        $user = Auth::user();

        // Check if user is part of this conversation
        if ($conversation->user_one_id !== $user->id && $conversation->user_two_id !== $user->id) {
            abort(403);
        }

        // Mark messages as read
        $conversation->messages()
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = $conversation->messages()->with('sender')->get();
        $otherUser = $conversation->getOtherUser($user->id);

        return view('messages.show', compact('conversation', 'messages', 'otherUser'));
    }

    /**
     * Start a new conversation or open existing one with a user.
     */
    public function create(User $user)
    {
        $currentUser = Auth::user();

        // Can't message yourself
        if ($user->id === $currentUser->id) {
            return redirect()->route('messages.index')->with('error', 'You cannot message yourself.');
        }

        // Find or create conversation
        $conversation = Conversation::findOrCreateBetween($currentUser->id, $user->id);

        return redirect()->route('messages.show', $conversation);
    }

    /**
     * Send a message in a conversation.
     */
    public function store(Request $request, Conversation $conversation)
    {
        $user = Auth::user();

        // Check if user is part of this conversation
        if ($conversation->user_one_id !== $user->id && $conversation->user_two_id !== $user->id) {
            abort(403);
        }

        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'body' => $request->body,
        ]);

        // For AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
            ]);
        }

        return redirect()->route('messages.show', $conversation);
    }

    /**
     * Get new messages (for polling/AJAX).
     */
    public function getNewMessages(Request $request, Conversation $conversation)
    {
        $user = Auth::user();

        // Check if user is part of this conversation
        if ($conversation->user_one_id !== $user->id && $conversation->user_two_id !== $user->id) {
            abort(403);
        }

        $lastMessageId = $request->input('last_message_id', 0);

        $messages = $conversation->messages()
            ->where('id', '>', $lastMessageId)
            ->with('sender')
            ->get();

        // Mark received messages as read
        $conversation->messages()
            ->where('sender_id', '!=', $user->id)
            ->where('id', '>', $lastMessageId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json([
            'messages' => $messages,
        ]);
    }

    /**
     * Get unread count for navbar badge.
     */
    public function unreadCount()
    {
        $count = Auth::user()->unreadMessagesCount();
        
        return response()->json(['count' => $count]);
    }
}
