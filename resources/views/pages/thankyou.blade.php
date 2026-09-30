@extends('layouts.app')

@push('style')
@endpush

@section('content')
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-lg overflow-hidden">

            {{-- Icon --}}
            <div class="flex justify-center pt-10">
                <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center">
                    <i class="fa-solid fa-check text-4xl text-green-600"></i>
                </div>
            </div>

            {{-- Nội dung --}}
            <div class="text-center px-6 py-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-3">Đặt hàng thành công!</h1>
                <p class="text-gray-600 text-lg mb-2">Cảm ơn bạn đã mua hàng tại Robot Store.</p>
                <p class="text-gray-500">Đơn hàng của bạn đã được tiếp nhận và đang được xử lý.</p>

                {{-- Thông báo --}}
                <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4 text-green-700">
                    <div class="flex items-center justify-center gap-2">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Bạn có thể theo dõi trạng thái đơn hàng trong mục đơn hàng.</span>
                    </div>
                </div>

                {{-- Button --}}
                <div class="mt-8 flex flex-col sm:flex-row justify-center gap-3">
                    <a
                        href="#"
                        class="inline-flex items-center justify-center gap-2 bg-gray-900 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-800 transition"
                    >
                        <i class="fa-solid fa-box"></i>
                        Xem đơn hàng
                    </a>

                    <a
                        href="{{ route('home') }}"
                        class="inline-flex items-center justify-center gap-2 border border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition"
                    >
                        <i class="fa-solid fa-house"></i>
                        Tiếp tục mua sắm
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
@endpush