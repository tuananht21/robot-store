@extends('layouts.app')

@push('style')
@endpush

@section('content')
    <div class="container mx-auto px-4 py-10">
        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="text-center px-6 py-8 border-b border-gray-200">
                @if($paymentData['vnp_ResponseCode'] == '00' && $paymentData['vnp_TransactionStatus'] == '00')
                    <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center rounded-full bg-green-100">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-green-600">Thanh toán thành công</h2>
                    <p class="mt-2 text-gray-500">Cảm ơn bạn đã mua sản phẩm tại Robot Store.</p>
                @else
                    <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center rounded-full bg-red-100">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-red-600">Thanh toán thất bại</h2>
                    <p class="mt-2 text-gray-500">Giao dịch chưa được thực hiện thành công.</p>
                @endif
            </div>

            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-5">Thông tin thanh toán</h3>

                <div class="space-y-4 text-sm">
                    <div class="flex justify-between gap-4">
                        <span class="font-medium text-gray-600">Mã đơn hàng</span>
                        <span class="font-semibold text-gray-900">{{ $paymentData['vnp_TxnRef'] ?? 'N/A' }}</span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="font-medium text-gray-600">Số tiền</span>
                        <span class="font-semibold text-gray-900">
                            {{ number_format(($paymentData['vnp_Amount'] ?? 0) / 100, 0, ',', '.') }} VNĐ
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="font-medium text-gray-600">Ngân hàng</span>
                        <span class="text-gray-900">{{ $paymentData['vnp_BankCode'] ?? 'N/A' }}</span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="font-medium text-gray-600">Mã giao dịch ngân hàng</span>
                        <span class="text-gray-900">{{ $paymentData['vnp_BankTranNo'] ?? 'N/A' }}</span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="font-medium text-gray-600">Mã giao dịch VNPay</span>
                        <span class="text-gray-900">{{ $paymentData['vnp_TransactionNo'] ?? 'N/A' }}</span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="font-medium text-gray-600">Loại thẻ</span>
                        <span class="text-gray-900">{{ $paymentData['vnp_CardType'] ?? 'N/A' }}</span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="font-medium text-gray-600">Nội dung thanh toán</span>
                        <span class="text-gray-900 text-right">
                            {{ isset($paymentData['vnp_OrderInfo']) ? urldecode($paymentData['vnp_OrderInfo']) : 'N/A' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="font-medium text-gray-600">Thời gian thanh toán</span>
                        <span class="text-gray-900">
                            {{ isset($paymentData['vnp_PayDate']) ? \Carbon\Carbon::createFromFormat('YmdHis', $paymentData['vnp_PayDate'])->format('d/m/Y H:i:s') : 'N/A' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="font-medium text-gray-600">Mã phản hồi</span>
                        <span class="text-gray-900">{{ $paymentData['vnp_ResponseCode'] ?? 'N/A' }}</span>
                    </div>

                    <div class="flex justify-between gap-4 pt-4 border-t border-gray-200">
                        <span class="font-semibold text-gray-700">Trạng thái</span>

                        @if($paymentData['vnp_ResponseCode'] == '00' && $paymentData['vnp_TransactionStatus'] == '00')
                            <span class="font-semibold text-green-600">Thanh toán thành công</span>
                        @else
                            <span class="font-semibold text-red-600">Thanh toán thất bại</span>
                        @endif
                    </div>
                </div>

                <div class="mt-8 flex justify-center">
                    <a href="{{ url('/') }}" class="inline-block px-6 py-3 bg-gray-900 text-white font-medium rounded-lg hover:bg-gray-800 transition">
                        Quay về trang chủ
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
@endpush