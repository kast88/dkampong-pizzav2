@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-zinc-950 flex items-center justify-center">

    <div class="w-full max-w-lg bg-zinc-900 rounded-3xl p-8">

        <h1 class="text-2xl font-bold text-white mb-2">
            Forgot Password
        </h1>

        <p class="text-zinc-400 mb-6">
            Submit a password reset request to the administrator.
        </p>

        {{-- @if(session('success'))
            <div class="mb-4 p-3 rounded-xl bg-green-500/20 text-green-300">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-xl bg-red-500/10 border border-red-500/30 p-4 text-red-400">
                <ul class="space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <form method="POST"
              action="{{ route('password.request.store') }}"
              class="space-y-4">

            @csrf

            <input
                type="text"
                name="name"
                placeholder="Full Name"
                class="w-full p-3 rounded-xl bg-zinc-800 text-white">

            <input
                type="email"
                name="email"
                placeholder="Email Address"
                class="w-full p-3 rounded-xl bg-zinc-800 text-white">

            <textarea
                name="message"
                rows="4"
                placeholder="Additional message"
                class="w-full p-3 rounded-xl bg-zinc-800 text-white" required></textarea>

            <button
                class="w-full rounded-xl bg-orange-500 py-3 text-white font-semibold">

                Send Request

            </button>

            <a href="{{ url('/login') }}"
                class="mt-3 inline-flex w-full items-center justify-center rounded-xl border border-neutral-300 bg-white px-4 py-2.5 text-sm font-semibold text-neutral-700 shadow-sm transition hover:border-orange-500 hover:bg-orange-50 hover:text-orange-600"
            >
                Back to Login Page
            </a>

        </form>

    </div>

</div>

@endsection
