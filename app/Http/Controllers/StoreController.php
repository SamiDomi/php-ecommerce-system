<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoreController
{
    public function index(Request $request): View
    {
        $products = Product::query()->with('category')->where('is_active', true)
            ->when($request->filled('q'), fn ($query) => $query->where('name', 'like', '%'.$request->string('q')->toString().'%'))
            ->when($request->filled('category'), fn ($query) => $query->whereHas('category', fn ($category) => $category->where('slug', $request->string('category')->toString())))
            ->latest()->paginate(12)->withQueryString();

        return view('store.index', ['products' => $products, 'categories' => Category::query()->orderBy('name')->get()]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        return view('store.show', ['product' => $product->load('category')]);
    }
}
