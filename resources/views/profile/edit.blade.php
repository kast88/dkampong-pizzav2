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
                Manage your profile information
            </p>
        </div>

        <!-- Card -->
        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-8 shadow-xl">

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Cover Photo -->
                <div class="relative">
                    <div class="h-44 rounded-2xl relative flex flex-col items-center">

                        <!-- Profile Picture -->
                        <div class="w-28 h-28 rounded-full overflow-hidden bg-zinc-800 border-4 border-orange-500 shadow-lg">
                            @if(auth()->user()->profile_photo)
                                <img
                                    src="{{ asset('storage/'.auth()->user()->profile_photo) }}"
                                    class="w-full h-full object-cover"
                                    alt="Profile Photo">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-5xl">
                                    👤
                                </div>
                            @endif
                        </div>

                        <!-- Change Photo Button -->
                        <label class="mt-3 px-4 py-2 bg-orange-600 hover:bg-orange-700 rounded-lg text-xs cursor-pointer transition">
                            Change Photo
                            <input
                                type="file"
                                name="profile_photo"
                                accept="image/*"
                                class="hidden">
                        </label>
                    </div>
                </div>

                <!-- Name -->
                <div>
                    <label class="text-sm text-zinc-400">Name</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                        class="w-full mt-1 px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:outline-none focus:border-orange-500">
                    @error('name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="text-sm text-zinc-400">Email</label>
                    <input type="email" value="{{ auth()->user()->email }}"
                        class="w-full mt-1 px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-zinc-400 cursor-not-allowed"
                        disabled>
                    <p class="text-xs text-zinc-500 mt-2">
                        Email cannot be changed for security reasons
                    </p>
                </div>

                <!-- Password -->
                <div>
                    <p class="text-sm text-zinc-400 mb-4">
                        Change Password (optional)
                    </p>

                    <div class="space-y-4">
                        <input type="password" name="password" placeholder="New password"
                            class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:outline-none focus:border-orange-500">
                        @error('password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <input type="password" name="password_confirmation" placeholder="Confirm password"
                            class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:outline-none focus:border-orange-500">
                        @error('password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Bio -->
                <div>
                    <label class="text-sm text-zinc-400">Bio</label>
                    <textarea name="bio" rows="3"
                        class="w-full mt-1 px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white">{{ old('bio', auth()->user()->bio) }}</textarea>
                </div>

                <!-- Interests -->
                <div>
                    <label class="text-sm text-zinc-400">
                        Interests
                    </label>
                    <div class="grid grid-cols-2 gap-3 mt-3 text-sm">
                        <label>
                            <input
                            type="checkbox"
                            name="interests[]"
                            value="Food"

                            @checked(
                                in_array(
                                    'Food',
                                    old('interests', auth()->user()->interests ?? [])
                                ))
                            > Food
                        </label>
                        <label>
                            <input
                            type="checkbox"
                            name="interests[]"
                            value="Gaming"
                            Gaming

                            @checked(
                                in_array(
                                'Gaming',
                                    old('interests', auth()->user()->interests ?? [])
                                ))
                            > Gaming
                        </label>
                        <label>
                            <input
                            type="checkbox"
                            name="interests[]"
                            value="Technology"

                            @checked(
                                in_array(
                                'Technology',
                                    old('interests', auth()->user()->interests ?? [])
                                ))
                            > Technology
                        </label>
                        <label>
                            <input
                            type="checkbox"
                            name="interests[]"
                            value="Sports"

                            @checked(
                                in_array(
                                'Sports',
                                    old('interests', auth()->user()->interests ?? [])
                                ))
                            > Sports
                        </label>
                        <label>
                            <input
                            type="checkbox"
                            name="interests[]"
                            value="Travel"

                            @checked(
                                in_array(
                                'Travel',
                                    old('interests', auth()->user()->interests ?? [])
                                ))
                            > Travel
                        </label>
                        <label>
                             <input
                            type="checkbox"
                            name="interests[]"
                            value="Marketplace"

                            @checked(
                                in_array(
                                'Marketplace',
                                    old('interests', auth()->user()->interests ?? [])
                                ))
                            > Marketplace
                        </label>
                    </div>
                </div>

                <!-- Location -->
                <div>
                    <label class="text-sm text-zinc-400">
                        Location
                    </label>
                    <input type="text" name="location" placeholder="e.g. Kuala Lumpur"
                        value="{{ old('location',auth()->user()->location) }}"
                        class="w-full mt-1 px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white">
                </div>

                <div class="border-t border-zinc-800 pt-6">
                    <h2 class="font-semibold text-white mb-4">
                        Privacy Settings
                    </h2>

                    <div class="space-y-3 text-sm">

                        <label class="flex items-center gap-3">
                            <input
                                type="checkbox"
                                name="show_profile"
                                value="1"
                                @checked(auth()->user()->show_profile)
                            >

                            Show my profile publicly
                        </label>


                        <label class="flex items-center gap-3">
                            <input
                                type="checkbox"
                                name="allow_messages"
                                value="1"
                                @checked(auth()->user()->allow_messages)
                            >

                            Allow others to message me
                        </label>


                        <label class="flex items-center gap-3">
                            <input
                                type="checkbox"
                                name="show_location"
                                value="1"
                                @checked(auth()->user()->show_location)
                            >

                            Show my location
                        </label>

                    </div>
                </div>

                <div class="border-t border-zinc-800 pt-6">
                    <h2 class="font-semibold text-white mb-4">
                        Community Statistics
                    </h2>
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <p class="text-2xl font-bold">
                                24
                            </p>
                            <p class="text-zinc-500 text-sm">
                                Posts
                            </p>
                        </div>

                        <div>
                            <p class="text-2xl font-bold">
                                420
                            </p>
                            <p class="text-zinc-500 text-sm">
                                Reactions
                            </p>
                        </div>

                        <div>
                            <p class="text-2xl font-bold">
                                {{ $badge->icon }}
                                {{ $badge->name }}
                            </p>
                            <p class="text-zinc-500 text-sm">
                                Member
                            </p>
                        </div>
                    </div>
                </div>

                <div class="text-center text-zinc-500 text-sm">
                    Member since
                    January 2026
                </div>

                <!-- Save Button -->
                <div class="pt-6 flex justify-between items-center gap-4">
                    <!-- Back Button -->
                    <a href="{{ url('/') }}"
                        class="group flex items-center gap-2 px-5 py-3 rounded-xl
                            bg-gradient-to-r from-zinc-800 via-slate-700 to-blue-900
                            text-white font-semibold
                            border border-blue-500/30
                            hover:from-blue-700 hover:via-indigo-700 hover:to-purple-800
                            hover:border-blue-400
                            transition-all duration-300
                            shadow-lg shadow-blue-900/30
                            hover:shadow-blue-500/40
                            hover:-translate-y-1">
                        <span class="group-hover:-translate-x-1 transition-transform duration-300">
                            ←
                        </span>
                        Homepage
                    </a>

                    <!-- Community Button -->
                    <a href="{{ url('/community') }}"
                        class="group flex items-center gap-2 px-6 py-3 rounded-xl
                            bg-gradient-to-r from-blue-500 to-indigo-600
                            text-white font-semibold
                            hover:from-blue-600 hover:to-indigo-700
                            transition-all duration-300
                            shadow-lg shadow-blue-500/30
                            hover:shadow-blue-500/50
                            hover:-translate-y-1">
                        Community Page
                        <span class="group-hover:translate-x-1 transition-transform duration-300">
                            →
                        </span>
                    </a>

                    <!-- Save Button -->
                    <button type="submit"
                        class="group flex items-center gap-2 px-7 py-3 rounded-xl
                            bg-gradient-to-r from-orange-500 to-red-600
                            text-white font-bold
                            hover:from-orange-600 hover:to-red-700
                            transition-all duration-300
                            shadow-lg shadow-orange-500/40
                            hover:shadow-orange-500/60
                            hover:-translate-y-1">
                        <span class="group-hover:rotate-12 transition-transform duration-300">
                            💾
                        </span>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
