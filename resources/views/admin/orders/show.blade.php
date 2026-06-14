@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-zinc-950 text-zinc-100 flex">
    <aside class="hidden w-72 flex-col border-r border-white/10 bg-black/40 lg:flex">
        @include('layouts.sidebar')
    </aside>

    <main class="flex-1 p-6 space-y-6">
        <div class="flex items-center justify-between">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur flex-1">
                <p class="text-sm uppercase tracking-widest text-orange-400">Admin Panel</p>
                <h1 class="mt-2 text-3xl font-bold text-white">Order #{{ $order->id }}</h1>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="ml-4 px-4 py-2 rounded-xl border border-white/10 text-zinc-300 hover:bg-white/5">← All Orders</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                <p class="text-zinc-400 text-sm">Customer</p>
                <p class="text-white font-semibold">{{ $order->user->name ?? '-' }}</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                <p class="text-zinc-400 text-sm">Payment</p>
                <p class="text-white font-semibold">{{ ucfirst($order->payment_method ?? '-') }}</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                <p class="text-zinc-400 text-sm">Date</p>
                <p class="text-white font-semibold">{{ $order->created_at->format('d M Y, h:i A') }}</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                <p class="text-zinc-400 text-sm">Total</p>
                <p class="text-orange-400 font-bold text-xl">RM {{ number_format($order->total_price, 0) }}</p>
            </div>
        </div>

        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
            <p class="text-sm text-zinc-400 mb-1">Delivery Address</p>
            <p class="text-white">{{ $order->delivery_address }}</p>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/5 overflow-hidden">
            <div class="flex items-center justify-between p-5 border-b border-white/10">
                <h2 class="font-semibold text-white">Items</h2>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-zinc-400">Update Status:</span>
                    <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="flex items-center gap-2">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()"
                            class="px-4 py-2 rounded-xl bg-black/30 border border-white/10 text-white text-sm focus:outline-none focus:border-orange-500">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Preparing</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="divide-y divide-white/10">
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
    </main>
</div>
@endsection
