<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index()
    {
        $users = User::where('show_profile', true)
            ->latest()
            ->get();

        return view('community', compact('users'));
    }
}
