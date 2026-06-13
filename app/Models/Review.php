<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'video_id',
        'user_id',
        'content',
        'image',
    ];

    protected $dates = [
        'deleted_at'
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
