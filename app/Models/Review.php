<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'video_id',
        'user_id',
        'content',
        'image',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reactions()
    {
        return $this->hasMany(ReviewReaction::class);
    }

    public function replies()
    {
        return $this->hasMany(ReviewReply::class);
    }
}
