@extends('layouts.app', ['title' => 'Order #' . $order->id . ' - D\'Kampong Pizza'])

@section('content')
<div class="min-h-screen bg-zinc-950">
    <nav class="w-full backdrop-blur-md bg-zinc-950/80 border-b border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="{{ route('landing') }}" class="text-2xl font-bold bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">🍕 D'Kampong Pizza</a>
            <a href="{{ route('orders.index') }}" class="text-zinc-300 hover:text-orange-400 transition">← My Orders</a>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-16">
        <div class="flex items-center justify-between mb-10">
            <h1 class="text-3xl font-bold text-white">Order #{{ $order->id }}</h1>
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                @if($order->status === 'pending') bg-yellow-500/20 text-yellow-400
                @elseif($order->status === 'preparing') bg-blue-500/20 text-blue-400
                @elseif($order->status === 'delivered') bg-green-500/20 text-green-400
                @elseif($order->status === 'cancelled') bg-red-500/20 text-red-400
                @endif
            ">{{ ucfirst($order->status) }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-5">
                <p class="text-sm text-zinc-400 mb-1">Payment Method</p>
                <p class="text-white font-semibold">{{ ucfirst($order->payment_method ?? '-') }}</p>
            </div>
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-5">
                <p class="text-sm text-zinc-400 mb-1">Order Date</p>
                <p class="text-white font-semibold">{{ $order->created_at->format('d M Y, h:i A') }}</p>
            </div>
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-5">
                <p class="text-sm text-zinc-400 mb-1">Total</p>
                <p class="text-orange-400 font-bold text-xl">RM {{ number_format($order->total_price, 0) }}</p>
            </div>
        </div>

        <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-5 mb-8">
            <p class="text-sm text-zinc-400 mb-1">Delivery Address</p>
            <p class="text-white">{{ $order->delivery_address }}</p>
        </div>

        <div class="rounded-2xl border border-zinc-800 bg-zinc-900 overflow-hidden">
            <h2 class="text-lg font-semibold text-white p-5 border-b border-zinc-800">Items</h2>
            <div class="divide-y divide-zinc-800">
                @foreach($order->items as $item)
                    <div class="flex items-center gap-4 p-5">
                        <div class="w-12 h-12 rounded-lg bg-zinc-800 overflow-hidden flex-shrink-0">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">🍕</div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="text-white font-semibold">{{ $item->product->name }}</h3>
                            <p class="text-zinc-400 text-sm">RM {{ number_format($item->price, 0) }} x {{ $item->quantity }}</p>
                        </div>
                        <p class="text-white font-bold">RM {{ number_format($item->price * $item->quantity, 0) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
