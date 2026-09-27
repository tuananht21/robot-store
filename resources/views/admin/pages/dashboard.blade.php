@extends('admin.layouts.app')

@section('title', 'Admin')

@section('header', 'Dashboard')

@section('content')

    <div>

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Dashboard
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Chào mừng bạn đến với trang quản trị Robot Store.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <p class="text-sm text-gray-500">
                    Categories
                </p>

                <p class="mt-2 text-2xl font-bold text-gray-800">
                    {{ $totalCategories }}
                </p>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <p class="text-sm text-gray-500">
                    Products
                </p>

                <p class="mt-2 text-2xl font-bold text-gray-800">
                    {{ $totalProducts }}
                </p>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <p class="text-sm text-gray-500">
                    Orders
                </p>

                <p class="mt-2 text-2xl font-bold text-gray-800">
                    {{ $totalOrders }}
                </p>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <p class="text-sm text-gray-500">
                    Revenue
                </p>

                <p class="mt-2 text-2xl font-bold text-gray-800">
                    {{ number_format($totalRevenue, 0, ',', '.') }} ₫
                </p>
            </div>

        </div>

        <div class="mt-6 bg-white rounded-lg border border-gray-200 p-6">

            <h2 class="text-lg font-semibold text-gray-800">
                Test Admin Layout
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Nếu bạn thấy Sidebar, Header, Content và Footer
                hiển thị đúng thì layout Admin đã hoạt động.
            </p>

        </div>

    </div>

@endsection