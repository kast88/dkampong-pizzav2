@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-zinc-950 text-zinc-100 flex">

    <!-- Sidebar -->
    <aside class="hidden w-72 flex-col border-r border-white/10 bg-black/40 lg:flex">
        @include('layouts.sidebar')
    </aside>

    <!-- Main -->
    <main class="flex-1 p-6 space-y-6">

        <h1 class="text-3xl font-bold mb-6">✏️ Edit User</h1>

        <form method="POST" action="{{ route('admin.users.update', $user->id) }}"
              class="space-y-4">

            @csrf
            @method('PUT')

            <input name="name"
                   value="{{ $user->name }}"
                   class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:outline-none focus:border-orange-500" required>
                   @error('name')
                       <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                   @enderror

            <input name="email"
                   value="{{ $user->email }}"
                   class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:outline-none focus:border-orange-500" disabled>

            <select name="role"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:outline-none focus:border-orange-500" required>

                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>

            </select>

            <!-- Password -->
            <div class="border-t border-zinc-800 pt-6">
                <p class="text-sm text-zinc-400 mb-4">
                    Change Password (optional)
                </p>

                <div class="space-y-4">
                    <input type="password"
                            name="password"
                            placeholder="New password"
                            class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:outline-none focus:border-orange-500">
                            @error('password')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror

                    <input type="password"
                            name="password_confirmation"
                            placeholder="Confirm password"
                            class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:outline-none focus:border-orange-500">
                            @error('password')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                </div>
            </div>

            <button class="px-4 py-2 rounded-xl bg-orange-500 text-white">
                Update User
            </button>

        </form>

    </main>

</div>
@endsection
