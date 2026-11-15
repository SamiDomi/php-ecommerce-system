@extends('layouts.app')
@section('title', 'Shop | Northstar Shop')
@section('content')
<h1>Discover something great</h1>
<form method="get" action="{{ route('store.index') }}" class="row" style="margin-bottom:1.5rem">
    <input name="q" value="{{ request('q') }}" placeholder="Search products" style="flex:1;padding:.7rem;border:1px solid #ccd2dd;border-radius:6px">
    <select name="category" style="padding:.7rem;border:1px solid #ccd2dd;border-radius:6px"><option value="">All categories</option>@foreach ($categories as $category)<option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>@endforeach</select>
    <button>Search</button>
</form>
@if ($products->isEmpty())<p class="muted">No products found. Add products using the database seeder or your admin tooling.</p>@else
<div class="grid">@foreach ($products as $product)<article class="card">
    @if ($product->image_url)<img src="{{ $product->image_url }}" alt="{{ $product->name }}">@endif
    <p class="muted">{{ $product->category?->name }}</p><h2><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></h2>
    <p><strong>${{ $product->formattedPrice() }}</strong></p><p class="muted">{{ $product->stock > 0 ? 'In stock' : 'Out of stock' }}</p>
    <form method="post" action="{{ route('cart.add') }}">@csrf<input type="hidden" name="product_id" value="{{ $product->id }}"><input type="hidden" name="quantity" value="1"><button @disabled($product->stock < 1)>Add to cart</button></form>
</article>@endforeach</div>{{ $products->links() }}@endif
@endsection
