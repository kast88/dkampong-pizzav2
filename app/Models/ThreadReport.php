<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ThreadReport extends Model
{
    protected $fillable = [
        'thread_id',
        'user_id',
        'reason',
        'details',
        'status'
    ];

    public function thread()
    {
        return $this->belongsTo(Thread::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
