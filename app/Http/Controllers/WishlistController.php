<?php
namespace App\Http\Controllers;
use App\Models\Product;use Illuminate\Http\Request;use Illuminate\Support\Facades\DB;use Illuminate\View\View;use Illuminate\Http\RedirectResponse;
class WishlistController {public function index(Request $r):View{return view('wishlist.index',['products'=>$r->user()->wishlistProducts()->with('category')->paginate(12)]);}public function store(Request $r,Product $product):RedirectResponse{DB::table('wishlists')->insertOrIgnore(['user_id'=>$r->user()->id,'product_id'=>$product->id,'created_at'=>now(),'updated_at'=>now()]);return back()->with('status','Saved to wishlist.');}public function destroy(Request $r,Product $product):RedirectResponse{$r->user()->wishlistProducts()->detach($product->id);return back()->with('status','Removed from wishlist.');}}
