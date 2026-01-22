<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Toggle like on a post.
     */
    public function toggle(Post $post)
    {
        $user = auth()->user();
        
        $existingLike = Like::where('user_id', $user->id)
                            ->where('post_id', $post->id)
                            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
        } else {
            Like::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
            $liked = true;
        }

        // Return JSON for AJAX requests
        if (request()->expectsJson()) {
            return response()->json([
                'liked' => $liked,
                'count' => $post->likes()->count(),
            ]);
        }

        return back();
    }
}
