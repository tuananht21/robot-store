@extends('admin.layouts.app')

@section('title', 'Orders')

@section('header', 'Orders')

@section('content')
    <div class="space-y-6">

        @if(session('success'))
            <div class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Orders</h1>
                <p class="mt-1 text-sm text-gray-500">Quản lý đơn hàng</p>
            </div>
        </div>

        <div class="rounded-xl bg-white p-5 shadow-sm">
            <form action="{{ route('admin.orders.index') }}" method="GET"
                class="grid grid-cols-1 gap-4 md:grid-cols-3">

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Tìm kiếm
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Mã đơn, tên khách, SĐT..."
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-gray-900"
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Trạng thái đơn hàng
                    </label>

                    <select
                        name="filter_status"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-gray-900"
                    >
                        <option value="all" {{ $filterStatus === 'all' ? 'selected' : '' }}>
                            Tất cả
                        </option>
                        <option value="1" {{ $filterStatus === '1' ? 'selected' : '' }}>
                            Chờ xử lý
                        </option>
                        <option value="2" {{ $filterStatus === '2' ? 'selected' : '' }}>
                            Đang giao
                        </option>
                        <option value="3" {{ $filterStatus === '3' ? 'selected' : '' }}>
                            Hoàn thành
                        </option>
                        <option value="4" {{ $filterStatus === '4' ? 'selected' : '' }}>
                            Đã hủy
                        </option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button
                        type="submit"
                        class="flex-1 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800"
                    >
                        Tìm kiếm
                    </button>

                    <a
                        href="{{ route('admin.orders.index') }}"
                        class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        Xóa
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-hidden rounded-xl bg-white shadow-sm">

            <div class="overflow-x-auto">
                <table class="w-full min-w-[1200px] text-left">

                    <thead class="border-b bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                #
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Khách hàng
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Tổng tiền
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Thanh toán
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Trạng thái
                            </th>

                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-600">
                                Thao tác
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        @forelse($orders as $order)

                            <tr class="hover:bg-gray-50">

                                <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                    #{{ $order->id }}
                                </td>

                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-medium text-gray-800">
                                            {{ $order->customer_name }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $order->phone }}
                                        </p>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-800">
                                        {{ number_format($order->total_amount, 0, ',', '.') }} ₫
                                    </p>

                                    @if($order->shipping_fee > 0)
                                        <p class="mt-1 text-xs text-gray-500">
                                            Phí ship:
                                            {{ number_format($order->shipping_fee, 0, ',', '.') }} ₫
                                        </p>
                                    @endif
                                </td>

                                <td class="px-6 py-4">

                                    <div class="space-y-1">

                                        @if($order->payment_method == 0)
                                            <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">
                                                VNPay
                                            </span>
                                        @else
                                            <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                                                COD
                                            </span>
                                        @endif

                                        <div>
                                            @if($order->payment_status)
                                                <span class="text-xs font-medium text-green-600">
                                                    Đã thanh toán
                                                </span>
                                            @else
                                                <span class="text-xs font-medium text-orange-600">
                                                    Chưa thanh toán
                                                </span>
                                            @endif
                                        </div>

                                    </div>

                                </td>

                                <td class="px-6 py-4">

                                    @if($order->status == 1)
                                        <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700">
                                            Chờ xử lý
                                        </span>
                                    @elseif($order->status == 2)
                                        <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">
                                            Đang giao
                                        </span>
                                    @elseif($order->status == 3)
                                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                            Hoàn thành
                                        </span>
                                    @elseif($order->status == 4)
                                        <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                            Đã hủy
                                        </span>
                                    @endif

                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex justify-end gap-2">

                                        <a
                                            href="{{ route('admin.orders.show', $order->id) }}"
                                            class="rounded-lg border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                                        >
                                            Xem
                                        </a>

                                        @if($order->status < 3)

                                            <form
                                                action="{{ route('admin.orders.update', $order->id) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('PUT')

                                                <input type="hidden" name="status" value="{{ $order->status + 1 }}">

                                                <button
                                                    type="submit"
                                                    class="rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white hover:bg-gray-800"
                                                >
                                                    @if($order->status == 1)
                                                        Duyệt
                                                    @elseif($order->status == 2)
                                                        Hoàn thành
                                                    @endif
                                                </button>
                                            </form>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">
                                    Chưa có đơn hàng nào.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

            @if($orders->hasPages())
                <div class="border-t px-6 py-4">
                    {{ $orders->links() }}
                </div>
            @endif

        </div>

    </div>
@endsection