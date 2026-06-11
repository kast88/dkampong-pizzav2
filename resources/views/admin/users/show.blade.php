@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-zinc-950 text-zinc-100 flex">

    <!-- Sidebar -->
    <aside class="hidden w-72 flex-col border-r border-white/10 bg-black/40 lg:flex">
        @include('layouts.sidebar')
    </aside>

    <!-- Main -->
    <main class="flex-1 p-6 space-y-6">

        <h1 class="text-3xl font-bold">👤 User Profile #{{ $user->id }}</h1>

        <div class="rounded-2xl border border-white/10 bg-white/5 p-6 space-y-3">

            <p><span class="text-zinc-400">Name:</span> {{ $user->name }}</p>
            <p><span class="text-zinc-400">Email:</span> {{ $user->email }}</p>
            <p><span class="text-zinc-400">Role:</span> {{ $user->role }}</p>
            <p><span class="text-zinc-400">Status:</span> {{ $user->is_active ? 'Active' : 'Disabled' }}</p>
            <p><span class="text-zinc-400">Joined:</span> {{ $user->created_at->format('d M Y') }}</p>

        </div>

    </main>

</div>
@endsection
