<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userPostIds = $user->posts()->pluck('id');

        // Basic stats
        $stats = [
            'posts' => $user->posts()->count(),
            'followers' => $user->followers()->count(),
            'following' => $user->following()->count(),
            'totalLikes' => Like::whereIn('post_id', $userPostIds)->count(),
            'totalComments' => Comment::whereIn('post_id', $userPostIds)->count(),
        ];

        // Recent activity on your posts (likes and comments from others)
        $recentLikes = Like::whereIn('post_id', $userPostIds)
            ->where('user_id', '!=', $user->id)
            ->with(['user', 'post'])
            ->latest()
            ->take(5)
            ->get();

        $recentComments = Comment::whereIn('post_id', $userPostIds)
            ->where('user_id', '!=', $user->id)
            ->with(['user', 'post'])
            ->latest()
            ->take(5)
            ->get();

        // Top performing posts (most liked)
        $topPosts = $user->posts()
            ->withCount('likes')
            ->orderByDesc('likes_count')
            ->take(3)
            ->get();

        // Account created date
        $memberSince = $user->created_at;

        // Engagement rate (likes + comments per post)
        $engagementRate = $stats['posts'] > 0 
            ? round(($stats['totalLikes'] + $stats['totalComments']) / $stats['posts'], 1) 
            : 0;

        return view('dashboard', compact(
            'stats',
            'recentLikes',
            'recentComments',
            'topPosts',
            'memberSince',
            'engagementRate'
        ));
    }
}
