@extends('layouts.admin')

@section('content')

<div class="p-6 bg-gray-100 min-h-screen">

    <!-- HEADER -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            Orders List
        </h1>

        <p class="text-gray-500 mt-1">
            Manage all customer orders
        </p>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow-md overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[1100px]">

                <!-- HEAD -->
                <thead class="bg-black text-white">

    <tr>
        <th class="px-6 py-4 text-left">Order #</th>
        <th class="px-6 py-4 text-left">Customer</th>
        <th class="px-6 py-4 text-left">Product IDs</th>
        <th class="px-6 py-4 text-left">Quantity</th>
        <th class="px-6 py-4 text-left">Phone</th>
        <th class="px-6 py-4 text-left">Payment</th>
        <th class="px-6 py-4 text-left">Status</th>
        <th class="px-6 py-4 text-left">Total</th>
        <th class="px-6 py-4 text-left">Date</th>
        <th class="px-6 py-4 text-center">Action</th>
    </tr>

</thead>

                <!-- BODY -->
                <tbody>

                    @forelse($orders as $order)

                        <tr class="border-b hover:bg-gray-50 transition">

                            <!-- ORDER NUMBER -->
                            <td class="px-6 py-5 font-semibold text-gray-800">
                                {{ $order->order_number }}
                            </td>

                            <!-- CUSTOMER -->
                            <td class="px-6 py-5">
                                {{ $order->first_name }} {{ $order->last_name }}
                            </td>
<td class="px-6 py-5">

    @foreach($order->items as $item)

        <div class="mb-1">
            {{ $item->product->product_id ?? $item->product_id }}
        </div>

    @endforeach

</td>
                            <!-- PHONE -->
                            <td class="px-6 py-5">
                                {{ $order->phone }}
                            </td>

                            <!-- PAYMENT -->
                            <td class="px-6 py-5">
                                {{ $order->payment_method }}
                            </td>

                            <!-- STATUS -->
                            <td class="px-6 py-5">

                                <span class="px-3 py-1 rounded-full text-xs font-bold
                                    @if($order->status == 'pending') bg-yellow-100 text-yellow-700
                                    @elseif($order->status == 'delivered') bg-green-100 text-green-700
                                    @else bg-red-100 text-red-700
                                    @endif">

                                    {{ ucfirst($order->status) }}

                                </span>

                            </td>

                            <!-- TOTAL -->
                            <td class="px-6 py-5 font-bold text-green-600">
                                Rs {{ number_format($order->total, 2) }}
                            </td>

                            <!-- DATE -->
                            <td class="px-6 py-5 text-gray-600">
                                {{ $order->created_at->format('d M Y') }}
                            </td>

                            <!-- ACTION -->
                            <td class="px-6 py-5">

                                <div class="flex justify-center gap-3">

                                    <!-- VIEW -->
                                    <a href="{{ route('admin.orders.detail', $order->order_number) }}"
                                       class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-blue-700 transition">

                                        View

                                    </a>

                                    <!-- INVOICE -->
                                    <a href="{{ route('admin.invoices.download', $order->id) }}"
                                       class="bg-black text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-gray-800 transition">

                                        Invoice

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center py-12 text-gray-500">
                                No orders found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <!-- PAGINATION -->
    <div class="mt-8">
        {{ $orders->links() }}
    </div>

</div>

@endsection