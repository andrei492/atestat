<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
    ];

    /**
     * Get the user that saved the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the saved post.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
