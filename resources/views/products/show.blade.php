@extends('layouts.app', ['title' => $product->name . ' - D\'Kampong Pizza'])

@section('content')
<div class="min-h-screen bg-zinc-950">
    <nav class="w-full backdrop-blur-md bg-zinc-950/80 border-b border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="{{ route('landing') }}" class="text-2xl font-bold bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">🍕 D'Kampong Pizza</a>
            <div class="flex gap-4">
                <a href="{{ route('products.index') }}" class="text-zinc-300 hover:text-orange-400 transition">← Menu</a>
                @auth
                    @php $cartCount = auth()->user()->cart?->items->sum('quantity') ?? 0; @endphp
                    <a href="{{ route('cart.index') }}" class="relative px-3 py-2 bg-zinc-800 hover:bg-zinc-700 rounded-full text-white">
                        🛒
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-xs w-5 h-5 rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="w-full h-96 bg-zinc-800 rounded-2xl overflow-hidden relative">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover">
                @endif
                <div class="absolute inset-0 bg-gradient-to-br from-orange-500/10 to-red-500/10"></div>
            </div>

            <div class="space-y-6">
                @if($product->category)
                    <span class="px-3 py-1 text-xs rounded-full bg-orange-500/20 text-orange-300">{{ $product->category }}</span>
                @endif
                <h1 class="text-4xl font-bold text-white">{{ $product->name }}</h1>
                <p class="text-zinc-400 text-lg leading-relaxed">{{ $product->description }}</p>
                <p class="text-orange-400 font-bold text-3xl">RM {{ number_format($product->price, 0) }}</p>

                @auth
                    <form method="POST" action="{{ route('cart.add', $product) }}">
                        @csrf
                        <button type="submit" class="px-8 py-4 bg-gradient-to-r from-orange-600 to-red-600 rounded-xl font-bold text-lg text-white hover:opacity-90 transition">
                            Add to Cart 🛒
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="inline-block px-8 py-4 bg-gradient-to-r from-orange-600 to-red-600 rounded-xl font-bold text-lg text-white hover:opacity-90 transition">
                        Login to Order
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
