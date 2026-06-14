@extends('layouts.app', ['title' => 'Menu - D\'Kampong Pizza'])

@section('content')
<div class="min-h-screen bg-zinc-950">

    <nav class="w-full top-0 z-[999] relative backdrop-blur-md bg-zinc-950/80 border-b border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">
                🍕 D'Kampong Pizza
            </div>
            <div class="hidden md:flex gap-8 text-zinc-300 font-semibold items-center">
                <a href="{{ route('landing') }}" class="hover:text-orange-400 transition">Home</a>
                <a href="#menu" class="text-orange-400 transition">Menu</a>
                @auth
                    @php $cartCount = auth()->user()->cart?->items->sum('quantity') ?? 0; @endphp
                    <a href="{{ route('cart.index') }}" class="relative px-3 py-2 bg-zinc-800 hover:bg-zinc-700 rounded-full text-white">
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

    <div id="menu" class="py-20 px-4 relative" style="background-image: url('/menu.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold">
                    <span class="bg-gradient-to-r from-orange-400 to-red-500 bg-clip-text text-transparent">Our Menu</span>
                </h2>
            </div>

            <div class="flex flex-wrap justify-center gap-3 mb-12">
                <button class="filter-btn active px-6 py-2 rounded-full font-semibold border border-orange-500 bg-orange-500/20 text-orange-400 transition" data-filter="*">All</button>
                @foreach($categories as $cat)
                    <button class="filter-btn px-6 py-2 rounded-full font-semibold border border-zinc-600 text-zinc-300 transition hover:border-orange-500 hover:text-orange-400" data-filter=".{{ Str::slug($cat) }}">{{ $cat }}</button>
                @endforeach
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 menu-items-container">
                @foreach($products as $product)
                    <div class="menu-item all {{ Str::slug($product->category) }}">
                        <div class="rounded-lg overflow-hidden border border-zinc-700 bg-zinc-800/50 hover:border-orange-500/50 transition-all transform hover:scale-105">
                            <div class="w-full h-64 bg-gradient-to-br from-zinc-700 to-zinc-800 flex items-center justify-center relative overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-br from-orange-500/10 to-red-500/10"></div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-white mb-2">{{ $product->name }}</h3>
                                <p class="text-zinc-400 text-sm mb-4">{{ $product->description }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-orange-400 font-bold text-lg">RM {{ number_format($product->price, 0) }}</span>
                                    @auth
                                        <form method="POST" action="{{ route('cart.add', $product) }}">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 rounded-lg font-semibold transition text-sm">
                                                Add to Cart 🛒
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 rounded-lg font-semibold transition text-sm">
                                            Login to Order
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($products->isEmpty())
                <p class="text-center text-zinc-400 py-12">No products available yet.</p>
            @endif
        </div>
    </div>

</div>

<style>
    .menu-item.hidden { display: none; opacity: 0; }
    .filter-btn.active { }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const menuItems = document.querySelectorAll('.menu-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => {
                    b.classList.remove('active', 'border-orange-500', 'bg-orange-500/20', 'text-orange-400');
                    b.classList.add('border-zinc-600', 'text-zinc-300');
                });
                this.classList.add('active', 'border-orange-500', 'bg-orange-500/20', 'text-orange-400');
                this.classList.remove('border-zinc-600', 'text-zinc-300');

                const filterValue = this.getAttribute('data-filter');
                menuItems.forEach(item => {
                    if (filterValue === '*' || item.classList.contains(filterValue.substring(1))) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                });
            });
        });
    });
</script>
@endsection
