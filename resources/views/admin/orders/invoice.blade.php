<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->order_number }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            font-size: 13px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
        }

        .info {
            width: 100%;
            margin-bottom: 25px;
        }

        .info td {
            vertical-align: top;
            width: 50%;
            padding: 8px;
        }

        .box {
            border: 1px solid #ddd;
            padding: 12px;
        }

        table.products {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table.products th {
            background: #000;
            color: #fff;
            padding: 10px;
            text-align: left;
        }

        table.products td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        .summary {
            width: 45%;
            margin-left: auto;
            margin-top: 25px;
            border-collapse: collapse;
        }

        .summary td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        .summary .grand {
            font-size: 16px;
            font-weight: bold;
            background: #f2f2f2;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            color: #777;
            font-size: 12px;
        }
    </style>
</head>

<body>

@php

$subtotal = $order->subtotal ?? $order->items->sum('line_total');

$shipping = $order->shipping_charges ?? 0;

$tax = $order->tax_charges ?? 0;

$handling = $order->handling_charges ?? 0;

$grandTotal = $subtotal + $shipping + $tax + $handling;

@endphp
<div class="header">
    <h1>Invoice</h1>
    <p>Order #{{ $order->order_number }}</p>
</div>

<table class="info">
    <tr>
        <td>
            <div class="box">
                <strong>Customer Details</strong><br><br>
                Name: {{ $order->first_name }} {{ $order->last_name }}<br>
                Phone: {{ $order->phone }}<br>
                Email: {{ $order->email ?? 'N/A' }}<br>
                Address: {{ $order->address }}
            </div>
        </td>

        <td>
            <div class="box">
                <strong>Order Details</strong><br><br>
                Date: {{ $order->created_at->format('d M Y, h:i A') }}<br>
                Status: {{ ucfirst($order->status) }}<br>
                Payment Method: {{ $order->payment_method }}
            </div>
        </td>
    </tr>
</table>

<table class="products">
    <thead>
        <tr>
            <th>Product</th>
            <th>Code</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
    </thead>

    <tbody>
        @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->product?->product_id ?? 'N/A' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rs {{ number_format($item->price, 2) }}</td>
                <td>Rs {{ number_format($item->line_total, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<table class="summary">
    <tr>
        <td>Subtotal</td>
        <td>Rs {{ number_format($subtotal, 2) }}</td>
    </tr>

    <tr>
        <td>Shipping Charges</td>
        <td>Rs {{ number_format($shipping, 2) }}</td>
    </tr>

    <tr>
        <td>Tax Charges</td>
        <td>Rs {{ number_format($tax, 2) }}</td>
    </tr>

    <tr>
        <td>Handling Charges</td>
        <td>Rs {{ number_format($handling, 2) }}</td>
    </tr>

    <tr class="grand">
        <td>Grand Total</td>
        <td>Rs {{ number_format($grandTotal, 2) }}</td>
    </tr>
</table>

<div class="footer">
    Thank you for your order.
</div>

</body>
</html>