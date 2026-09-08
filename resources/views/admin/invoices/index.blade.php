@extends('layouts.admin')

@section('content')

<div class="p-6 bg-gray-100 min-h-screen">

    <!-- HEADER -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            Invoices
        </h1>

        <p class="text-gray-500 mt-1">
            Manage and download customer invoices
        </p>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow-md overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px]">

                <thead class="bg-black text-white">

                    <tr>
                        <th class="px-6 py-4 text-left">Invoice #</th>
                        <th class="px-6 py-4 text-left">Customer</th>
                        <th class="px-6 py-4 text-left">Phone</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-left">Total</th>
                        <th class="px-6 py-4 text-left">Date</th>
                        <th class="px-6 py-4 text-center">Action</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($orders as $order)

                        <tr class="border-b hover:bg-gray-50 transition">

                            <td class="px-6 py-5 font-semibold text-gray-800">
                                {{ $order->order_number }}
                            </td>

                            <td class="px-6 py-5">
                                {{ $order->first_name }} {{ $order->last_name }}
                            </td>

                            <td class="px-6 py-5">
                                {{ $order->phone }}
                            </td>

                            <td class="px-6 py-5">

                                <span class="px-3 py-1 rounded-full text-xs font-bold
                                    @if($order->status == 'pending') bg-yellow-100 text-yellow-700
                                    @elseif($order->status == 'delivered') bg-green-100 text-green-700
                                    @else bg-red-100 text-red-700
                                    @endif">

                                    {{ ucfirst($order->status) }}

                                </span>

                            </td>

                            <td class="px-6 py-5 font-bold text-green-600">
                                Rs {{ number_format($order->total_amount, 2) }}
                            </td>

                            <td class="px-6 py-5 text-gray-600">
                                {{ $order->created_at->format('d M Y') }}
                            </td>

                            <td class="px-6 py-5 text-center">

                                <a href="{{ route('admin.invoices.download', $order->id) }}"
                                   class="inline-flex items-center gap-2 bg-black text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-gray-800 transition">

                                    <i class="fa-solid fa-download"></i>
                                    Download

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center py-12 text-gray-500">
                                No invoices found.
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