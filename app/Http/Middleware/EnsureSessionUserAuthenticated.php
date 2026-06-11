<?php
// app/Http/Middleware/EnsureSessionUserAuthenticated.php

namespace App\Http\Middleware;

// use App\Support\SessionUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnsureSessionUserAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        // Log::debug(! SessionUser::check()
        //     ? 'No authenticated user found in session.'
        //     : 'Authenticated user found in session: ' . json_encode(SessionUser::get())
        // );
        // if (! SessionUser::check()) {
        //     return redirect()->route('login')
        //         ->with('error', 'Please login first.');
        // }

        return $next($request);
    }
}
