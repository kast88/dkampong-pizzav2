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
                🔔 Password Reset Requests
            </h1>

            <p class="mt-2 text-sm text-zinc-400">
                Manage user password reset requests submitted from the system
            </p>

        </div>

        <!-- Table Card -->
        <div class="rounded-3xl border border-white/10 bg-white/5 overflow-hidden">

            <div class="flex items-center justify-between p-5 border-b border-white/10">
                <h2 class="font-semibold text-white">All Requests</h2>

                <span class="text-xs text-zinc-400">
                    {{ $requests->count() }} requests
                </span>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-black/30 text-zinc-300">
                        <tr>
                            <th class="px-6 py-4 text-left">Name</th>
                            <th class="px-6 py-4 text-left">Email</th>
                            <th class="px-6 py-4 text-left">Message</th>
                            <th class="px-6 py-4 text-left">Date</th>
                            <th class="px-6 py-4 text-left">Status</th>
                            <th class="px-6 py-4 text-left">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($requests as $request)

                            <tr class="border-t border-white/10 hover:bg-white/5 transition">

                                <td class="px-6 py-4 font-medium text-white">
                                    {{ $request->name }}
                                </td>

                                <td class="px-6 py-4 text-zinc-300">
                                    {{ $request->email }}
                                </td>

                                <td class="px-6 py-4 text-zinc-400">
                                    {{ $request->message ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-zinc-500">
                                    {{ $request->created_at->format('d M Y H:i') }}
                                </td>

                                <td class="px-6 py-4">
                                    <span class="text-xs px-2 py-1 rounded-full
                                        @if($request->status == 'pending') bg-yellow-500/20 text-yellow-300
                                        @elseif($request->status == 'approved') bg-green-500/20 text-green-300
                                        @else bg-red-500/20 text-red-300 @endif">
                                        {{ $request->status }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 flex gap-2">
                                    <form method="POST" action="{{ route('admin.password-requests.approve', $request->id) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button class="px-3 py-1 text-xs rounded-lg bg-green-500/20 text-green-300 hover:bg-green-500/30">
                                            Approve
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.password-requests.deny', $request->id) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button class="px-3 py-1 text-xs rounded-lg bg-red-500/20 text-red-300 hover:bg-red-500/30">
                                            Deny
                                        </button>
                                    </form>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-zinc-400">
                                    No password requests yet.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>
@endsection
