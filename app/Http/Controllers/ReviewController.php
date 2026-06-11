<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request, $videoId)
    {
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $path = $request->file('image')?->store('reviews', 'public');

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

        if ($review->image) {
            Storage::disk('public')->delete($review->image);
        }

        $review->delete();

        return back()->with('success', 'Review deleted successfully!');
    }
}
