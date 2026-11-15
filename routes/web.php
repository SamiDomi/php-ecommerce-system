<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StoreController::class, 'index'])->name('store.index');
Route::get('/products/{product}', [StoreController::class, 'show'])->name('products.show');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/items', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/items/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/items/{productId}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/orders/{order}/confirmation', [CheckoutController::class, 'success'])->name('orders.success');
