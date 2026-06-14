@extends('layouts.app', ['title' => 'Cart - D\'Kampong Pizza'])

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
                    <a href="{{ route('cart.index') }}" class="relative px-3 py-2 bg-orange-800 hover:bg-zinc-700 rounded-full text-white">
                        🛒
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-xs w-5 h-5 rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('orders.index') }}" class="hover:text-orange-400 transition">📦 Orders</a>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2 bg-orange-600 hover:bg-orange-700 rounded-lg font-semibold transition">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-16">
        <h1 class="text-4xl font-bold text-white mb-10">🛒 Your Cart</h1>

        @if(!$items || $items->isEmpty())
            <div class="text-center py-20">
                <p class="text-zinc-400 text-lg mb-6">Your cart is empty.</p>
                <a href="{{ route('products.index') }}" class="px-6 py-3 rounded-xl bg-gradient-to-r from-orange-500 to-red-500 text-white font-semibold hover:opacity-90">Browse Menu</a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($items as $item)
                    <div class="flex items-center gap-4 p-4 rounded-2xl border border-zinc-800 bg-zinc-900">
                        <div class="w-16 h-16 rounded-xl bg-zinc-800 overflow-hidden flex-shrink-0">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-2xl">🍕</div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <h3 class="text-white font-semibold truncate">{{ $item->product->name }}</h3>
                            <p class="text-orange-400 text-sm">RM {{ number_format($item->product->price, 0) }} each</p>
                        </div>

                        <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-1">
                            @csrf
                            @method('PATCH')
                            <button type="button" onclick="this.nextElementSibling.stepDown(); this.form.submit()" class="w-8 h-8 rounded-lg bg-zinc-800 text-white hover:bg-zinc-700 flex items-center justify-center">−</button>
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="99" readonly class="w-12 text-center bg-transparent text-white text-sm border-0 focus:outline-none">
                            <button type="button" onclick="this.previousElementSibling.stepUp(); this.form.submit()" class="w-8 h-8 rounded-lg bg-zinc-800 text-white hover:bg-zinc-700 flex items-center justify-center">+</button>
                        </form>

                        <p class="text-white font-bold w-20 text-right">RM {{ number_format($item->product->price * $item->quantity, 0) }}</p>

                        <form method="POST" action="{{ route('cart.remove', $item) }}" class="flex-shrink-0">
                            @csrf
                            @method('DELETE')
                            <button class="w-8 h-8 rounded-lg bg-red-500/20 text-red-400 hover:bg-red-500/30 flex items-center justify-center text-sm">✕</button>
                        </form>
                    </div>
                @endforeach

                <div class="flex justify-between items-center pt-6 border-t border-zinc-800">
                    <div>
                        <p class="text-zinc-400 text-sm">Total</p>
                        <p class="text-orange-400 font-bold text-2xl">RM {{ number_format($total, 0) }}</p>
                    </div>
                    <div class="flex gap-3">
                        <form method="POST" action="{{ route('cart.destroy') }}" onsubmit="return confirm('Clear your cart?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-4 py-3 rounded-xl border border-zinc-700 text-zinc-400 hover:text-white hover:border-red-500 transition">Clear Cart</button>
                        </form>
                        <a href="{{ route('checkout.create') }}" class="px-8 py-3 rounded-xl bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold hover:opacity-90 transition">Checkout →</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
