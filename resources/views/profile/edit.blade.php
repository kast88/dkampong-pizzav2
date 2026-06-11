@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-zinc-950 via-zinc-900 to-zinc-950 py-16 px-4">

    <div class="max-w-3xl mx-auto">

        <!-- Header -->
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-bold text-white">
                Edit Profile
            </h1>
            <p class="text-zinc-400 mt-2">
                Manage your account information
            </p>
        </div>

        <!-- Card -->
        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-8 shadow-xl">

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div>
                    <label class="text-sm text-zinc-400">Name</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', auth()->user()->name) }}"
                           class="w-full mt-1 px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:outline-none focus:border-orange-500">
                           @error('name')
                              <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                           @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="text-sm text-zinc-400">Email</label>

                    <input type="email"
                        value="{{ auth()->user()->email }}"
                        class="w-full mt-1 px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-zinc-400 cursor-not-allowed"
                        disabled>

                    <p class="text-xs text-zinc-500 mt-2">
                        Email cannot be changed for security reasons
                    </p>
                </div>

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

                <!-- Save Button -->
                <div class="pt-6 flex justify-between items-center">

                    <a href="{{ url('/') }}"
                       class="text-zinc-400 hover:text-white transition">
                        ← Back
                    </a>

                    <button type="submit"
                            class="px-6 py-3 bg-orange-600 hover:bg-orange-700 rounded-lg font-semibold text-white transition">
                        Save Changes
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>
@endsection
