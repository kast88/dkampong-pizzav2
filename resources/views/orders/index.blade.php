@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-zinc-950 text-white p-10">

    <h1 class="text-3xl font-bold mb-6">My Orders</h1>

    @forelse($orders as $order)
        <div class="p-4 mb-4 bg-zinc-900 border border-zinc-800 rounded-lg">
            <p>Order #{{ $order->id }}</p>
            <p>Status: {{ $order->status }}</p>
            <p>Total: RM {{ $order->total_price }}</p>
        </div>
    @empty
        <p class="text-zinc-400">No orders yet.</p>
    @endforelse

</div>
@endsection
