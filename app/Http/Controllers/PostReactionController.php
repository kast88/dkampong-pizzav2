<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostReaction;
use Illuminate\Http\Request;

class PostReactionController extends Controller
{

    public function react(Post $post)
    {
        $type = request('type');

        PostReaction::updateOrCreate(
            [
                'post_id' => $post->id,
                'user_id' => auth()->id(),
            ],
            [
                'type' => $type
            ]
        );

        return back();
    }

}
