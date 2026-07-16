<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\ThreadLike;
use Illuminate\Http\Request;

class ThreadLikeController extends Controller
{
    public function toggle(Thread $thread)
    {
        $like = ThreadLike::where([
            'thread_id'=>$thread->id,
            'user_id'=>auth()->id()
        ])->first();

        if($like){

            $like->delete();

            return back();

        }

        ThreadLike::create([
            'thread_id'=>$thread->id,
            'user_id'=>auth()->id()
        ]);

        return back();
    }

}
