@extends('admin.layouts.app')

@section('title', 'Admin')

@section('header', 'Dashboard')

@section('content')
    <div>
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
            <p class="mt-1 text-sm text-gray-500">Chào mừng bạn đến với trang quản trị Robot Store.</p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-lg border border-gray-200 bg-white p-5">
                <p class="text-sm text-gray-500">Categories</p>
                <p class="mt-2 text-2xl font-bold text-gray-800">{{ $totalCategories }}</p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-5">
                <p class="text-sm text-gray-500">Products</p>
                <p class="mt-2 text-2xl font-bold text-gray-800">{{ $totalProducts }}</p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-5">
                <p class="text-sm text-gray-500">Orders</p>
                <p class="mt-2 text-2xl font-bold text-gray-800">{{ $totalOrders }}</p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-5">
                <p class="text-sm text-gray-500">Revenue</p>
                <p class="mt-2 text-2xl font-bold text-gray-800">{{ number_format($totalRevenue, 0, ',', '.') }} ₫</p>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-2">
            <div class="rounded-lg border border-gray-200 bg-white p-5">
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Doanh thu theo tháng</h2>
                    <p class="text-sm text-gray-500">Doanh thu {{ now()->year }}</p>
                </div>

                <div class="h-80">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-5">
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Đơn hàng theo tháng</h2>
                    <p class="text-sm text-gray-500">Số lượng đơn hàng {{ now()->year }}</p>
                </div>

                <div class="h-80">
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const revenueData = @json($revenueLast7Days);
    const ordersData = @json($ordersLast7Days);

    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: revenueData.map(item => item.date),
            datasets: [{
                label: 'Doanh thu',
                data: revenueData.map(item => item.revenue),
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return new Intl.NumberFormat('vi-VN').format(context.raw) + ' ₫';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN', {
                                notation: 'compact'
                            }).format(value) + ' ₫';
                        }
                    }
                }
            }
        }
    });

    new Chart(document.getElementById('ordersChart'), {
        type: 'bar',
        data: {
            labels: ordersData.map(item => item.date),
            datasets: [{
                label: 'Đơn hàng',
                data: ordersData.map(item => item.orders),
                borderWidth: 1,
                borderRadius: 6
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
                    }
                }
            }
        }
    });
</script>
@endsection