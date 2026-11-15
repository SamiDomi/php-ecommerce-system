@extends('layouts.app')
@section('title', 'Checkout | Northstar Shop')
@section('content')
<h1>Checkout</h1><div class="grid" style="grid-template-columns:2fr 1fr">
<form method="post" action="{{ route('checkout.store') }}" class="panel">@csrf
<h2>Delivery details</h2>
<label class="field">Full name<input name="customer_name" value="{{ old('customer_name') }}" required maxlength="160"></label>
<label class="field">Email<input type="email" name="email" value="{{ old('email') }}" required maxlength="190"></label>
<label class="field">Phone (optional)<input name="phone" value="{{ old('phone') }}" maxlength="40"></label>
<label class="field">Street address<input name="address" value="{{ old('address') }}" required maxlength="255"></label>
<label class="field">City<input name="city" value="{{ old('city') }}" required maxlength="120"></label>
<label class="field">Postal code<input name="postal_code" value="{{ old('postal_code') }}" required maxlength="30"></label>
<label class="field">Country<input name="country" value="{{ old('country') }}" required maxlength="100"></label>
<p class="muted">Payment is not configured; orders are created with pending status. Connect a payment provider before accepting live orders.</p><button>Place order</button>
</form><aside class="panel"><h2>Order summary</h2>@foreach ($products as $product)<p class="row"><span>{{ $product->name }} × {{ session('cart')[$product->id] }}</span><span>${{ number_format($product->price_cents * session('cart')[$product->id] / 100, 2) }}</span></p>@endforeach<hr><p class="row"><strong>Total</strong><strong>${{ number_format($subtotal / 100, 2) }}</strong></p></aside>
</div>
@endsection
