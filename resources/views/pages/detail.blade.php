@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <a
                href="{{ route('orders.index') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-600 transition hover:text-gray-900"
            >
                <i class="fa-solid fa-arrow-left"></i>
                Quay lại đơn hàng
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-lg bg-red-100 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="rounded-2xl bg-white p-6 shadow-sm sm:p-8">
            <div class="flex flex-col gap-4 border-b border-gray-200 pb-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Chi tiết đơn hàng #{{ $order->id }}
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Đặt ngày {{ $order->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>

                <div>
                    @if ($order->status == 1)
                        <span class="rounded-full bg-yellow-100 px-4 py-2 text-sm font-medium text-yellow-700">
                            Đang xử lý
                        </span>
                    @elseif ($order->status == 2)
                        <span class="rounded-full bg-blue-100 px-4 py-2 text-sm font-medium text-blue-700">
                            Đang giao hàng
                        </span>
                    @elseif ($order->status == 3)
                        <span class="rounded-full bg-green-100 px-4 py-2 text-sm font-medium text-green-700">
                            Đã hoàn thành
                        </span>
                    @elseif ($order->status == 4)
                        <span class="rounded-full bg-red-100 px-4 py-2 text-sm font-medium text-red-700">
                            Đã hủy
                        </span>
                    @endif
                </div>
            </div>

            <div class="mt-6 grid gap-6 md:grid-cols-2">
                <div class="rounded-xl bg-gray-50 p-5">
                    <h2 class="font-semibold text-gray-900">
                        Thông tin nhận hàng
                    </h2>

                    <div class="mt-4 space-y-2 text-sm text-gray-600">
                        <p>
                            <span class="font-medium text-gray-900">Họ tên:</span>
                            {{ $order->customer_name }}
                        </p>

                        <p>
                            <span class="font-medium text-gray-900">Số điện thoại:</span>
                            {{ $order->phone }}
                        </p>

                        <p>
                            <span class="font-medium text-gray-900">Địa chỉ:</span>
                            {{ $order->address }}
                        </p>
                    </div>
                </div>

                <div class="rounded-xl bg-gray-50 p-5">
                    <h2 class="font-semibold text-gray-900">
                        Thanh toán
                    </h2>

                    <div class="mt-4 space-y-2 text-sm text-gray-600">
                        <p>
                            <span class="font-medium text-gray-900">Phương thức:</span>

                            @if ($order->payment_method == 0)
                                VNPay
                            @else
                                COD
                            @endif
                        </p>

                        <p>
                            <span class="font-medium text-gray-900">Trạng thái:</span>

                            @if ($order->payment_status == 1)
                                <span class="font-medium text-green-600">
                                    Đã thanh toán
                                </span>
                            @else
                                <span class="font-medium text-yellow-600">
                                    Chưa thanh toán
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h2 class="text-xl font-bold text-gray-900">
                    Sản phẩm trong đơn hàng
                </h2>

                <div class="mt-4 space-y-5">
                    @foreach ($order->detailOrders as $detail)
                        @php
                            $detailProduct = $detail->detailProduct;
                            $product = $detailProduct?->product;
                            $image = $detailProduct?->images?->first();
                            $review = $detail->reviews?->first();
                        @endphp

                        <div class="rounded-xl border border-gray-200 p-5">
                            <div class="flex flex-col gap-5 sm:flex-row">
                                <div class="h-24 w-24 shrink-0 overflow-hidden rounded-lg bg-gray-100">
                                    @if ($image)
                                        <img
                                            src="{{ asset('storage/' . $image->image) }}"
                                            alt="{{ $product?->name ?? 'Sản phẩm' }}"
                                            class="h-full w-full object-cover"
                                        >
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-gray-400">
                                            <i class="fa-solid fa-image text-2xl"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">
                                        {{ $product?->name ?? 'Sản phẩm' }}
                                    </h3>

                                    <p class="mt-2 text-sm text-gray-500">
                                        Số lượng: {{ $detail->quantity }}
                                    </p>

                                    <p class="mt-2 font-semibold text-gray-900">
                                        {{ number_format($detail->sum_price, 0, ',', '.') }} VNĐ
                                    </p>
                                </div>
                            </div>

                            @if ($order->status == 3)
                                <div class="mt-5 border-t border-gray-200 pt-5">
                                    @if ($review)
                                        <div>
                                            <div class="flex items-center gap-2 text-sm font-semibold text-green-600">
                                                <i class="fa-solid fa-circle-check"></i>
                                                Bạn đã đánh giá sản phẩm này
                                            </div>

                                            <div class="mt-3 text-yellow-400">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fa-solid fa-star {{ $i <= $review->rating ? '' : 'text-gray-300' }}"></i>
                                                @endfor
                                            </div>

                                            @if ($review->content)
                                                <p class="mt-2 text-sm leading-6 text-gray-600">
                                                    {{ $review->content }}
                                                </p>
                                            @endif
                                        </div>
                                    @else
                                        <form
                                            action="{{ route('reviews.store', $product->slug) }}"
                                            method="POST"
                                        >
                                            @csrf

                                            <input
                                                type="hidden"
                                                name="detail_order_id"
                                                value="{{ $detail->id }}"
                                            >

                                            <input
                                                type="hidden"
                                                name="detail_product_id"
                                                value="{{ $detail->detail_product_id }}"
                                            >

                                            <h4 class="font-semibold text-gray-900">
                                                Đánh giá sản phẩm
                                            </h4>

                                            <div class="mt-4">
                                                <label class="block text-sm font-medium text-gray-700">
                                                    Chọn số sao
                                                </label>

                                                <div class="mt-2 flex gap-2">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <label class="cursor-pointer">
                                                            <input
                                                                type="radio"
                                                                name="rating"
                                                                value="{{ $i }}"
                                                                class="peer hidden"
                                                                required
                                                            >

                                                            <i class="fa-solid fa-star text-2xl text-gray-300 transition peer-checked:text-yellow-400"></i>
                                                        </label>
                                                    @endfor
                                                </div>
                                            </div>

                                            <div class="mt-4">
                                                <label class="block text-sm font-medium text-gray-700">
                                                    Nhận xét
                                                </label>

                                                <textarea
                                                    name="content"
                                                    rows="3"
                                                    maxlength="1000"
                                                    class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500"
                                                    placeholder="Chia sẻ cảm nhận của bạn về sản phẩm..."
                                                ></textarea>
                                            </div>

                                            <button
                                                type="submit"
                                                class="mt-4 rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700"
                                            >
                                                <i class="fa-solid fa-star mr-1"></i>
                                                Gửi đánh giá
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-8 border-t border-gray-200 pt-6">
                <div class="flex items-center justify-between">
                    <span class="text-lg font-semibold text-gray-900">
                        Tổng tiền
                    </span>

                    <span class="text-2xl font-bold text-gray-900">
                        {{ number_format($order->total_amount, 0, ',', '.') }} VNĐ
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection