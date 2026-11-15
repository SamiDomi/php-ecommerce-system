<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Support\Str;

class CheckoutController
{
    public function create(): View|RedirectResponse
    {
        if (empty(session('cart', []))) {
            return redirect()->route('store.index')->with('status', 'Your cart is empty.');
        }

        $products = Product::query()->whereIn('id', array_keys(session('cart')))->get()->keyBy('id');
        $subtotal = $products->sum(fn (Product $product) => $product->price_cents * session('cart')[$product->id]);

        return view('checkout.create', compact('products', 'subtotal'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:160'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:40'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:120'],
            'postal_code' => ['required', 'string', 'max:30'],
            'country' => ['required', 'string', 'max:100'],
        ]);
        $cart = session('cart', []);
        if ($cart === []) {
            return redirect()->route('store.index')->with('status', 'Your cart is empty.');
        }

        $order = DB::transaction(function () use ($cart, $data): Order {
            $products = Product::query()->whereIn('id', array_keys($cart))->orderBy('id')->lockForUpdate()->get()->keyBy('id');
            if ($products->count() !== count($cart)) {
                throw ValidationException::withMessages(['cart' => 'One or more products are no longer available. Please review your cart.']);
            }

            $subtotal = 0;
            foreach ($cart as $productId => $quantity) {
                $product = $products->get($productId);
                if (! $product->is_active || $product->stock < $quantity) {
                    throw ValidationException::withMessages(['cart' => "Not enough stock for {$product->name}. Please update your cart."]);
                }
                $subtotal += $product->price_cents * $quantity;
            }

            $order = Order::create([
                ...$data,
                'order_number' => 'ORD-'.Str::upper(Str::random(10)),
                'subtotal_cents' => $subtotal,
                'shipping_cents' => 0,
                'total_cents' => $subtotal,
                'status' => 'pending',
            ]);

            foreach ($cart as $productId => $quantity) {
                $product = $products->get($productId);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $quantity,
                    'unit_price_cents' => $product->price_cents,
                ]);
                $product->decrement('stock', $quantity);
            }

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('orders.success', $order)->with('order_number', $order->order_number);
    }

    public function success(Order $order): View
    {
        abort_unless(session('order_number') === $order->order_number, 403);

        return view('checkout.success', ['order' => $order->load('items')]);
    }
}
