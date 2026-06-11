<?php

namespace App\Http\Controllers;

use App\Models\PasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;

class PasswordRequestController extends Controller
{
    public function index()
    {
        $requests = PasswordRequest::latest()->get();

        return view('admin.password_requests.index', compact('requests'));
    }

    public function create()
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // ✅ Check user exists with BOTH name + email
        $user = User::where('name', $validated['name'])
                    ->where('email', $validated['email'])
                    ->first();

        if (!$user) {
            return back()
                ->withInput()
                ->with('error', 'Name and email do not match our records.');
        }

        PasswordRequest::create($validated);

        return back()->with(
            'success',
            'Your request has been sent to the administrator.'
        );
    }

    public function approve(PasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        $newPassword = 'pass' . rand(1000, 9999);

        if ($user) {
            $user->password = bcrypt($newPassword);
            $user->save();

            // simple email
            Mail::raw("Your new password is: {$newPassword}", function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Password Reset Approved');
            });
        }

        $request->update(['status' => 'approved']);

        return back()->with('success', 'Request approved. Email has been sent to user.');
    }

    public function deny(PasswordRequest $request)
    {
        Mail::raw("Your password reset request has been denied by admin.", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Password Reset Denied');
        });

        $request->update(['status' => 'denied']);

        return back()->with('success', 'Request denied. Email has been sent to user.');
    }
}
