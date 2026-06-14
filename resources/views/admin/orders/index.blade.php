@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-zinc-950 text-zinc-100 flex">
    <aside class="hidden w-72 flex-col border-r border-white/10 bg-black/40 lg:flex">
        @include('layouts.sidebar')
    </aside>

    <main class="flex-1 p-6 space-y-6">
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
            <p class="text-sm uppercase tracking-widest text-orange-400">Admin Panel</p>
            <h1 class="mt-2 text-3xl font-bold text-white">📦 Order Management</h1>
            <p class="mt-2 text-sm text-zinc-400">View and manage all customer orders</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                <p class="text-zinc-400 text-sm">Total Orders</p>
                <p class="text-2xl font-bold text-white">{{ $orders->count() }}</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                <p class="text-zinc-400 text-sm">Pending</p>
                <p class="text-2xl font-bold text-yellow-400">{{ $orders->where('status', 'pending')->count() }}</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                <p class="text-zinc-400 text-sm">Preparing</p>
                <p class="text-2xl font-bold text-blue-400">{{ $orders->where('status', 'preparing')->count() }}</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                <p class="text-zinc-400 text-sm">Delivered</p>
                <p class="text-2xl font-bold text-green-400">{{ $orders->where('status', 'delivered')->count() }}</p>
            </div>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/5 overflow-hidden">
            <div class="p-5 border-b border-white/10">
                <h2 class="font-semibold text-white">All Orders</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-black/30 text-zinc-300">
                        <tr>
                            <th class="px-6 py-4 text-left">Order ID</th>
                            <th class="px-6 py-4 text-left">Customer</th>
                            <th class="px-6 py-4 text-left">Total</th>
                            <th class="px-6 py-4 text-left">Payment</th>
                            <th class="px-6 py-4 text-left">Status</th>
                            <th class="px-6 py-4 text-left">Date</th>
                            <th class="px-6 py-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr class="border-t border-white/10 hover:bg-white/5 transition">
                            <td class="px-6 py-4 text-zinc-400">#{{ $order->id }}</td>
                            <td class="px-6 py-4 font-medium text-white">{{ $order->user->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-orange-400 font-semibold">RM {{ number_format($order->total_price, 0) }}</td>
                            <td class="px-6 py-4 text-zinc-300">{{ ucfirst($order->payment_method ?? '-') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full
                                    @if($order->status === 'pending') bg-yellow-500/20 text-yellow-400
                                    @elseif($order->status === 'preparing') bg-blue-500/20 text-blue-400
                                    @elseif($order->status === 'delivered') bg-green-500/20 text-green-400
                                    @elseif($order->status === 'cancelled') bg-red-500/20 text-red-400
                                    @endif
                                ">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td class="px-6 py-4 text-zinc-400">{{ $order->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-xs px-3 py-1 rounded-lg bg-white/10 hover:bg-white/20">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection
