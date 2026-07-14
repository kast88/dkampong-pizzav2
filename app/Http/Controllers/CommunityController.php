<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index()
    {
        $users = User::where('show_profile', true)
            ->latest()
            ->get();

        $threads = Thread::with('user')
            ->latest()
            ->get();

        return view('community', compact('users', 'threads'));
    }
}
