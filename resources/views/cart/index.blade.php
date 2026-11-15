@extends('layouts.app')
@section('title', 'Your Cart | Northstar Shop')
@section('content')
<h1>Your cart</h1>
@if ($cart->isEmpty())<div class="panel"><p>Your cart is empty.</p><a class="btn" href="{{ route('store.index') }}">Continue shopping</a></div>@else
<div class="panel"><table><thead><tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th><th></th></tr></thead><tbody>
@foreach ($cart as $product)<tr><td>{{ $product->name }}</td><td>${{ $product->formattedPrice() }}</td><td><form method="post" action="{{ route('cart.update', $product->id) }}">@csrf @method('PATCH')<input type="number" name="quantity" min="1" max="99" value="{{ session('cart')[$product->id] }}"><button>Update</button></form></td><td>${{ number_format($product->price_cents * session('cart')[$product->id] / 100, 2) }}</td><td><form method="post" action="{{ route('cart.remove', $product->id) }}">@csrf @method('DELETE')<button>Remove</button></form></td></tr>@endforeach
</tbody></table><p class="row"><strong>Subtotal</strong><strong>${{ number_format($subtotal / 100, 2) }}</strong></p><p class="muted">Shipping and taxes are not configured in this starter.</p><a class="btn" href="{{ route('checkout.create') }}">Proceed to checkout</a></div>@endif
@endsection
