@php
    $passwordRequestCount = \App\Models\PasswordRequest::count();
@endphp

<div class="border-b border-white/10 px-6 py-6">
    <div class="flex items-center gap-3">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-orange-500 to-red-600 text-lg font-black text-white shadow-lg shadow-red-900/30">
            DK
        </div>
        <div>
            <p class="text-lg font-bold tracking-wide">D'Kampong</p>
            <p class="text-sm text-zinc-400">Media Analytics</p>
        </div>
    </div>
</div>

<nav class="flex-1 space-y-2 px-4 py-6 text-sm">

    <!-- Dashboard -->
    <a href="{{ route('dashboard') }}"
       class="flex items-center gap-3 rounded-xl px-4 py-3 font-medium text-white hover:bg-white/5">
        <span>📊</span>
        <span>Dashboard</span>
    </a>

    <!-- Homepage -->
    <a href="{{ route('landing') }}"
       class="flex items-center gap-3 rounded-xl px-4 py-3 font-medium text-white hover:bg-white/5">
        <span>🏠</span>
        <span>Homepage</span>
    </a>

    <!-- Users -->
    <a href="{{ route('admin.users.index') }}"
       class="flex items-center gap-3 rounded-xl px-4 py-3 font-medium text-white hover:bg-white/5">
        <span>👥</span>
        <span>Users</span>
    </a>

    {{-- <a href="{{ route('products.index') }}"
       class="flex items-center gap-3 rounded-xl px-4 py-3 font-medium text-white hover:bg-white/5">
        <span>🍕</span>
        <span>Products</span>
    </a>

    <a href="{{ route('orders.index') }}"
       class="flex items-center gap-3 rounded-xl px-4 py-3 font-medium text-white hover:bg-white/5">
        <span>🛒</span>
        <span>Orders</span>
    </a> --}}

    @php
        $pendingRequests = \App\Models\PasswordRequest::where('status', 'pending')->count();
    @endphp

    <a href="{{ route('admin.password-requests.index') }}"
    class="flex items-center justify-between gap-3 rounded-xl px-4 py-3 font-medium text-white hover:bg-white/5">

        <span class="flex items-center gap-3">
            <span>🔔</span>
            <span>Password Requests</span>
        </span>

        @if($pendingRequests > 0)
            <span class="text-xs bg-red-500 text-white px-2 py-0.5 rounded-full">
                {{ $pendingRequests }}
            </span>
        @endif

    </a>

    @if(Auth::check() && Auth::user()->role === 'admin')
        <a href="{{ route('admin.products.index') }}"
        class="flex items-center gap-3 rounded-xl px-4 py-3 font-medium text-white hover:bg-white/5">
            <span>📋</span>
            <span>Manage Products</span>
        </a>

        <a href="{{ route('admin.orders.index') }}"
        class="flex items-center gap-3 rounded-xl px-4 py-3 font-medium text-white hover:bg-white/5">
            <span>📦</span>
            <span>Manage Orders</span>
        </a>
    @endif

    @if(Auth::check())
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); this.closest('form').submit();"
            class="flex items-center gap-3 rounded-xl px-4 py-3 font-medium text-white hover:bg-white/5">
                <span>🚪</span>
                <span>Logout</span>
            </a>
        </form>
    @else
        <a href="{{ route('login') }}"
        class="flex items-center gap-3 rounded-xl px-4 py-3 font-medium text-white hover:bg-white/5">
            <span>🔑</span>
            <span>Login</span>
        </a>
    @endif

</nav>

@php
    $authUser = auth()->user();
@endphp

<div class="border-t border-white/10 p-4">
    <div class="rounded-2xl bg-gradient-to-br from-zinc-900 to-zinc-800 p-4 ring-1 ring-white/10">
        <p class="text-sm text-zinc-400">Logged in as</p>

        <p class="mt-1 font-semibold text-white">
            {{ $authUser->name ?? 'Guest' }}
        </p>

        <p class="text-sm text-zinc-500">
            {{ $authUser->email ?? '-' }}
        </p>
    </div>
</div>


