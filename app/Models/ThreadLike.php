<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThreadLike extends Model
{
    protected $fillable = [
        'thread_id',
        'user_id'
    ];
}
