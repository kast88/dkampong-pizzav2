<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Thread $thread)
    {
        $request->validate([
            'content'=>'required'
        ]);
        Comment::create([
            'thread_id'=>$thread->id,
            'user_id'=>auth()->id(),
            'comment'=>$request->content
        ]);
        return back();
    }

    public function destroy(Comment $comment)
    {
        if($comment->user_id != auth()->id()){
            abort(403);

        }
        $comment->delete();
        return back();
    }
}
