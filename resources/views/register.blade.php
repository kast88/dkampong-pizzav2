<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - {{ config('app.name', 'Laravel') }}</title>

    <!-- Tailwind CDN (same as login page) -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style type="text/tailwindcss">
        @theme {
            --color-brand-500: #f97316;
            --color-brand-600: #ea580c;
        }
    </style>
</head>

<body class="min-h-screen bg-neutral-100 flex items-center justify-center">

<div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">

    <h1 class="text-2xl font-bold mb-6 text-center">
        Create Account
    </h1>

    @if ($errors->any())
        <div class="mb-4 text-sm text-red-600 bg-red-50 p-3 rounded-xl">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <input
            type="text"
            name="name"
            value="{{ old('name') }}"
            placeholder="Full Name"
            class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-orange-200"
            required
        >

        <!-- Email -->
        <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            placeholder="Email"
            class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-orange-200"
            required
        >

        <!-- Password -->
        <input
            type="password"
            name="password"
            placeholder="Password"
            class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-orange-200"
            required
        >

        <!-- Confirm Password -->
        <input
            type="password"
            name="password_confirmation"
            placeholder="Confirm Password"
            class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-orange-200"
            required
        >

        <!-- Submit -->
        <button
            type="submit"
            class="w-full bg-orange-600 hover:bg-orange-700 text-white py-3 rounded-xl font-semibold"
        >
            Register
        </button>

        <!-- Back -->
        <a
            href="{{ route('login') }}"
            class="block text-center text-sm text-orange-600 mt-3"
        >
            Already have an account? Login
        </a>

    </form>

</div>

</body>
</html>
