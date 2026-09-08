<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Imran Cloth House</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <div class="w-64 bg-gray-900 text-white flex-shrink-0 overflow-y-auto">
            <div class="p-6 flex items-center gap-3 border-b border-gray-800">
                <a href="#" class="flex flex-col items-center">
                    <img src="{{ asset('images/logo.png') }}" 
                         alt="ICH" 
                         class="h-12 w-12 rounded-full object-cover">
                    <h1 class="text-xl font-bold">Imran Cloth House</h1>
                </a>
            </div>

            <div class="p-4">
                <p class="text-xs text-gray-400 uppercase tracking-widest mb-4 px-4">GENERAL</p>
                
                <nav class="space-y-1 text-gray-300">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-gray-800 text-sm @if(request()->routeIs('admin.dashboard')) bg-gray-800 text-white @endif">
                        <i class="fa-solid fa-gauge"></i> Dashboard
                    </a>

                    <!-- Products Dropdown -->
                    <div>
                        <button onclick="toggleDropdown(this)" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-gray-800 text-sm">
                            <i class="fa-solid fa-box"></i> Products
                            <i class="fa-solid fa-chevron-down ml-auto text-xs transition-transform"></i>
                        </button>
                        <div class="pl-10 hidden space-y-1 text-sm mt-1 text-gray-300">
                            <a href="{{ route('admin.products.index') }}" class="block py-2 px-4 hover:bg-gray-800 rounded-xl">List</a>
                            <a href="{{ route('admin.products.create') }}" class="block py-2 px-4 hover:bg-gray-800 rounded-xl">Create</a>
                        </div>
                    </div>

                    <!-- Categories Dropdown -->
                    <div>
                        <button onclick="toggleDropdown(this)" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-gray-800 text-sm">
                            <i class="fa-solid fa-tags"></i> Categories
                            <i class="fa-solid fa-chevron-down ml-auto text-xs transition-transform"></i>
                        </button>
                        <div class="pl-10 hidden space-y-1 text-sm mt-1 text-gray-300">
                            <a href="{{ route('admin.categories.index') }}" class="block py-2 px-4 hover:bg-gray-800 rounded-xl">List</a>
                            <a href="{{ route('admin.categories.create') }}" class="block py-2 px-4 hover:bg-gray-800 rounded-xl">Create</a>
                        </div>
                    </div>

                    <!-- Brands Dropdown -->
                    <div>
                        <button onclick="toggleDropdown(this)" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-gray-800 text-sm">
                            <i class="fa-solid fa-box"></i> Brands
                            <i class="fa-solid fa-chevron-down ml-auto text-xs transition-transform"></i>
                        </button>
                        <div class="pl-10 hidden space-y-1 text-sm mt-1 text-gray-300">
                            <a href="{{ route('admin.brands.index') }}" class="block py-2 px-4 hover:bg-gray-800 rounded-xl">List</a>
                            <a href="{{ route('admin.brands.create') }}" class="block py-2 px-4 hover:bg-gray-800 rounded-xl">Create</a>
                        </div>
                    </div>

                    <!-- Attributes Dropdown -->
                    <div>
                        <button onclick="toggleDropdown(this)" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-gray-800 text-sm">
                            <i class="fa-solid fa-sliders"></i> Attributes
                            <i class="fa-solid fa-chevron-down ml-auto text-xs transition-transform"></i>
                        </button>
                        <div class="pl-10 hidden space-y-1 text-sm mt-1 text-gray-300">
                            <a href="{{ route('admin.attributes.index') }}" class="block py-2 px-4 hover:bg-gray-800 rounded-xl">List</a>
                            <a href="{{ route('admin.attributes.create') }}" class="block py-2 px-4 hover:bg-gray-800 rounded-xl">Create</a>
                        </div>
                    </div>

                     <!-- Fragrances Dropdown -->
                    <div>
                        <button onclick="toggleDropdown(this)" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-gray-800 text-sm">
                            <i class="fa-solid fa-sliders"></i> Fragrances
                            <i class="fa-solid fa-chevron-down ml-auto text-xs transition-transform"></i>
                        </button>
                        <div class="pl-10 hidden space-y-1 text-sm mt-1 text-gray-300">
                            <a href="#" class="block py-2 px-4 hover:bg-gray-800 rounded-xl">List</a>
                            <a href="#" class="block py-2 px-4 hover:bg-gray-800 rounded-xl">Create</a>
                        </div>
                    </div>

                    <!-- Home Page Dropdown -->
                    <div>
                        <button onclick="toggleDropdown(this)" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-gray-800 text-sm">
                            <i class="fa-solid fa-house"></i> Home Page
                            <i class="fa-solid fa-chevron-down ml-auto text-xs transition-transform"></i>
                        </button>
                        <div class="pl-10 hidden space-y-1 text-sm mt-1 text-gray-300">
                            <a href="{{ route('admin.home.manage') }}" class="block py-2 px-4 hover:bg-gray-800 rounded-xl">
                                <i class="fa-solid fa-pen mr-2"></i> Manage Homepage
                            </a>
                            <a href="{{ route('admin.home.edit', 'hero') }}" class="block py-2 px-4 hover:bg-gray-800 rounded-xl">
                                <i class="fa-solid fa-edit mr-2"></i> Edit Hero Banner
                            </a>
                            <a href="{{ route('admin.home.edit', 'collections') }}" class="block py-2 px-4 hover:bg-gray-800 rounded-xl">
                                <i class="fa-solid fa-edit mr-2"></i> Edit Collections
                            </a>
                            <a href="{{ url('/') }}" target="_blank" class="block py-2 px-4 hover:bg-gray-800 rounded-xl">
                                <i class="fa-solid fa-eye mr-2"></i> View Live Homepage
                            </a>
                        </div>
                    </div>

                    <!-- Coupons Dropdown -->
                    <div>
                        <button onclick="toggleDropdown(this)" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-gray-800 text-sm">
                            <i class="fa-solid fa-ticket"></i> Coupons
                            <i class="fa-solid fa-chevron-down ml-auto text-xs transition-transform"></i>
                        </button>
                        <div class="pl-10 hidden space-y-1 text-sm mt-1 text-gray-300">
                            <a href="{{ route('admin.coupons.index') }}" class="block py-2 px-4 hover:bg-gray-800 rounded-xl">List</a>
                            <a href="{{ route('admin.coupons.create') }}" class="block py-2 px-4 hover:bg-gray-800 rounded-xl">Create</a>
                        </div>
                    </div>

                    <!-- Orders Dropdown -->
                    <div>
                        <button onclick="toggleDropdown(this)" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-gray-800 text-sm">
                            <i class="fa-solid fa-bag-shopping"></i> Orders
                            <i class="fa-solid fa-chevron-down ml-auto text-xs transition-transform"></i>
                        </button>
                        <div class="pl-10 hidden space-y-1 text-sm mt-1 text-gray-300">
                            <a href="{{ route('admin.orders.index') }}" class="block py-2 px-4 hover:bg-gray-800 rounded-xl">List</a>
                            <a href="{{ route('admin.orders.table') }}" class="block py-2 px-4 hover:bg-gray-800 rounded-xl">All Orders</a>
                        </div>
                    </div>

                    <!-- Invoices Dropdown -->
                    <div>
                        <button onclick="toggleDropdown(this)" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-gray-800 text-sm">
                            <i class="fa-solid fa-file-invoice"></i> Invoices
                            <i class="fa-solid fa-chevron-down ml-auto text-xs transition-transform"></i>
                        </button>
                        <div class="pl-10 hidden space-y-1 text-sm mt-1 text-gray-300">
                            <a href="{{ route('admin.invoices.index') }}" class="block py-2 px-4 hover:bg-gray-800 rounded-xl">List</a>
                        </div>
                    </div>

                    <!-- Settings Dropdown -->
                    <div>
                        <button onclick="toggleDropdown(this)" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-gray-800 text-sm">
                            <i class="fa-solid fa-cog"></i> Settings
                            <i class="fa-solid fa-chevron-down ml-auto text-xs transition-transform"></i>
                        </button>
                        <div class="pl-10 hidden space-y-1 text-sm mt-1 text-gray-300">
                            <a href="{{ route('admin.settings.edit') }}" class="block py-2 px-4 hover:bg-gray-800 rounded-xl">Add Shipping Charges</a>
                        </div>
                    </div>

                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <div class="h-14 bg-white border-b flex items-center px-6 justify-between text-sm">
                <h2 class="font-semibold">@yield('page_title', 'Dashboard')</h2>
                
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-600 hover:text-red-600 flex items-center gap-2 text-sm">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>

            <!-- Content Area -->
            <div class="flex-1 overflow-auto p-6">
                @yield('content')
            </div>
        </div>
    </div>

@stack('scripts')

<script>
function toggleDropdown(btn) {
    const dropdown = btn.nextElementSibling;
    const arrow = btn.querySelector('i:last-child');
    
    dropdown.classList.toggle('hidden');
    if (arrow) {
        arrow.style.transform = dropdown.classList.contains('hidden') ? '' : 'rotate(180deg)';
    }
}
</script>
</body>
</html>