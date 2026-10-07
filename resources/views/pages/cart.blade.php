@extends('layouts.app')
@section('title', 'Giỏ hàng')

@push('style')
@endpush

@section('content')
    <div class="container mx-auto px-4 py-8">

        {{-- Tiêu đề --}}
        <section class="text-center py-8">
            <div class="flex justify-center items-center gap-3">
                <i class="fa-solid fa-cart-shopping text-4xl text-white"></i>
                <h1 class="text-4xl text-white font-bold">Giỏ hàng</h1>
            </div>
            <p class="text-gray-300 mt-2">Kiểm tra sản phẩm trước khi thanh toán</p>
        </section>

        @if ($cartItems->isNotEmpty())
            {{-- Danh sách sản phẩm --}}
            <div class="overflow-x-auto bg-white rounded-xl shadow-lg p-4">
                <table class="table-auto w-full border-collapse text-black">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-3">Hình ảnh</th>
                            <th class="border border-gray-300 px-4 py-3 text-left">Sản phẩm</th>
                            <th class="border border-gray-300 px-4 py-3">Số lượng</th>
                            <th class="border border-gray-300 px-4 py-3">Đơn giá</th>
                            <th class="border border-gray-300 px-4 py-3">Thành tiền</th>
                            <th class="border border-gray-300 px-4 py-3">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $totalPrice = 0;
                        @endphp

                        @foreach ($cartItems as $item)
                            @php
                                $price = $item->detailProduct->price;
                                $itemTotal = $price * $item->quantity;
                                $totalPrice += $itemTotal;
                                $image = $item->detailProduct->product->thumbnail;
                            @endphp

                            <tr class="hover:bg-gray-50">

                                {{-- Hình ảnh --}}
                                <td class="border border-gray-300 px-4 py-3">
                                    @if ($image)
                                        <img src="{{ Storage::url($image) }}"
                                            alt="{{ $item->detailProduct->product->name }}"
                                            class="w-20 h-20 object-cover mx-auto rounded-lg">
                                    @else
                                        <div class="w-20 h-20 mx-auto flex items-center justify-center bg-gray-200 rounded-lg">
                                            <i class="fa-solid fa-robot text-2xl text-gray-500"></i>
                                        </div>
                                    @endif
                                </td>

                                {{-- Tên sản phẩm --}}
                                <td class="border border-gray-300 px-4 py-3">
                                    <div class="font-semibold text-gray-900">
                                        {{ $item->detailProduct->product->name }}
                                    </div>
                                </td>

                                {{-- Số lượng --}}
                                <td class="border border-gray-300 px-4 py-3">
                                    <div class="flex justify-center items-center">

                                        {{-- Giảm --}}
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <input type="hidden" name="decrease" value="true">

                                            <button type="submit"
                                                class="w-9 h-9 rounded-l-lg bg-gray-200 hover:bg-gray-300 flex items-center justify-center">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                        </form>

                                        {{-- Số lượng --}}
                                        <span class="w-12 h-9 flex items-center justify-center border-t border-b border-gray-300 font-semibold">
                                            {{ $item->quantity }}
                                        </span>

                                        {{-- Tăng --}}
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <input type="hidden" name="increase" value="true">

                                            <button type="submit"
                                                class="w-9 h-9 rounded-r-lg bg-gray-200 hover:bg-gray-300 flex items-center justify-center">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                                {{-- Giá --}}
                                <td class="border border-gray-300 px-4 py-3 text-center">
                                    {{ number_format($price, 0, ',', '.') }} VNĐ
                                </td>

                                {{-- Tổng --}}
                                <td class="border border-gray-300 px-4 py-3 text-center font-semibold">
                                    {{ number_format($itemTotal, 0, ',', '.') }} VNĐ
                                </td>

                                {{-- Xóa --}}
                                <td class="border border-gray-300 px-4 py-3 text-center">
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST"
                                        onsubmit="handleDeleteCart(event)">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                                            <i class="fa-solid fa-trash mr-1"></i>
                                            Xóa
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Tổng tiền --}}
            <div class="mt-6 flex justify-end">
                <div class="w-full md:w-96 bg-white rounded-xl shadow-lg p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-medium">
                            Tổng tiền
                        </span>

                        <span class="text-2xl font-bold text-gray-900">
                            {{ number_format($totalPrice, 0, ',', '.') }} VNĐ
                        </span>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <a href="{{ route('checkout.index') }}"
                            class="w-full inline-flex justify-center items-center gap-2 bg-gray-900 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-800 transition">
                            <i class="fa-solid fa-credit-card"></i>
                            Thanh toán
                        </a>
                    </div>

                </div>
            </div>
        @else
            {{-- Giỏ hàng trống --}}
            <div class="bg-white rounded-xl shadow-lg p-10 text-center text-gray-900">

                <div class="flex justify-center mb-4">
                    <i class="fa-solid fa-cart-shopping text-6xl text-gray-300"></i>
                </div>

                <h2 class="text-2xl font-bold mb-2">
                    Giỏ hàng đang trống
                </h2>

                <p class="text-gray-500 mb-6">
                    Bạn chưa có sản phẩm nào trong giỏ hàng.
                </p>

                <a href="{{ route('home') }}"
                    class="inline-flex items-center gap-2 bg-gray-900 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-800 transition">
                    <i class="fa-solid fa-robot"></i>
                    Tiếp tục mua sắm
                </a>

            </div>
        @endif

    </div>
@endsection

@push('script')
    <script>
        function handleDeleteCart(event) {
            event.preventDefault();

            const isDelete = confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?');

            if (isDelete) {
                event.target.submit();
            }
        }
    </script>
@endpush