@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">

        <section class="text-center py-8">
            <div class="flex justify-center items-center gap-3">
                <i class="fa-solid fa-credit-card text-4xl text-white"></i>
                <h1 class="text-4xl text-white font-bold">Thanh toán</h1>
            </div>
            <p class="text-gray-300 mt-2">Kiểm tra thông tin trước khi đặt hàng</p>
        </section>

        @if ($errors->any())
            <div class="max-w-6xl mx-auto mb-6 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-6xl mx-auto mb-6 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">

                <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6 text-gray-900">

                    <h2 class="text-2xl font-bold mb-6">
                        <i class="fa-solid fa-location-dot mr-2"></i>
                        Thông tin nhận hàng
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div>
                            <label class="block font-semibold mb-2">
                                Họ và tên
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', Auth::user()->name ?? '') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3"
                                placeholder="Nhập họ và tên"
                            >
                        </div>

                        <div>
                            <label class="block font-semibold mb-2">
                                Số điện thoại
                            </label>

                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3"
                                placeholder="0912345678 hoặc +84912345678"
                            >
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-semibold mb-2">
                                Địa chỉ
                            </label>

                            <input
                                type="text"
                                name="address"
                                value="{{ old('address') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3"
                                placeholder="Số nhà, tên đường"
                            >
                        </div>

                        <div>
                            <label class="block font-semibold mb-2">
                                Phường/Xã
                            </label>

                            <input
                                type="text"
                                name="ward"
                                value="{{ old('ward') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3"
                                placeholder="Nhập phường/xã"
                            >
                        </div>

                        <div>
                            <label class="block font-semibold mb-2">
                                Tỉnh/Thành phố
                            </label>

                            <input
                                type="text"
                                name="provinces"
                                value="{{ old('provinces') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3"
                                placeholder="Nhập tỉnh/thành phố"
                            >
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-semibold mb-2">
                                Ghi chú
                            </label>

                            <textarea
                                name="note"
                                rows="4"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3"
                                placeholder="Ghi chú cho đơn hàng..."
                            >{{ old('note') }}</textarea>
                        </div>

                    </div>

                    <div class="mt-8">

                        <h2 class="text-2xl font-bold mb-5">
                            <i class="fa-solid fa-wallet mr-2"></i>
                            Phương thức thanh toán
                        </h2>

                        <div class="space-y-3">

                            <label class="flex items-center gap-3 border border-gray-300 rounded-lg p-4 cursor-pointer">
                                <input
                                    type="radio"
                                    name="payment"
                                    value="cod"
                                    {{ old('payment', 'cod') === 'cod' ? 'checked' : '' }}
                                >

                                <div>
                                    <div class="font-semibold">
                                        Thanh toán khi nhận hàng
                                    </div>

                                    <div class="text-sm text-gray-500">
                                        Thanh toán khi nhận sản phẩm.
                                    </div>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 border border-gray-300 rounded-lg p-4 cursor-pointer">
                                <input
                                    type="radio"
                                    name="payment"
                                    value="online"
                                    {{ old('payment') === 'online' ? 'checked' : '' }}
                                >

                                <div>
                                    <div class="font-semibold">
                                        Thanh toán Online
                                    </div>

                                    <div class="text-sm text-gray-500">
                                        Thanh toán trực tuyến.
                                    </div>
                                </div>
                            </label>

                        </div>

                    </div>

                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 text-gray-900 h-fit">

                    <h2 class="text-2xl font-bold mb-6">
                        <i class="fa-solid fa-cart-shopping mr-2"></i>
                        Đơn hàng
                    </h2>

                    <div class="space-y-4">

                        @foreach ($cartItems as $item)

                            @php
                                $price = $item->detailProduct->price;
                                $itemTotal = $price * $item->quantity;
                                $image = $item->detailProduct->images->first();
                            @endphp

                            <div class="flex gap-3 border-b border-gray-200 pb-4">

                                @if ($image)
                                    <img
                                        src="{{ Storage::url($image->path) }}"
                                        alt="{{ $item->detailProduct->product->name }}"
                                        class="w-20 h-20 object-cover rounded-lg"
                                    >
                                @else
                                    <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i class="fa-solid fa-robot text-2xl text-gray-500"></i>
                                    </div>
                                @endif

                                <div class="flex-1">

                                    <h3 class="font-semibold">
                                        {{ $item->detailProduct->product->name }}
                                    </h3>

                                    <p class="text-sm text-gray-500">
                                        Số lượng: {{ $item->quantity }}
                                    </p>

                                    <p class="font-semibold mt-1">
                                        {{ number_format($itemTotal, 0, ',', '.') }} VNĐ
                                    </p>

                                </div>

                            </div>

                        @endforeach

                    </div>

                    <div class="border-t border-gray-200 mt-5 pt-5">

                        <div class="flex justify-between mb-3">
                            <span>Tạm tính</span>

                            <span class="font-semibold">
                                {{ number_format($totalAmount, 0, ',', '.') }} VNĐ
                            </span>
                        </div>

                        <div class="flex justify-between mb-3">
                            <span>Phí vận chuyển</span>

                            <span class="font-semibold">
                                0 VNĐ
                            </span>
                        </div>

                        <div class="border-t border-gray-200 pt-4 flex justify-between">

                            <span class="text-lg font-bold">
                                Tổng cộng
                            </span>

                            <span class="text-xl font-bold">
                                {{ number_format($totalAmount, 0, ',', '.') }} VNĐ
                            </span>

                        </div>

                    </div>

                    <input
                        type="hidden"
                        name="shipping_fee"
                        value="0"
                    >

                    <button
                        type="submit"
                        class="w-full mt-6 bg-gray-900 text-white py-3 rounded-lg font-semibold hover:bg-gray-800 transition"
                    >
                        <i class="fa-solid fa-check mr-2"></i>
                        Đặt hàng
                    </button>

                    <a
                        href="{{ route('cart') }}"
                        class="w-full mt-3 inline-flex justify-center items-center gap-2 border border-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-100 transition"
                    >
                        <i class="fa-solid fa-arrow-left"></i>
                        Quay lại giỏ hàng
                    </a>

                </div>

            </div>
        </form>
    </div>
@endsection