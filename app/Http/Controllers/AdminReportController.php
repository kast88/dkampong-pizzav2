<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\ThreadReport;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{

    public function index()
    {
        if(auth()->user()->role != 'admin'){
            abort(403);
        }

        $reports = ThreadReport::with([
            'user',
            'thread.user'
        ])
        ->latest()
        ->get();

        return view('admin.reports.index', compact('reports'));
    }

    public function deleteThread($thread)
    {
        $thread = Thread::withTrashed()->findOrFail($thread);

        $thread->delete();

        ThreadReport::where('thread_id', $thread->id)
            ->update([
                'status' => 'resolved'
            ]);

        return back()->with('success','Thread deleted.');
    }

    public function dismiss(ThreadReport $report)
    {
        if(auth()->user()->role != 'admin'){
            abort(403);
        }

        // kalau thread pernah soft delete, restore balik
        $thread = Thread::withTrashed()
            ->find($report->thread_id);

        if($thread && $thread->trashed()){
            $thread->restore();
        }

        $report->update([
            'status'=>'dismissed'
        ]);

        return back()->with('success','Report dismissed.');
    }
}
