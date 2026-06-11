@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-zinc-950 text-zinc-100 flex">

    <!-- Sidebar -->
    <aside class="hidden w-72 flex-col border-r border-white/10 bg-black/40 lg:flex">
        @include('layouts.sidebar')
    </aside>

    <!-- Main -->
    <main class="flex-1 p-6 space-y-6">

        <!-- Header -->
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">

            <p class="text-sm uppercase tracking-widest text-orange-400">
                Admin Panel
            </p>

            <h1 class="mt-2 text-3xl font-bold text-white">
                👥 User Management
            </h1>

            <p class="mt-2 text-sm text-zinc-400">
                View and manage all registered users in the system
            </p>

        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                <p class="text-zinc-400 text-sm">Total Users</p>
                <p class="text-2xl font-bold text-white">{{ $users->count() }}</p>
            </div>

            <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                <p class="text-zinc-400 text-sm">Latest User</p>
                <p class="text-white font-semibold">
                    {{ $users->first()->name ?? '-' }}
                </p>
            </div>

            <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                <p class="text-zinc-400 text-sm">Joined Today</p>
                <p class="text-white font-semibold">
                    {{ $users->where('created_at', '>=', now()->startOfDay())->count() }}
                </p>
            </div>

        </div>

        <!-- Table -->
        <div class="rounded-3xl border border-white/10 bg-white/5 overflow-hidden">

            <div class="flex items-center justify-between p-5 border-b border-white/10">
                <h2 class="font-semibold text-white">All Users</h2>

                <form method="GET" action="{{ route('admin.users.index') }}"
                    class="flex gap-2">

                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search users..."
                        class="px-4 py-2 rounded-xl bg-black/30 border border-white/10 text-sm text-white focus:outline-none focus:border-orange-500">

                    <button class="px-4 py-2 rounded-xl bg-white/10 text-sm">
                        Search
                    </button>

                </form>

                <a href="{{ route('admin.users.create') }}"
                    class="px-4 py-2 rounded-xl bg-gradient-to-r from-orange-500 to-red-500 text-white text-sm font-semibold hover:opacity-90">
                    + Create User
                </a>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-black/30 text-zinc-300">
                    <tr>
                        <th class="px-6 py-4 text-left">ID</th>
                        <th class="px-6 py-4 text-left">Name</th>
                        <th class="px-6 py-4 text-left">Email</th>
                        <th class="px-6 py-4 text-left">Role</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-left">Joined</th>
                        <th class="px-6 py-4 text-left">Actions</th>
                    </tr>
                    </thead>

                    <tbody>

                        @foreach($users as $user)
                        <tr class="border-t border-white/10 hover:bg-white/5 transition">

                            <td class="px-6 py-4 text-zinc-400">
                                #{{ $user->id }}
                            </td>

                            <td class="px-6 py-4 font-medium text-white">
                                {{ $user->name }}
                            </td>

                            <td class="px-6 py-4 text-zinc-300">
                                {{ $user->email }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full
                                    {{ $user->role === 'admin' ? 'bg-red-500/20 text-red-300' : 'bg-blue-500/20 text-blue-300' }}">
                                    {{ $user->role }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full
                                    {{ $user->is_active ? 'bg-green-500/20 text-green-300' : 'bg-zinc-500/20 text-zinc-300' }}">
                                    {{ $user->is_active ? 'Active' : 'Disabled' }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-zinc-400">
                                {{ $user->created_at->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4 flex gap-2">

                                <!-- View -->
                                <a href="{{ route('admin.users.show', $user->id) }}"
                                class="text-xs px-3 py-1 rounded-lg bg-white/10 hover:bg-white/20">
                                    View
                                </a>

                                <!-- Edit -->
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                class="text-xs px-3 py-1 rounded-lg bg-orange-500/20 text-orange-300 hover:bg-orange-500/30">
                                    Edit
                                </a>

                                <!-- Disable -->
                                <form method="POST" action="{{ route('admin.users.toggle', $user->id) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button class="text-xs px-3 py-1 rounded-lg bg-red-500/20 text-red-300 hover:bg-red-500/30">
                                        Toggle
                                    </button>
                                </form>

                            </td>

                        </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>
            <div class="px-6 py-4 border-t border-white/10 bg-black/20">
                {{ $users->links() }}
            </div>

        </div>

    </main>

</div>

@endsection
