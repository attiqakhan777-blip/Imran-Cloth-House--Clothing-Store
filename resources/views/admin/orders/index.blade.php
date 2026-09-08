@extends('layouts.admin')

@section('content')

<div class="p-6 bg-gray-100 min-h-screen">

    <!-- HEADER + SEARCH BAR -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-8">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Orders Management
            </h1>
            <p class="text-gray-500 mt-1">
                Manage customer orders and products
            </p>
        </div>

        <!-- SEARCH BAR -->
        <form method="GET" class="w-full lg:w-auto flex items-center gap-3">
            <div class="relative flex-1 lg:w-96">
                <input type="text" 
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search order #, customer name, phone, email..."
                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:border-black text-sm">

                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>

            <button type="submit"
                    class="bg-black text-white px-8 py-3 rounded-2xl font-semibold hover:bg-gray-800 transition">
                Search
            </button>

            @if(request('search'))
                <a href="{{ route('admin.orders.index') }}"
                   class="text-gray-500 hover:text-gray-700 font-medium flex items-center gap-1">
                    <i class="fa-solid fa-xmark"></i> Clear
                </a>
            @endif
        </form>

    </div>

    <!-- ORDERS -->
    <div class="space-y-6">

        @forelse($orders as $order)

        <div class="bg-white rounded-2xl shadow-md overflow-hidden">

            <!-- TOP SECTION -->
            <div class="p-6 border-b bg-gradient-to-r from-gray-50 to-white">

                <div class="grid md:grid-cols-5 gap-6">

                    <!-- ORDER -->
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Order Number</p>
                        <h3 class="font-bold text-lg text-gray-800">
                            {{ $order->order_number }}
                        </h3>
                    </div>

                    <!-- CUSTOMER -->
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Customer</p>
                        <h3 class="font-semibold text-gray-800">
                            {{ $order->first_name }} {{ $order->last_name }}
                        </h3>
                    </div>

                    <!-- PHONE -->
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Phone</p>
                        <h3 class="font-semibold text-gray-700">
                            {{ $order->phone }}
                        </h3>
                    </div>

                    <!-- TOTAL -->
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Amount</p>
                        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full font-bold text-sm">
                            Rs {{ number_format($order->total, 2) }}
                        </span>
                    </div>

                    <!-- STATUS -->
                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                        @csrf
                        <select name="status"
                                onchange="this.form.submit()"
                                class="border rounded-lg px-3 py-2 text-sm font-semibold w-full">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="returned" {{ $order->status == 'returned' ? 'selected' : '' }}>Returned</option>
                        </select>
                    </form>

                </div>
            </div>

            <!-- ADDRESS -->
            <div class="px-6 py-4 border-b bg-gray-50">
                <p class="text-sm text-gray-500 mb-1">Shipping Address</p>
                <p class="text-gray-700 font-medium">{{ $order->address }}</p>
            </div>

            <!-- PRODUCTS -->
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-5">Ordered Products</h3>

                <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-5">
                    @foreach($order->items as $item)
                    <div class="border rounded-2xl overflow-hidden bg-white shadow-sm hover:shadow-lg transition duration-300">
                        <!-- IMAGE -->
                        <div class="h-52 bg-gray-100 overflow-hidden">
                            @if($item->image)
                                <img src="{{ asset($item->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">No Image</div>
                            @endif
                        </div>

                        <!-- CONTENT -->
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h4 class="font-bold text-gray-800 text-lg">{{ $item->product_name }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Product Code: {{ $item->product->product_id ?? 'N/A' }}
                                    </p>
                                </div>
                                <span class="bg-indigo-100 text-indigo-700 text-xs px-3 py-1 rounded-full font-semibold">
                                    Qty {{ $item->quantity }}
                                </span>
                            </div>

                            <div class="space-y-2 text-sm">
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Price</span>
                                    <span class="font-medium text-gray-700">Rs {{ number_format($item->price, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Total</span>
                                    <span class="font-bold text-green-600">Rs {{ number_format($item->line_total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

          <!-- FOOTER -->
<div class="px-6 py-4 bg-gray-50 border-t flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <p class="text-sm text-gray-500">Payment Method</p>
        <p class="font-semibold text-gray-700">{{ $order->payment_method }}</p>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="text-left sm:text-right">
            <p class="text-sm text-gray-500">Order Date</p>
            <p class="font-semibold text-gray-700">{{ $order->created_at->format('d M Y, h:i A') }}</p>
        </div>

       <a href="{{ route('admin.orders.invoice', $order->id) }}"
   class="bg-black text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-gray-800 transition">
    Download Invoice
</a>
    </div>
</div>

        </div>

        @empty
        <div class="bg-white rounded-2xl p-12 text-center">
            <p class="text-gray-500 text-lg">No orders found.</p>
        </div>
        @endforelse

    </div>

    <!-- PAGINATION -->
    <div class="mt-8">
        {{ $orders->links() }}
    </div>

</div>

@endsection