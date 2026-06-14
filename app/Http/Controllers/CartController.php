<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request, Product $product)
    {
        $user = auth()->user();

        $cart = Cart::firstOrCreate([
            'user_id' => $user->id
        ]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            $item->quantity += 1;
            $item->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        return back()->with('success', 'Added to cart!');
    }

    public function index()
    {
        $user = auth()->user();
        $cart = $user->cart;

        if (!$cart) {
            return view('cart.index', ['cart' => null, 'items' => collect([]), 'total' => 0]);
        }

        $items = $cart->items()->with('product')->get();
        $total = $items->sum(fn($item) => $item->product->price * $item->quantity);

        return view('cart.index', compact('cart', 'items', 'total'));
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $this->authorizeCartItem($cartItem);

        $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated.');
    }

    public function remove(CartItem $cartItem)
    {
        $this->authorizeCartItem($cartItem);

        $cartItem->delete();

        return back()->with('success', 'Item removed from cart.');
    }

    public function destroy()
    {
        $user = auth()->user();

        if ($user->cart) {
            $user->cart->items()->delete();
            $user->cart->delete();
        }

        return back()->with('success', 'Cart cleared.');
    }

    private function authorizeCartItem(CartItem $cartItem)
    {
        abort_unless(
            $cartItem->cart && $cartItem->cart->user_id === auth()->id(),
            403
        );
    }
}
