@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Đơn hàng của tôi</h1>
                <p class="mt-2 text-sm text-gray-500">Theo dõi các đơn hàng bạn đã đặt.</p>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-6 rounded-xl bg-white p-4 shadow-sm">
                <form action="{{ route('orders.index') }}" method="GET" class="flex flex-col gap-3 md:flex-row">
                    <select name="filter_status" class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-gray-900">
                        <option value="all" {{ $filterStatus === 'all' ? 'selected' : '' }}>Tất cả đơn hàng</option>
                        <option value="1" {{ $filterStatus == 1 ? 'selected' : '' }}>Đang xử lý</option>
                        <option value="2" {{ $filterStatus == 2 ? 'selected' : '' }}>Đang giao hàng</option>
                        <option value="3" {{ $filterStatus == 3 ? 'selected' : '' }}>Đã hoàn thành</option>
                        <option value="4" {{ $filterStatus == 4 ? 'selected' : '' }}>Đã hủy</option>
                    </select>

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo mã đơn hàng..." class="flex-1 rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-gray-900">

                    <button type="submit" class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700">
                        Tìm kiếm
                    </button>
                </form>
            </div>

            @if ($orders->count())
                <div class="space-y-5">
                    @foreach ($orders as $order)
                        <div class="overflow-hidden rounded-xl bg-white shadow-sm">

                            <div class="flex flex-col gap-3 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Mã đơn hàng</p>
                                    <p class="font-bold text-gray-900">#{{ $order->id }}</p>
                                </div>

                                <div class="text-left sm:text-right">
                                    <p class="text-sm text-gray-500">Ngày đặt</p>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $order->created_at?->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>

                            <div class="divide-y divide-gray-100">
                                @foreach ($order->detailOrders as $detail)
                                    @php
                                        $detailProduct = $detail->detailProduct;
                                        $product = $detailProduct?->product;
                                        $image = $detailProduct?->images?->first();
                                    @endphp

                                    <div class="flex gap-4 px-5 py-4">
                                        <div class="h-20 w-20 shrink-0 overflow-hidden rounded-lg bg-gray-100">
                                            @if ($image)
                                                <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product?->name }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="flex h-full w-full items-center justify-center text-xs text-gray-400">
                                                    Không có ảnh
                                                </div>
                                            @endif
                                        </div>

                                        <div class="min-w-0 flex-1">
                                            <h3 class="font-semibold text-gray-900">
                                                {{ $product?->name ?? 'Sản phẩm' }}
                                            </h3>

                                            <p class="mt-1 text-sm text-gray-500">
                                                Số lượng: {{ $detail->quantity }}
                                            </p>

                                            <p class="mt-1 font-semibold text-gray-900">
                                                {{ number_format($detail->sum_price, 0, ',', '.') }} VNĐ
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex flex-col gap-4 border-t border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Tổng tiền</p>
                                    <p class="text-xl font-bold text-gray-900">
                                        {{ number_format($order->total_amount, 0, ',', '.') }} VNĐ
                                    </p>
                                </div>

                                <div class="flex items-center gap-3">
                                    @if ($order->status == 1)
                                        <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                            Đang xử lý
                                        </span>
                                    @elseif ($order->status == 2)
                                        <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                            Đang giao hàng
                                        </span>
                                    @elseif ($order->status == 3)
                                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            Đã hoàn thành
                                        </span>
                                    @elseif ($order->status == 4)
                                        <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                            Đã hủy
                                        </span>
                                    @endif

                                    <a href="{{ route('orders.show', $order->id) }}" class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-700">
                                        Chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="rounded-xl bg-white px-6 py-16 text-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2ZM8 7V5a4 4 0 0 1 8 0v2M9 12h6" />
                    </svg>

                    <h2 class="mt-4 text-lg font-semibold text-gray-900">
                        Chưa có đơn hàng
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Bạn chưa có đơn hàng nào.
                    </p>

                    <a href="{{ route('products') }}" class="mt-5 inline-flex rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700">
                        Xem sản phẩm
                    </a>
                </div>
            @endif

        </div>
    </div>
@endsection