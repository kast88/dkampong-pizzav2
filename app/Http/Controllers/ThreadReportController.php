<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\ThreadReport;
use Illuminate\Http\Request;

class ThreadReportController extends Controller
{
    public function store(Request $request, Thread $thread)
    {
        $request->validate([
            'reason'=>'required'
        ]);

        ThreadReport::create([
            'thread_id'=>$thread->id,
            'user_id'=>auth()->id(),
            'reason'=>$request->reason,
            'details'=>$request->details
        ]);

        return back()
            ->with('success','Report submitted.');
    }
}
