<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();

        $badge = $user->badges()->latest()->first();

        return view('profile.edit', compact('badge'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'location' => 'nullable|string|max:255',
            'interests' => 'nullable|array',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->bio = $request->bio;
        $user->location = $request->location;
        $user->interests = $request->interests;
        $user->show_profile = $request->has('show_profile');
        $user->allow_messages = $request->has('allow_messages');
        $user->show_location = $request->has('show_location');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_photo')) {

            $photo = $request->file('profile_photo');

            if ($photo->isValid()) {

                if ($user->profile_photo) {
                    Storage::disk('public')
                        ->delete($user->profile_photo);
                }

                $filename = time().'_'.$photo->getClientOriginalName();

                Storage::disk('public')->put(
                    'profiles/'.$filename,
                    file_get_contents($photo->getPathname())
                );

                $user->profile_photo = 'profiles/'.$filename;
            }
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}
