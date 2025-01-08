@extends('layouts.dashboard')

@section('title', 'Store Dashboard')

@section('content')
<div class="p-6 flex-1 overflow-y-auto" style="background-color:#27272a;">
    <!-- Metrics Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="p-4 shadow rounded-lg bg-gray-800 ">
            <p class="text-white text-lg font-semibold">Total Sales</p>
            <p class="text-green-500 ">${{ number_format($totalSales, 2) }}</p>
        </div>
        <div class="p-4 shadow rounded-lg bg-gray-800 ">
            <p class="text-white text-lg font-semibold">Pending Orders</p>
            <p class="text-green-500 ">{{ $pendingOrders }}</p>
        </div>
        <div class="p-4 shadow rounded-lg bg-gray-800 ">
            <p class="text-white text-lg font-semibold">Most Sold Product</p>
            <p class="text-green-500 ">{{ $mostSoldProduct->name ?? 'N/A' }}</p>
        </div>
        <div class="p-4 shadow rounded-lg bg-gray-800 ">
            <p class="text-white text-lg font-semibold">Least Sold Product</p>
            <p class="text-green-500 ">{{ $leastSoldProduct->name ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Sales Overview with Chart Type Selector in same row -->
    <div class="p-6 shadow rounded-l" style="background-color: #3f3f46;">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-white text-lg font-semibold">Sales Overview</h2>
            <div class="flex gap-4">
                <div class="cursor-pointer" id="barChartButton">
                    <p class="text-white text-sm">Bar Chart</p>
                </div>
                <div class="cursor-pointer" id="lineChartButton">
                    <p class="text-white text-sm">Line Chart</p>
                </div>
                <div class="cursor-pointer" id="pieChartButton">
                    <p class="text-white text-sm">Pie Chart</p>
                </div>

            </div>
        </div>
        <div>
            <canvas id="salesChart"></canvas>
        </div>
    </div>
</div>

<!-- Script for Sales Chart -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesData = @json($salesData);
        var weeks = @json($weeksLabels);
        function createChart(chartType) {
            return new Chart(ctx, {
                type: chartType,
                data: {
                    labels: weeks,
                    datasets: [{
                        label: 'Sales',
                        data: salesData,
                        backgroundColor: chartType === 'pie' ? ['#4BC0C0', '#FF6384', '#36A2EB', '#FFCD56', '#FF9F40'] : 'rgba(75, 192, 192, 0.2)',
                        borderColor: chartType === 'pie' ? ['#4BC0C0', '#FF6384', '#36A2EB', '#FFCD56', '#FF9F40'] : 'rgba(75, 192, 192, 1)',
                        borderWidth: chartType === 'pie' ? 1 : 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: chartType === 'pie' ? {} : {
                        x: {
                            title: {
                                display: true,
                                text: 'Weeks'
                            },
                            ticks: {
                                callback: function (value) {
                                    return weeks[value] ? weeks[value] : value;
                                }
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Sales Amount'
                            },
                            ticks: {
                                callback: function (value) {
                                    return !isNaN(value) ? '$' + value.toLocaleString() : value;
                                }
                            }
                        }
                    }
                }
            });
        }

        var salesChart = createChart('bar');

        document.getElementById('barChartButton').addEventListener('click', function () {
            salesChart.destroy();
            salesChart = createChart('bar');
        });

        document.getElementById('lineChartButton').addEventListener('click', function () {
            salesChart.destroy();
            salesChart = createChart('line');
        });

        document.getElementById('pieChartButton').addEventListener('click', function () {
            salesChart.destroy();
            salesChart = createChart('pie');
        });
    });
</script>
@endsection