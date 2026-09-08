@extends('layouts.admin')

@section('content')

<h2>Order Details</h2>

<h4>Customer Info</h4>
<p><strong>Name:</strong> {{ $order->customer->name }}</p>
<p><strong>Phone:</strong> {{ $order->customer->phone }}</p>
<p><strong>Address:</strong> {{ $order->customer->address }}</p>

<hr>

<h4>Products</h4>

<table class="table">
    <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
        </tr>
    </thead>

    <tbody>
        @foreach($order->items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>Rs {{ $item->price }}</td>
            <td>{{ $item->quantity }}</td>
            <td>Rs {{ $item->price * $item->quantity }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3>Total: Rs {{ $order->total }}</h3>

@endsection