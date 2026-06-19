@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-zinc-950 text-zinc-100 flex">
    <aside class="hidden w-72 flex-col border-r border-white/10 bg-black/40 lg:flex">
        @include('layouts.sidebar')
    </aside>

    <main class="flex-1 p-6 space-y-6">
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
            <p class="text-sm uppercase tracking-widest text-orange-400">Admin Panel</p>
            <h1 class="mt-2 text-3xl font-bold text-white">🍕 Product Management</h1>
            <p class="mt-2 text-sm text-zinc-400">Manage your pizza menu</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                <p class="text-zinc-400 text-sm">Total Products</p>
                <p class="text-2xl font-bold text-white">{{ $products->count() }}</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                <p class="text-zinc-400 text-sm">Active Products</p>
                <p class="text-2xl font-bold text-white">{{ $products->where('is_active', true)->count() }}</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                <p class="text-zinc-400 text-sm">Categories</p>
                <p class="text-2xl font-bold text-white">{{ $products->pluck('category')->unique()->filter()->count() }}</p>
            </div>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/5 overflow-hidden">
            <div class="flex items-center justify-between p-5 border-b border-white/10">
                <h2 class="font-semibold text-white">All Products</h2>
                <a href="{{ route('admin.products.create') }}" class="px-4 py-2 rounded-xl bg-gradient-to-r from-orange-500 to-red-500 text-white text-sm font-semibold hover:opacity-90">
                    + Add Product
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-black/30 text-zinc-300">
                        <tr>
                            <th class="px-6 py-4 text-left">ID</th>
                            <th class="px-6 py-4 text-left">Image</th>
                            <th class="px-6 py-4 text-left">Name</th>
                            <th class="px-6 py-4 text-left">Category</th>
                            <th class="px-6 py-4 text-left">Price</th>
                            <th class="px-6 py-4 text-left">Status</th>
                            <th class="px-6 py-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr class="border-t border-white/10 hover:bg-white/5 transition">
                            <td class="px-6 py-4 text-zinc-400">#{{ $product->id }}</td>
                            <td class="px-6 py-4">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-10 h-10 rounded-lg object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-zinc-700 flex items-center justify-center text-xs">🍕</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium text-white">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-zinc-300">{{ $product->category ?? '-' }}</td>
                            <td class="px-6 py-4 text-orange-400 font-semibold">RM {{ number_format($product->price, 0) }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full {{ $product->is_active ? 'bg-green-500/20 text-green-300' : 'bg-zinc-500/20 text-zinc-300' }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-xs px-3 py-1 rounded-lg bg-orange-500/20 text-orange-300 hover:bg-orange-500/30">Edit</a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-xs px-3 py-1 rounded-lg bg-red-500/20 text-red-300 hover:bg-red-500/30">Delete</button>
                                </form>
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
