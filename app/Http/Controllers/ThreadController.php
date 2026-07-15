<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ThreadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'category' => 'required',
            'image' => 'nullable|image|max:5120'
        ]);
        $image = null;
        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            if ($photo->isValid()) {
                $filename = time().'_'.$photo->getClientOriginalName();
                Storage::disk('public')->put(
                    'threads/'.$filename,
                    file_get_contents($photo->getPathname())
                );
                $image = 'threads/'.$filename;
            }
        }

        Thread::create([
            'user_id' => auth()->id(),
            'category' => $request->category,
            'title' => $request->title,
            'content' => $request->content,
            'image' => $image
        ]);
        return back()->with('success', 'Thread created successfully.');
    }

    public function edit(Thread $thread)
    {
        if($thread->user_id != auth()->id()){
            abort(403);
        }
        return view('threads.edit',compact('thread'));
    }

    public function update(Request $request, Thread $thread)
    {
        if ($thread->user_id != auth()->id()) {
            abort(403);
        }
        $request->validate([
            'category' => 'required',
            'title' => 'required',
            'content' => 'required',
        ]);
        $thread->update([
            'category' => $request->category,
            'title' => $request->title,
            'content' => $request->content,
        ]);
        return back()->with('success', 'Thread updated successfully.');
    }

    public function destroy(Thread $thread)
    {
        if($thread->user_id != auth()->id()){
            abort(403);
        }
        $thread->delete();
        return back();
    }
}
