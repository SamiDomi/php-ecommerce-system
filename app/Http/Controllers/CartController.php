<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController
{
    public function index(): View
    {
        $cart = $this->cartProducts();
        $subtotal = $cart->sum(fn (Product $product) => $product->price_cents * session('cart')[$product->id]);

        return view('cart.index', compact('cart', 'subtotal'));
    }

    public function add(Request $request): RedirectResponse
    {
        $data = $request->validate(['product_id' => ['required', 'integer', 'exists:products,id'], 'quantity' => ['required', 'integer', 'min:1', 'max:99']]);
        $product = Product::query()->where('is_active', true)->findOrFail($data['product_id']);
        $cart = session('cart', []);
        $cart[$product->id] = min(99, ($cart[$product->id] ?? 0) + $data['quantity']);
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('status', 'Added to your cart.');
    }

    public function update(Request $request, int $productId): RedirectResponse
    {
        $data = $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:99']]);
        $cart = session('cart', []);
        abort_unless(isset($cart[$productId]), 404);
        $cart[$productId] = $data['quantity'];
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('status', 'Cart updated.');
    }

    public function remove(int $productId): RedirectResponse
    {
        $cart = session('cart', []);
        unset($cart[$productId]);
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('status', 'Item removed.');
    }

    private function cartProducts(): \Illuminate\Support\Collection
    {
        $cart = session('cart', []);
        if ($cart === []) {
            return collect();
        }

        return Product::query()->whereIn('id', array_keys($cart))->get()->keyBy('id');
    }
}
