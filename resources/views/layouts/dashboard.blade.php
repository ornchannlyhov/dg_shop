<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Store Dashboard')</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- bs style-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- bs script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        a {
            text-decoration: none;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen" style="background-color:#27272a;">
        <!-- Sidebar -->
        <div id="sidebar" class="text-white w-64 space-y-6 py-7 px-2 hidden lg:block"
            style="background-color: #18181b; position: sticky; top: 0; height: auto;">
            <!-- Sidebar Links -->
            <div class="flex items-center px-4">
                @if($store->logo)
                    <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->store_name }} Logo"
                        class="w-16 h-16 object-cover rounded-full">
                @else
                    <div class="w-16 h-16 bg-gray-200 rounded-full"></div>
                @endif
                <div>
                    <h2 class="text-2xl font-semibold text-gray-300">{{ $store->store_name }}</h2>
                </div>
            </div>
            <nav class="mt-10">
                <a href="{{ route('redirect.toStore') }}"
                    class="flex items-center py-2 px-4 text-white hover:bg-gray-700">
                    <i class="fas fa-home text-green-500"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
                <a href="{{ route('stores.products-listing', ['id' => $store->store_id]) }}"
                    class="flex items-center py-2 px-4 text-white hover:bg-gray-700">
                    <i class="fas fa-box-open text-green-500"></i>
                    <span class="ml-3">Products</span>
                </a>
                <a href="{{ route('') }}"
                    class="flex items-center py-2 px-4 text-white hover:bg-gray-700">
                    <i class="fa-solid fa-file text-green-500"></i>
                    <span class="ml-4">Order Request</span>
                </a>
                <a href="{{ route('stores.edit', ['id' => $store->store_id]) }}"
                    class="flex items-center py-2 px-4 text-white hover:bg-gray-700">
                    <i class="fas fa-cogs text-green-500"></i>
                    <span class="ml-3">Settings</span>
                </a>
                <a href="{{ route('products.index', ['id' => $store->store_id]) }}"
                    class="flex items-center py-2 px-4 text-white hover:bg-gray-700">
                    <i class="fa-solid fa-arrow-left  text-green-500"></i>
                    <span class="ml-4">Homepage</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-screen" style="background-color:#27272a;">
            <!-- Header (Make it sticky) -->
            <div class="flex justify-between items-center py-4 px-6 shadow"
                style="background-color:#27272a; position: sticky; top: 0; z-index: 50;">
                <div class="flex items-center space-x-2">
                    <!-- Open Button -->
                    <button id="toggleSidebar" class="text-gray-500 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h2 class="text-2xl font-semibold text-gray-300 ml-4 mb-1">{{ $store->store_name }}</h2>
                </div>
                <div>
                    <button id="messageButton" class="text-gray-500 focus:outline-none">
                        <i class="fas fa-envelope text-green-500 text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Dynamic Content Section -->
            <div class="p-6 flex-1 overflow-y-auto" style="background-color:#27272a;">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- JavaScript to Toggle Sidebar -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleSidebarButton = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');

            toggleSidebarButton.addEventListener('click', function () {
                sidebar.classList.toggle('hidden');
            });
        });
    </script>
</body>

</html>