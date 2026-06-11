@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-zinc-950 text-white flex">

    <!-- Sidebar -->
    <aside class="hidden w-72 flex-col border-r border-white/10 bg-black/40 lg:flex">
        @include('layouts.sidebar')
    </aside>

    <!-- Main -->
    <main class="flex-1 p-6">

        <div class="max-w-2xl mx-auto space-y-6">

            <h1 class="text-3xl font-bold">➕ Create User</h1>
            <p class="text-zinc-400">Admin can create a new user account</p>

            <form method="POST" action="{{ route('admin.users.store') }}"
                  class="space-y-4">

                @csrf

                <!-- Name -->
                <input type="text"
                       name="name"
                       placeholder="Name"
                       class="w-full p-3 rounded-xl bg-black/30 border border-white/10 text-white" required>

                <!-- Email -->
                <input type="email"
                       name="email"
                       placeholder="Email"
                       class="w-full p-3 rounded-xl bg-black/30 border border-white/10 text-white" required>

                <!-- Password -->
                <input type="password"
                       name="password"
                       placeholder="Password"
                       class="w-full p-3 rounded-xl bg-black/30 border border-white/10 text-white" required>

                <!-- Confirm Password -->
                <input
                    type="password"
                    name="password_confirmation"
                    placeholder="Confirm Password"
                    class="w-full p-3 rounded-xl bg-black/30 border border-white/10 text-white" required>

                <!-- Role -->
                <select name="role"
                        class="w-full p-3 rounded-xl bg-black/30 border border-white/10 text-white" required>

                    <option value="user">User</option>
                    <option value="admin">Admin</option>

                </select>

                <!-- Submit -->
                <button type="submit"
                        class="px-6 py-3 rounded-xl bg-gradient-to-r from-orange-500 to-red-500 font-semibold">
                    Create User
                </button>

            </form>

        </div>

    </main>

</div>

@endsection
