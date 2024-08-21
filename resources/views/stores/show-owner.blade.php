<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Dashboard</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <div class="flex">
        <!-- Sidebar -->
        <div id="sidebar" class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2 hidden lg:block">
            <!-- Sidebar Links -->
            <div class="flex items-center px-4">
                <h1 class="text-2xl font-semibold text-white">Store Name</h1>
            </div>
            <nav class="mt-10">
                <a href="#" class="flex items-center py-2 px-4 text-white hover:bg-gray-700">
                    <i class="fas fa-home text-green-500"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
                <a href="#" class="flex items-center py-2 px-4 text-white hover:bg-gray-700">
                    <i class="fas fa-box-open text-green-500"></i>
                    <span class="ml-3">Products</span>
                </a>
                <a href="#" class="flex items-center py-2 px-4 text-white hover:bg-gray-700">
                    <i class="fas fa-chart-line text-green-500"></i>
                    <span class="ml-3">Analytics</span>
                </a>
                <a href="#" class="flex items-center py-2 px-4 text-white hover:bg-gray-700">
                    <i class="fas fa-cogs text-green-500"></i>
                    <span class="ml-3">Settings</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <div class="flex justify-between items-center py-4 px-6 bg-white shadow">
                <div class="flex items-center space-x-2">
                    <!-- Open Button -->
                    <button id="openSidebar" class="text-gray-500 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-lg font-semibold text-gray-800">Store Name</h1>
                </div>
                <div>
                    <i class="fas fa-envelope text-green-500 text-xl"></i>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-6 flex-1 bg-gray-100 overflow-y-auto">
                <!-- Metrics Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h2 class="text-gray-600 text-lg font-semibold">Total Sales</h2>
                        <p class="text-green-500 text-2xl font-bold">$45,000</p>
                    </div>
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h2 class="text-gray-600 text-lg font-semibold">Most sold product</h2>
                        <p class="text-green-500 text-lg font-bold">Product Name</p>
                    </div>
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h2 class="text-gray-600 text-lg font-semibold">Order Request</h2>
                        <p class="text-green-500 text-lg font-bold">1,200</p>
                    </div>
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h2 class="text-gray-600 text-lg font-semibold">Pending Order</h2>
                        <p class="text-green-500 text-lg font-bold">1,200</p>
                    </div>
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h2 class="text-gray-600 text-lg font-semibold">Profit</h2>
                        <p class="text-green-500 text-lg font-bold">150</p>
                    </div>
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h2 class="text-gray-600 text-lg font-semibold">Least sold product</h2>
                        <p class="text-green-500 text-lg font-bold">Product Name</p>
                    </div>
                </div>

                <!-- Sales Overview -->
                <div class="bg-white p-6 shadow rounded-lg">
                    <h2 class="text-gray-600 text-lg font-semibold mb-4">Sales Overview</h2>
                    <div>
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to Toggle Sidebar -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const openSidebarButton = document.getElementById('openSidebar');
            const sidebar = document.getElementById('sidebar');

            openSidebarButton.addEventListener('click', function () {
                sidebar.classList.toggle('hidden');
            });

            // Sales Overview Chart
            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Item 1', 'Item 2', 'Item 3', 'Item 4', 'Item 5'],
                    datasets: [{
                        label: 'Sales',
                        data: [20, 30, 25, 35, 40],
                        borderColor: 'rgba(34,197,94,1)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.4
                    }]
                },
                options: {
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
