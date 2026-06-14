@extends('layouts.app', ['title' => 'My Orders - D\'Kampong Pizza'])

@section('content')
<div class="min-h-screen bg-zinc-950">

    <nav class="w-full top-0 z-[999] relative backdrop-blur-md bg-zinc-950/80 border-b border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="{{ route('landing') }}" class="text-2xl font-bold bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">🍕 D'Kampong Pizza</a>
            <div class="hidden md:flex gap-8 text-zinc-300 font-semibold items-center">
                <a href="{{ route('landing') }}" class="hover:text-orange-400 transition">Home</a>
                <a href="{{ route('products.index') }}" class="hover:text-orange-400 transition">Menu </a>
                @auth
                    @php $cartCount = auth()->user()->cart?->items->sum('quantity') ?? 0; @endphp
                    <a href="{{ route('cart.index') }}" class="relative px-3 py-2 bg-zinc-800 hover:bg-zinc-700 rounded-full text-white">
                        🛒
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-xs w-5 h-5 rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('orders.index') }}" class="text-orange-400 transition">📦 Orders</a>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2 bg-orange-600 hover:bg-orange-700 rounded-lg font-semibold transition">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-16">
        <h1 class="text-4xl font-bold text-white mb-10">📦 My Orders</h1>

        @forelse($orders as $order)
            <a href="{{ route('orders.show', $order) }}" class="block p-5 mb-4 rounded-2xl border border-zinc-800 bg-zinc-900 hover:border-orange-500/50 transition">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <span class="text-white font-bold">Order #{{ $order->id }}</span>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @if($order->status === 'pending') bg-yellow-500/20 text-yellow-400
                            @elseif($order->status === 'preparing') bg-blue-500/20 text-blue-400
                            @elseif($order->status === 'delivered') bg-green-500/20 text-green-400
                            @elseif($order->status === 'cancelled') bg-red-500/20 text-red-400
                            @endif
                        ">{{ ucfirst($order->status) }}</span>
                    </div>
                    <span class="text-orange-400 font-bold">RM {{ number_format($order->total_price, 0) }}</span>
                </div>
                <div class="flex items-center justify-between text-sm text-zinc-400">
                    <span>{{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}</span>
                    <span>{{ $order->created_at->format('d M Y, h:i A') }}</span>
                </div>
            </a>
        @empty
            <div class="text-center py-20">
                <p class="text-zinc-400 text-lg mb-6">No orders yet.</p>
                <a href="{{ route('products.index') }}" class="px-6 py-3 rounded-xl bg-gradient-to-r from-orange-500 to-red-500 text-white font-semibold hover:opacity-90">Start Ordering</a>
            </div>
        @endforelse
    </div>
</div>
@endsection
