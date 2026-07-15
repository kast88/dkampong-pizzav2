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

        public function deleteThread(Thread $thread)
        {
            // soft delete thread
            $thread->delete();

            // tukar semua report berkaitan thread ini
            ThreadReport::where('thread_id', $thread->id)
                ->update([
                    'status' => 'resolved'
                ]);

            return back()->with('success','Thread deleted and report resolved.');
        }

    public function dismiss(ThreadReport $report)
    {
        if(auth()->user()->role != 'admin'){
            abort(403);
        }
        $report->update([
            'status'=>'dismissed'
        ]);
        return back();
    }
}
