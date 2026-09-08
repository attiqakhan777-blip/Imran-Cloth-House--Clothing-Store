@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page_title', 'Dashboard Overview')

@section('content')

<div class="space-y-6">

    <!-- Stats Boxes -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Total Products</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalProducts }}</h3>
                </div>
                <div class="bg-sky-50 text-sky-600 p-3.5 rounded-xl">
                    <i class="fa-solid fa-box text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Total Orders</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalOrders }}</h3>
                </div>
                <div class="bg-emerald-50 text-emerald-600 p-3.5 rounded-xl">
                    <i class="fa-solid fa-bag-shopping text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-emerald-100 shadow-sm hover:shadow-md transition ring-1 ring-emerald-50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Total Revenue</p>
                    <h3 class="text-3xl font-bold text-emerald-700 mt-2">
                        Rs {{ number_format($totalRevenue, 0) }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-1">From delivered orders</p>
                </div>
                <div class="bg-emerald-50 text-emerald-600 p-3.5 rounded-xl">
                    <i class="fa-solid fa-money-bill-wave text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Pending Orders</p>
                    <h3 class="text-3xl font-bold text-amber-600 mt-2">{{ $pendingOrders }}</h3>
                </div>
                <div class="bg-amber-50 text-amber-600 p-3.5 rounded-xl">
                    <i class="fa-solid fa-clock text-lg"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Delivered Orders</p>
                <h3 class="text-2xl font-bold text-emerald-600 mt-2">{{ $deliveredOrders }}</h3>
            </div>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-emerald-50 text-emerald-600">
                <i class="fa-solid fa-check"></i>
            </span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Returned Orders</p>
                <h3 class="text-2xl font-bold text-rose-600 mt-2">{{ $returnedOrders }}</h3>
            </div>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-rose-50 text-rose-600">
                <i class="fa-solid fa-rotate-left"></i>
            </span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Average Order Value</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2">
                    Rs {{ number_format($averageOrderValue ?? ($deliveredOrders > 0 ? $totalRevenue / $deliveredOrders : 0), 0) }}
                </h3>
            </div>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-slate-100 text-slate-600">
                <i class="fa-solid fa-chart-simple"></i>
            </span>
        </div>

    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">

        <!-- Daily Orders Chart -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Daily Orders</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Orders received in last 7 days</p>
                </div>
            </div>

            <div class="h-80">
                <canvas id="dailyOrdersChart"></canvas>
            </div>
        </div>

        <!-- Best Selling Products Chart -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Best Selling Products</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Products customers ordered most</p>
                </div>
            </div>

            <div class="h-80">
                <canvas id="bestSellingChart"></canvas>
            </div>
        </div>

    </div>

    <!-- Recent Orders + Quick Actions -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">

        <!-- Recent Orders -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-semibold text-gray-900">Recent Orders</h2>

                <a href="{{ route('admin.orders.index') }}"
                   class="text-sm text-sky-600 hover:text-sky-700 font-medium">
                    View All
                </a>
            </div>

            <div class="space-y-1">

                @forelse($recentOrders as $order)
                    @php
                        $orderTotal = $order->total ?? $order->total_amount ?? 0;
                    @endphp

                    <div class="flex items-center justify-between gap-3 rounded-xl px-3 py-3 hover:bg-gray-50 transition text-sm">

                        <div class="min-w-0">
                            <p class="font-semibold text-gray-800 truncate">
                                Order #{{ $order->order_number ?? $order->id }}
                            </p>
                            <p class="text-gray-500 truncate">
                                {{ $order->first_name }} {{ $order->last_name }}
                            </p>
                        </div>

                        <div class="text-right shrink-0">
                            <p class="font-bold text-gray-900">
                                Rs {{ number_format($orderTotal, 0) }}
                            </p>

                            <span class="
                                inline-block mt-1 px-2 py-0.5 rounded-md text-[11px] font-semibold
                                @if($order->status == 'delivered') bg-emerald-50 text-emerald-700
                                @elseif($order->status == 'pending') bg-amber-50 text-amber-700
                                @else bg-rose-50 text-rose-700
                                @endif
                            ">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>

                    </div>

                @empty

                    <p class="text-gray-400 text-sm py-4 text-center">No recent orders found</p>

                @endforelse

            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-5">Quick Actions</h2>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">

                <a href="{{ route('admin.products.create') }}"
                   class="bg-gray-50 hover:bg-gray-100 border border-gray-100 p-4 rounded-xl text-center transition">
                    <i class="fa-solid fa-plus text-lg text-gray-700"></i>
                    <p class="text-sm mt-2 text-gray-700">Add Product</p>
                </a>

                <a href="{{ route('admin.orders.index') }}"
                   class="bg-gray-50 hover:bg-gray-100 border border-gray-100 p-4 rounded-xl text-center transition">
                    <i class="fa-solid fa-bag-shopping text-lg text-gray-700"></i>
                    <p class="text-sm mt-2 text-gray-700">View Orders</p>
                </a>

                <a href="{{ route('admin.orders.table') }}"
                   class="bg-gray-50 hover:bg-gray-100 border border-gray-100 p-4 rounded-xl text-center transition">
                    <i class="fa-solid fa-table text-lg text-gray-700"></i>
                    <p class="text-sm mt-2 text-gray-700">Orders Table</p>
                </a>

                <a href="{{ route('admin.invoices.index') }}"
                   class="bg-gray-50 hover:bg-gray-100 border border-gray-100 p-4 rounded-xl text-center transition">
                    <i class="fa-solid fa-file-invoice text-lg text-gray-700"></i>
                    <p class="text-sm mt-2 text-gray-700">Invoices</p>
                </a>

                <a href="{{ route('admin.categories.index') }}"
                   class="bg-gray-50 hover:bg-gray-100 border border-gray-100 p-4 rounded-xl text-center transition">
                    <i class="fa-solid fa-list text-lg text-gray-700"></i>
                    <p class="text-sm mt-2 text-gray-700">Categories</p>
                </a>

                <a href="{{ url('/') }}" target="_blank"
                   class="bg-gray-50 hover:bg-gray-100 border border-gray-100 p-4 rounded-xl text-center transition">
                    <i class="fa-solid fa-eye text-lg text-gray-700"></i>
                    <p class="text-sm mt-2 text-gray-700">View Site</p>
                </a>

            </div>
        </div>

    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const dailyLabels = @json($dailyLabels);
    const dailyData = @json($dailyData);

    const bestSellingLabels = @json($bestSellingProducts->pluck('product_name'));
    const bestSellingData = @json($bestSellingProducts->pluck('total_quantity'));

    new Chart(document.getElementById('dailyOrdersChart'), {
        type: 'line',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Orders',
                data: dailyData,
                borderColor: '#059669',
                backgroundColor: 'rgba(5, 150, 105, 0.12)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#059669',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: false
                }
            },

            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.04)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    new Chart(document.getElementById('bestSellingChart'), {
        type: 'bar',
        data: {
            labels: bestSellingLabels,
            datasets: [{
                label: 'Quantity Sold',
                data: bestSellingData,
                backgroundColor: 'rgba(14, 165, 233, 0.75)',
                borderColor: '#0ea5e9',
                borderWidth: 1,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: false
                }
            },

            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.04)'
                    }
                },

                x: {
                    ticks: {
                        callback: function(value) {
                            let label = this.getLabelForValue(value);
                            return label.length > 12 ? label.substring(0, 12) + '...' : label;
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>

@endsection
