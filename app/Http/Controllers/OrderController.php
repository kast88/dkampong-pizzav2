<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.product')
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $user = auth()->user();
        $cart = $user->cart;

        if (!$cart || $cart->items()->count() === 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $items = $cart->items()->with('product')->get();
        $total = $items->sum(fn($item) => $item->product->price * $item->quantity);

        $badge = $user->badges()->latest()->first();
        $discount = $badge?->discount ?? 0;
        $discountAmount = ($total * $discount) / 100;
        $finalTotal = $total - $discountAmount;

        return view('orders.checkout', compact(
            'items',
            'total',
            'badge',
            'discount',
            'discountAmount',
            'finalTotal'
        ));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $cart = $user->cart;

        if (!$cart || $cart->items()->count() === 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'delivery_address' => ['required', 'string', 'max:500'],
            'payment_method' => ['required', 'string', 'in:cash,card,online'],
        ]);

        $items = $cart->items()->with('product')->get();
        $total = $items->sum(fn($item) => $item->product->price * $item->quantity);

        $badge = $user->badges()->latest()->first();
        $discount = $badge?->discount ?? 0;
        $discountAmount = ($total * $discount) / 100;
        $finalTotal = $total - $discountAmount;

        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'total_price' => $finalTotal,
            'payment_method' => $validated['payment_method'],
            'delivery_address' => $validated['delivery_address'],
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        $cart->items()->delete();
        $cart->delete();

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order placed successfully!');
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    public function adminIndex()
    {
        $this->authorizeAdmin();

        $orders = Order::with(['user', 'items.product'])
            ->latest()
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function adminShow(Order $order)
    {
        $this->authorizeAdmin();

        $order->load(['user', 'items.product']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,preparing,delivered,cancelled'],
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Order status updated.');
    }

    private function authorizeAdmin()
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);
    }
}
