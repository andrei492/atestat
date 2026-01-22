<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'image_path',
    ];

    /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get all likes for the post.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Get all comments for the post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Check if the post is liked by a specific user.
     */
    public function isLikedBy($user)
    {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    /**
     * Get all saved instances of this post.
     */
    public function savedBy()
    {
        return $this->hasMany(SavedPost::class);
    }

    /**
     * Check if the post is saved by a specific user.
     */
    public function isSavedBy($user)
    {
        if (!$user) return false;
        return $this->savedBy()->where('user_id', $user->id)->exists();
    }
}
