<?php
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;
Route::get('/',[StoreController::class,'index'])->name('store.index');
Route::get('/products/{product}',[StoreController::class,'show'])->name('products.show');
Route::middleware('guest')->group(function(){Route::get('/register',[AuthController::class,'registerForm'])->name('register');Route::post('/register',[AuthController::class,'register']);Route::get('/login',[AuthController::class,'loginForm'])->name('login');Route::post('/login',[AuthController::class,'login'])->middleware('throttle:5,1');});
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth')->name('logout');
Route::middleware('auth')->group(function(){Route::get('/cart',[CartController::class,'index'])->name('cart.index');Route::post('/cart/items',[CartController::class,'add'])->name('cart.add');Route::patch('/cart/items/{productId}',[CartController::class,'update'])->name('cart.update');Route::delete('/cart/items/{productId}',[CartController::class,'remove'])->name('cart.remove');Route::get('/checkout',[CheckoutController::class,'create'])->name('checkout.create');Route::post('/checkout',[CheckoutController::class,'store'])->name('checkout.store');Route::get('/orders/{order}/confirmation',[CheckoutController::class,'success'])->name('orders.success');Route::get('/account/orders',[AccountController::class,'orders'])->name('account.orders');Route::get('/wishlist',[WishlistController::class,'index'])->name('wishlist.index');Route::post('/wishlist/{product}',[WishlistController::class,'store'])->name('wishlist.store');Route::delete('/wishlist/{product}',[WishlistController::class,'destroy'])->name('wishlist.destroy');});
Route::prefix('admin')->name('admin.')->middleware(['auth','admin'])->group(function(){Route::resource('products',AdminProductController::class)->except('show');});
