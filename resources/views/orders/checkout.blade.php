@extends('layouts.app', ['title' => 'Checkout - D\'Kampong Pizza'])

@section('content')
<div class="min-h-screen bg-zinc-950">
    <nav class="w-full backdrop-blur-md bg-zinc-950/80 border-b border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="{{ route('landing') }}" class="text-2xl font-bold bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">🍕 D'Kampong Pizza</a>
            <a href="{{ route('cart.index') }}" class="text-zinc-300 hover:text-orange-400 transition">← Back to Cart</a>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-16">
        <h1 class="text-4xl font-bold text-white mb-10">📋 Checkout</h1>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            <div class="lg:col-span-3 space-y-6">
                <form method="POST" action="{{ route('orders.store') }}" class="space-y-6">
                    @csrf

                    <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">
                        <h2 class="text-lg font-semibold text-white mb-4">Delivery Address</h2>
                        <textarea name="delivery_address" rows="3" required placeholder="Enter your full delivery address..."
                            class="w-full px-4 py-3 rounded-xl bg-black/30 border border-white/10 text-white focus:outline-none focus:border-orange-500">{{ old('delivery_address') }}</textarea>
                        @error('delivery_address') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">
                        <h2 class="text-lg font-semibold text-white mb-4">Payment Method</h2>
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 p-3 rounded-xl border border-zinc-700 hover:border-orange-500 cursor-pointer {{ old('payment_method') === 'cash' ? 'border-orange-500 bg-orange-500/10' : '' }}">
                                <input type="radio" name="payment_method" value="cash" {{ old('payment_method', 'cash') === 'cash' ? 'checked' : '' }} class="text-orange-500">
                                <span class="text-white">💵 Cash on Delivery</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 rounded-xl border border-zinc-700 hover:border-orange-500 cursor-pointer {{ old('payment_method') === 'card' ? 'border-orange-500 bg-orange-500/10' : '' }}">
                                <input type="radio" name="payment_method" value="card" {{ old('payment_method') === 'card' ? 'checked' : '' }} class="text-orange-500">
                                <span class="text-white">💳 Card</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 rounded-xl border border-zinc-700 hover:border-orange-500 cursor-pointer {{ old('payment_method') === 'online' ? 'border-orange-500 bg-orange-500/10' : '' }}">
                                <input type="radio" name="payment_method" value="online" {{ old('payment_method') === 'online' ? 'checked' : '' }} class="text-orange-500">
                                <span class="text-white">📱 Online Banking</span>
                            </label>
                        </div>
                        @error('payment_method') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full px-8 py-4 rounded-xl bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold text-lg hover:opacity-90 transition">
                        Place Order — RM {{ number_format($total, 0) }}
                    </button>
                </form>
            </div>

            <div class="lg:col-span-2">
                <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6 sticky top-4">
                    <h2 class="text-lg font-semibold text-white mb-4">Order Summary</h2>
                    <div class="space-y-3 mb-4">
                        @foreach($items as $item)
                            <div class="flex justify-between text-sm">
                                <span class="text-zinc-300">{{ $item->quantity }}x {{ $item->product->name }}</span>
                                <span class="text-white">RM {{ number_format($item->product->price * $item->quantity, 0) }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="border-t border-zinc-800 pt-3 flex justify-between font-bold">
                        <span class="text-white">Total</span>
                        <span class="text-orange-400">RM {{ number_format($total, 0) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
