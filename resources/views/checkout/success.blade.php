@extends('layouts.app')
@section('title', 'Order received | Northstar Shop')
@section('content')
<div class="panel"><h1>Thank you for your order!</h1><p>Order <strong>{{ $order->order_number }}</strong> has been received.</p><p>Status: {{ ucfirst($order->status) }}</p><h2>Items</h2>@foreach ($order->items as $item)<p>{{ $item->product_name }} × {{ $item->quantity }} — ${{ number_format($item->unit_price_cents * $item->quantity / 100, 2) }}</p>@endforeach<p><strong>Total: ${{ number_format($order->total_cents / 100, 2) }}</strong></p><a class="btn" href="{{ route('store.index') }}">Continue shopping</a></div>
@endsection
