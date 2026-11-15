@extends('layouts.app')
@section('title', $product->name.' | Northstar Shop')
@section('content')
<div class="panel">
    @if ($product->image_url)<img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="max-width:100%;max-height:360px;object-fit:cover">@endif
    <p class="muted">{{ $product->category?->name }}</p><h1>{{ $product->name }}</h1><p>{{ $product->description }}</p>
    <h2>${{ $product->formattedPrice() }}</h2><p>{{ $product->stock }} available</p>
    <form method="post" action="{{ route('cart.add') }}">@csrf<input type="hidden" name="product_id" value="{{ $product->id }}"><label>Quantity <input type="number" name="quantity" value="1" min="1" max="99"></label> <button @disabled($product->stock < 1)>Add to cart</button></form>
</div>
@endsection
