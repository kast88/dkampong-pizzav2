<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Review;
use App\Models\ReviewReaction;
use App\Models\ReviewReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request, $videoId)
    {
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            if ($file && $file->isValid()) {

                $filename = time().'_'.$file->getClientOriginalName();

                $destination = public_path('storage/reviews');

                $file->move($destination, $filename);

                $path = 'reviews/'.$filename;
            }
        }

        Review::create([
            'video_id' => $videoId,
            'user_id' => auth()->id(),
            'content' => $request->content,
            'image' => $path,
        ]);

        return back()->with('success', 'Review posted successfully!');
    }

    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'content' => 'required|string',
        ]);

        $review->update([
            'content' => $request->content,
        ]);

        return back()->with('success', 'Review updated successfully!');
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $review->delete();

        return back()->with('success', 'Review deleted successfully!');
    }

    public function react(Request $request, Review $review)
    {
        $request->validate([
            'type' => 'required|in:like,dislike'
        ]);

        ReviewReaction::updateOrCreate(
            [
                'review_id' => $review->id,
                'user_id' => auth()->id(),
            ],
            [
                'type' => $request->type
            ]
        );

        return back();
    }

    public function reply(Request $request, Review $review)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        ReviewReply::create([
            'review_id' => $review->id,
            'user_id' => auth()->id(),
            'content' => $request->content
        ]);

        return back();
    }
}
