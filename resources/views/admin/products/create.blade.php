@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-zinc-950 text-zinc-100 flex">
    <aside class="hidden w-72 flex-col border-r border-white/10 bg-black/40 lg:flex">
        @include('layouts.sidebar')
    </aside>

    <main class="flex-1 p-6 space-y-6">
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
            <p class="text-sm uppercase tracking-widest text-orange-400">Admin Panel</p>
            <h1 class="mt-2 text-3xl font-bold text-white">Add Product</h1>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-6 max-w-2xl">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-2">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 rounded-xl bg-black/30 border border-white/10 text-white focus:outline-none focus:border-orange-500">
                    @error('name') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-2">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-3 rounded-xl bg-black/30 border border-white/10 text-white focus:outline-none focus:border-orange-500">{{ old('description') }}</textarea>
                    @error('description') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Price (RM)</label>
                        <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" required
                            class="w-full px-4 py-3 rounded-xl bg-black/30 border border-white/10 text-white focus:outline-none focus:border-orange-500">
                        @error('price') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Category</label>
                        <select name="category"
                            class="w-full px-4 py-3 rounded-xl bg-black/30 border border-white/10 text-white focus:outline-none focus:border-orange-500 appearance-none cursor-pointer">
                            <option value="" disabled {{ old('category') ? '' : 'selected' }} class="bg-zinc-900 text-zinc-400">
                                please select
                            </option>
                            <option value="Classic" {{ old('category') == 'Classic' ? 'selected' : '' }} class="bg-zinc-900 text-white">Classic</option>
                            <option value="Spicy"   {{ old('category') == 'Spicy'   ? 'selected' : '' }} class="bg-zinc-900 text-white">Spicy</option>
                            <option value="Vegetarian" {{ old('category') == 'Vegetarian' ? 'selected' : '' }} class="bg-zinc-900 text-white">Vegetarian</option>
                            <option value="Premium" {{ old('category') == 'Premium' ? 'selected' : '' }} class="bg-zinc-900 text-white">Premium</option>
                            {{-- Add more options as needed --}}
                        </select>
                        @error('category') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-2">Image</label>
                    <input type="file" name="image" accept="image/*"
                        class="w-full px-4 py-3 rounded-xl bg-black/30 border border-white/10 text-white file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-500/20 file:text-orange-300 file:text-sm">
                    @error('image') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" value="1" checked
                        class="w-4 h-4 rounded border-white/10 bg-black/30 text-orange-500 focus:ring-orange-500">
                    <label class="text-sm text-zinc-300">Active (visible on menu)</label>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-orange-500 to-red-500 text-white font-semibold hover:opacity-90">
                        Save Product
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="px-6 py-3 rounded-xl border border-white/10 text-zinc-300 hover:bg-white/5">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection
