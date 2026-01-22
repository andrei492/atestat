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

        // Get the ID of the first unread message BEFORE marking them as read
        $firstUnreadMessageId = $conversation->messages()
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->orderBy('id', 'asc')
            ->value('id');

        // Mark messages as read
        $conversation->messages()
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = $conversation->messages()->with(['sender', 'sharedPost.user'])->get();
        $otherUser = $conversation->getOtherUser($user->id);

        return view('messages.show', compact('conversation', 'messages', 'otherUser', 'firstUnreadMessageId'));
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
            ->with(['sender', 'sharedPost.user'])
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

    /**
     * Search users for share to DM feature.
     */
    public function searchUsers(Request $request)
    {
        $query = $request->input('q', '');
        $user = Auth::user();

        if (strlen($query) < 1) {
            return response()->json(['users' => []]);
        }

        $users = User::where('id', '!=', $user->id)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'email', 'profile_photo']);

        return response()->json(['users' => $users]);
    }

    /**
     * Get suggested users for sharing (followers + following).
     */
    public function getSuggestedUsers()
    {
        $user = Auth::user();

        // Get followers and following combined, prioritize recent conversations
        $recentConversationUserIds = Conversation::forUser($user->id)
            ->with(['lastMessage'])
            ->get()
            ->sortByDesc(function ($conversation) {
                return $conversation->lastMessage?->created_at;
            })
            ->map(function ($conversation) use ($user) {
                return $conversation->getOtherUser($user->id)->id;
            })
            ->take(5)
            ->toArray();

        // Get followers
        $followerIds = $user->followers()->pluck('users.id')->toArray();
        
        // Get following
        $followingIds = $user->following()->pluck('users.id')->toArray();

        // Combine and prioritize: recent conversations first, then followers/following
        $allUserIds = array_unique(array_merge($recentConversationUserIds, $followerIds, $followingIds));
        
        // Remove self
        $allUserIds = array_filter($allUserIds, fn($id) => $id !== $user->id);
        
        // Get users, limit to 10
        $suggestedUsers = User::whereIn('id', array_slice($allUserIds, 0, 10))
            ->get(['id', 'name', 'email', 'profile_photo']);

        // Sort by the priority order
        $suggestedUsers = $suggestedUsers->sortBy(function ($suggestedUser) use ($allUserIds) {
            return array_search($suggestedUser->id, $allUserIds);
        })->values();

        return response()->json(['users' => $suggestedUsers]);
    }

    /**
     * Share a post to a user via DM.
     */
    public function sharePost(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'post_id' => 'required|exists:posts,id',
            'message' => 'nullable|string|max:500',
        ]);

        $currentUser = Auth::user();
        $targetUserId = $request->input('user_id');

        // Can't share to yourself
        if ($targetUserId == $currentUser->id) {
            return response()->json(['success' => false, 'message' => 'Cannot share to yourself.'], 400);
        }

        // Find or create conversation
        $conversation = Conversation::findOrCreateBetween($currentUser->id, $targetUserId);

        // Build the message body (optional custom message)
        $customMessage = $request->input('message', '');
        $body = $customMessage ?: 'Shared a post';

        // Create the message with shared post reference
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $currentUser->id,
            'body' => $body,
            'shared_post_id' => $request->input('post_id'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Post shared successfully!',
        ]);
    }
}
