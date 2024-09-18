@extends('layouts.dashboard')

@section('title', 'Store Dashboard')

@section('content')
<div class="p-6 flex-1 overflow-y-auto" style="background-color:#27272a;">
    <!-- Month Selection Dropdown -->
    <div class="mb-6 flex items-center">
        <label for="monthSelect" class="text-white text-lg font-semibold mr-4">Select Month:</label>
        <select id="monthSelect" class="border p-2 rounded">
            @foreach($monthsOptions as $option)
                <option value="{{ $option['value'] }}" {{ request('month') == $option['value'] ? 'selected' : '' }}>
                    {{ $option['label'] }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Metrics Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="p-4 shadow rounded-lg" style="background-color: #3f3f46;">
            <h2 class="text-white text-lg font-semibold">Total Sales</h2>
            <p class="text-green-500 text-2xl font-bold">${{ number_format($totalSales, 2) }}</p>
        </div>
        <div class="p-4 shadow rounded-lg" style="background-color: #3f3f46;">
            <h2 class="text-white text-lg font-semibold">Profit</h2>
            <p class="text-green-500 text-lg font-bold">${{ number_format($profit, 2) }}</p>
        </div>
        <div class="p-4 shadow rounded-lg" style="background-color: #3f3f46;">
            <h2 class="text-white text-lg font-semibold">Pending Orders</h2>
            <p class="text-green-500 text-lg font-bold">{{ $pendingOrders }}</p>
        </div>
        <div class="p-4 shadow rounded-lg" style="background-color: #3f3f46;">
            <h2 class="text-white text-lg font-semibold">Most Sold Product</h2>
            <p class="text-green-500 text-lg font-bold">{{ $mostSoldProduct->name ?? 'N/A' }}</p>
        </div>
        <div class="p-4 shadow rounded-lg" style="background-color: #3f3f46;">
            <h2 class="text-white text-lg font-semibold">Least Sold Product</h2>
            <p class="text-green-500 text-lg font-bold">{{ $leastSoldProduct->name ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Sales Overview -->
    <div class="p-6 shadow rounded-lg" style="background-color: #3f3f46;">
        <h2 class="text-white text-lg font-semibold mb-4">Sales Overview</h2>
        <div>
            <canvas id="salesChart"></canvas>
        </div>
    </div>
</div>

<!-- Script for Sales Chart -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('salesChart').getContext('2d');

        // Initial chart data
        var salesData = @json($salesData);
        var weeks = @json($weeksLabels);

        var salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: weeks,
                datasets: [{
                    label: 'Sales',
                    data: salesData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Weeks'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Sales Amount'
                        },
                        ticks: {
                            callback: function(value) {
                                // Ensure value is numeric
                                return !isNaN(value) ? value.toLocaleString() : value;
                            }
                        }
                    }
                }
            }
        });

        // Update chart data when month is selected
        document.getElementById('monthSelect').addEventListener('change', function() {
            var selectedMonth = this.value;

            // Fetch new sales data based on selected month
            fetch(`/your-endpoint?month=${selectedMonth}`)
                .then(response => response.json())
                .then(data => {
                    // Ensure data is in numeric format
                    var formattedSalesData = data.salesData.map(item => parseFloat(item));
                    // Update chart data
                    salesChart.data.labels = data.weeks;
                    salesChart.data.datasets[0].data = formattedSalesData;
                    salesChart.update();
                })
                .catch(error => console.error('Error fetching sales data:', error));
        });
    });
</script>
@endsection
