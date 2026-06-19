<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)
            ->latest()
            ->get();

        $categories = $products->pluck('category')->unique()->filter();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'category' => ['nullable', 'string', 'max:100'],
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:3000',
            'is_active' => ['boolean'],
        ]);

if ($request->hasFile('image') && $request->file('image')->isValid()) {

    $image = $request->file('image');

    $filename = time() . '_' . $image->getClientOriginalName();

    $destination = public_path('products');

    if (!file_exists($destination)) {
        mkdir($destination, 0755, true);
    }

    $image->move($destination, $filename);

    $validated['image'] = 'products/' . $filename;
}
        $validated['is_active'] = $request->boolean('is_active', true);

        Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        $this->authorizeAdmin();

        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'category' => ['nullable', 'string', 'max:100'],
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:3000',
            'is_active' => ['boolean'],
            'remove_image' => ['boolean'],
        ]);

if ($product->image) {
    $oldPath = public_path($product->image);
    if (file_exists($oldPath)) {
        unlink($oldPath);
    }
}

if ($request->hasFile('image') && $request->file('image')->isValid()) {

    $image = $request->file('image');

    // delete old image
    if ($product->image) {
        $oldPath = public_path($product->image);
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }
    }

    $filename = time() . '_' . $image->getClientOriginalName();

    $destination = public_path('products');

    if (!file_exists($destination)) {
        mkdir($destination, 0755, true);
    }

    $image->move($destination, $filename);

    $validated['image'] = 'products/' . $filename;
}

        $validated['is_active'] = $request->boolean('is_active', true);

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $this->authorizeAdmin();

if ($product->image) {
    $oldPath = public_path($product->image);
    if (file_exists($oldPath)) {
        unlink($oldPath);
    }
}

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    public function adminIndex()
    {
        $this->authorizeAdmin();

        $products = Product::orderBy('id', 'desc')->get();

        return view('admin.products.index', compact('products'));
    }

    private function authorizeAdmin()
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);
    }
}
