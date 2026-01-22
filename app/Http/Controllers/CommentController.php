<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Store a new comment.
     */
    public function store(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'body' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
            'body' => $request->body,
        ]);

        // Load user relationship for the response
        $comment->load('user');

        if ($request->expectsJson()) {
            return response()->json([
                'comment' => $comment,
                'user' => $comment->user,
                'count' => $post->comments()->count(),
            ]);
        }

        return back();
    }

    /**
     * Delete a comment.
     */
    public function destroy(Comment $comment)
    {
        // Only allow the comment owner or post owner to delete
        if (auth()->id() !== $comment->user_id && auth()->id() !== $comment->post->author_id) {
            if (request()->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            abort(403);
        }

        $postId = $comment->post_id;
        $comment->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'count' => Post::find($postId)->comments()->count(),
            ]);
        }

        return back();
    }
}
