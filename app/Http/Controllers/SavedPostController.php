<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\SavedPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedPostController extends Controller
{
    /**
     * Toggle save/unsave a post.
     */
    public function toggle(Post $post)
    {
        $user = Auth::user();

        $existingSave = SavedPost::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->first();

        if ($existingSave) {
            $existingSave->delete();
            $saved = false;
        } else {
            SavedPost::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
            $saved = true;
        }

        if (request()->ajax()) {
            return response()->json([
                'saved' => $saved,
            ]);
        }

        return back();
    }

    /**
     * Display saved posts.
     */
    public function index()
    {
        $savedPosts = Auth::user()
            ->savedPosts()
            ->with(['post.user', 'post.likes', 'post.comments'])
            ->latest()
            ->paginate(12);

        return view('saved.index', compact('savedPosts'));
    }
}
