@extends('admin.layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('header', 'Order Details')

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

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Đơn hàng #{{ $order->id }}
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Chi tiết thông tin đơn hàng
                </p>
            </div>

            <a
                href="{{ route('admin.orders.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Quay lại
            </a>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            {{-- Thông tin khách hàng --}}
            <div class="rounded-xl bg-white p-5 shadow-sm lg:col-span-2">

                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">
                            Thông tin khách hàng
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Thông tin người đặt hàng
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                    <div>
                        <p class="text-sm text-gray-500">
                            Họ tên
                        </p>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ $order->customer_name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">
                            Số điện thoại
                        </p>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ $order->phone }}
                        </p>
                    </div>

                    <div class="sm:col-span-2">
                        <p class="text-sm text-gray-500">
                            Địa chỉ
                        </p>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ $order->address }}
                        </p>
                    </div>

                    @if($order->note)
                        <div class="sm:col-span-2">
                            <p class="text-sm text-gray-500">
                                Ghi chú
                            </p>

                            <p class="mt-1 font-medium text-gray-800">
                                {{ $order->note }}
                            </p>
                        </div>
                    @endif

                </div>

            </div>

            {{-- Trạng thái đơn --}}
            <div class="rounded-xl bg-white p-5 shadow-sm">

                <h2 class="text-lg font-semibold text-gray-800">
                    Trạng thái
                </h2>

                <div class="mt-5 space-y-4">

                    <div>
                        <p class="text-sm text-gray-500">
                            Trạng thái đơn hàng
                        </p>

                        <div class="mt-2">
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
                        </div>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">
                            Phương thức thanh toán
                        </p>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ $order->payment_method == 0 ? 'VNPay' : 'COD' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">
                            Trạng thái thanh toán
                        </p>

                        <div class="mt-2">
                            @if($order->payment_status)
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                    Đã thanh toán
                                </span>
                            @else
                                <span class="rounded-full bg-orange-100 px-3 py-1 text-xs font-medium text-orange-700">
                                    Chưa thanh toán
                                </span>
                            @endif
                        </div>
                    </div>

                </div>

            </div>

        </div>

        {{-- Danh sách sản phẩm --}}
        <div class="overflow-hidden rounded-xl bg-white shadow-sm">

            <div class="border-b px-6 py-5">
                <h2 class="text-lg font-semibold text-gray-800">
                    Sản phẩm trong đơn
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Danh sách sản phẩm khách hàng đã đặt
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px] text-left">

                    <thead class="border-b bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Sản phẩm
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Đơn giá
                            </th>

                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600">
                                Số lượng
                            </th>

                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-600">
                                Thành tiền
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        @forelse($order->detailOrders as $detailOrder)

                            @php
                                $detailProduct = $detailOrder->detailProduct;
                                $product = $detailProduct?->product;
                                $quantity = $detailOrder->quantity ?? 1;
                                $price = $detailProduct->price ?? 0;
                                $subtotal = $price * $quantity;
                            @endphp

                            <tr class="hover:bg-gray-50">

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">

                                        @if($product?->thumbnail)
                                            <img
                                                src="{{ asset('storage/' . $product->thumbnail) }}"
                                                alt="{{ $product->name }}"
                                                class="h-14 w-14 rounded-lg object-cover"
                                            >
                                        @else
                                            <div class="flex h-14 w-14 items-center justify-center rounded-lg bg-gray-100 text-xs text-gray-400">
                                                No image
                                            </div>
                                        @endif

                                        <div>
                                            <p class="font-medium text-gray-800">
                                                {{ $product?->name ?? 'Sản phẩm không tồn tại' }}
                                            </p>

                                            @if($detailProduct)
                                                <p class="mt-1 text-xs text-gray-500">
                                                    Chi tiết #{{ $detailProduct->id }}
                                                </p>
                                            @endif
                                        </div>

                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ number_format($price, 0, ',', '.') }} ₫
                                </td>

                                <td class="px-6 py-4 text-center text-sm font-medium text-gray-800">
                                    {{ $quantity }}
                                </td>

                                <td class="px-6 py-4 text-right text-sm font-semibold text-gray-800">
                                    {{ number_format($subtotal, 0, ',', '.') }} ₫
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500">
                                    Đơn hàng chưa có sản phẩm.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>

        {{-- Tổng tiền --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

            <div class="rounded-xl bg-white p-5 shadow-sm">

                <h2 class="text-lg font-semibold text-gray-800">
                    Thông tin đơn hàng
                </h2>

                <div class="mt-5 space-y-4">

                    <div class="flex justify-between gap-4">
                        <span class="text-sm text-gray-500">
                            Mã đơn hàng
                        </span>

                        <span class="text-sm font-medium text-gray-800">
                            #{{ $order->id }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-sm text-gray-500">
                            Ngày đặt
                        </span>

                        <span class="text-sm font-medium text-gray-800">
                            {{ $order->created_at?->format('d/m/Y H:i') }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-sm text-gray-500">
                            Phí vận chuyển
                        </span>

                        <span class="text-sm font-medium text-gray-800">
                            {{ number_format($order->shipping_fee, 0, ',', '.') }} ₫
                        </span>
                    </div>

                </div>

            </div>

            <div class="rounded-xl bg-white p-5 shadow-sm">

                <h2 class="text-lg font-semibold text-gray-800">
                    Thanh toán
                </h2>

                <div class="mt-5 space-y-4">

                    <div class="flex justify-between gap-4">
                        <span class="text-sm text-gray-500">
                            Phương thức
                        </span>

                        <span class="text-sm font-medium text-gray-800">
                            {{ $order->payment_method == 0 ? 'VNPay' : 'COD' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4 border-t pt-4">
                        <span class="font-semibold text-gray-800">
                            Tổng thanh toán
                        </span>

                        <span class="text-xl font-bold text-gray-900">
                            {{ number_format($order->total_amount, 0, ',', '.') }} ₫
                        </span>
                    </div>

                </div>

            </div>

        </div>

        {{-- Cập nhật trạng thái --}}
        @if($order->status < 3)

            <div class="rounded-xl bg-white p-5 shadow-sm">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">
                            Xử lý đơn hàng
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Cập nhật trạng thái đơn hàng.
                        </p>
                    </div>

                    <form
                        action="{{ route('admin.orders.update', $order->id) }}"
                        method="POST"
                    >
                        @csrf
                        @method('PUT')

                        <input
                            type="hidden"
                            name="status"
                            value="{{ $order->status + 1 }}"
                        >

                        <button
                            type="submit"
                            class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-800"
                        >
                            @if($order->status == 1)
                                Duyệt đơn hàng
                            @elseif($order->status == 2)
                                Xác nhận hoàn thành
                            @endif
                        </button>
                    </form>

                </div>

            </div>

        @endif

    </div>
@endsection