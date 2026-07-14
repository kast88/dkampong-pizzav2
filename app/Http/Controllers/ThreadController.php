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


        return back();
    }
}
