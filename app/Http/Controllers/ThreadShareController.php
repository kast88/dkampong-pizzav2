<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\ThreadShare;
use Illuminate\Http\Request;

class ThreadShareController extends Controller
{
    public function store(Thread $thread)
    {
        $exist = ThreadShare::where([
            'thread_id'=>$thread->id,
            'user_id'=>auth()->id()
        ])->first();
        if(!$exist){
            ThreadShare::create([
                'thread_id'=>$thread->id,
                'user_id'=>auth()->id()
            ]);
        }
        return back();
    }
}
