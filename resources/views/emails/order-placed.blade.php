<h2>Order Placed Successfully</h2>

<p>Thank you for your order.</p>

<p><strong>Order Number:</strong> {{ $order->order_number }}</p>
<p><strong>Tracking Number:</strong> {{ $order->tracking_number }}</p>
<p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
<p><strong>Total:</strong> Rs. {{ number_format($order->total ?? 0, 2) }}</p>

<h3>Customer Details</h3>
<p><strong>Name:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
<p><strong>Email:</strong> {{ $order->email }}</p>
<p><strong>Phone:</strong> {{ $order->phone }}</p>
<p><strong>Address:</strong> {{ $order->address }}, {{ $order->city }}</p>

<h3>Order Items</h3>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <tr>
        <th>Product</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Total</th>
    </tr>

    @foreach($order->items as $item)
        <tr>
            <td>{{ $item->product_name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>Rs. {{ number_format($item->price, 2) }}</td>
            <td>Rs. {{ number_format($item->line_total, 2) }}</td>
        </tr>
    @endforeach
</table>