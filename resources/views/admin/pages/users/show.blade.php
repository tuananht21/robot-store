@extends('admin.layouts.app')

@section('title', 'User Details')

@section('header', 'User Details')

@section('content')
    <div class="space-y-6">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 transition hover:text-gray-900">
            <i class="fa-solid fa-arrow-left"></i>
            Quay lại danh sách
        </a>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-xl bg-white p-6 shadow-sm">
                <div class="flex flex-col items-center text-center">
                    @if($user->avatar)
                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="h-24 w-24 rounded-full object-cover">
                    @else
                        <div class="flex h-24 w-24 items-center justify-center rounded-full bg-gray-100 text-3xl text-gray-500">
                            <i class="fa-solid fa-user"></i>
                        </div>
                    @endif

                    <h2 class="mt-4 text-xl font-bold text-gray-800">{{ $user->name }}</h2>
                    <p class="mt-1 text-sm text-gray-500">{{ $user->email }}</p>

                    <span class="mt-4 rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                        Khách hàng
                    </span>
                </div>

                <div class="mt-6 space-y-4 border-t border-gray-100 pt-6">
                    <div class="flex justify-between gap-4 text-sm">
                        <span class="text-gray-500">ID</span>
                        <span class="font-medium text-gray-800">#{{ $user->id }}</span>
                    </div>

                    <div class="flex justify-between gap-4 text-sm">
                        <span class="text-gray-500">Ngày tham gia</span>
                        <span class="font-medium text-gray-800">{{ $user->created_at->format('d/m/Y') }}</span>
                    </div>

                    <div class="flex justify-between gap-4 text-sm">
                        <span class="text-gray-500">Tổng đơn hàng</span>
                        <span class="font-medium text-gray-800">{{ $user->orders_count }}</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Lịch sử đơn hàng</h2>
                        <p class="mt-1 text-sm text-gray-500">Các đơn hàng của khách hàng.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="border-b border-gray-200 text-xs uppercase text-gray-500">
                                    <th class="px-4 py-3">Mã đơn</th>
                                    <th class="px-4 py-3">Tổng tiền</th>
                                    <th class="px-4 py-3">Thanh toán</th>
                                    <th class="px-4 py-3">Trạng thái</th>
                                    <th class="px-4 py-3">Ngày đặt</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">
                                @forelse($user->orders as $order)
                                    <tr>
                                        <td class="px-4 py-4 font-medium text-gray-800">#{{ $order->id }}</td>

                                        <td class="px-4 py-4 text-gray-600">
                                            {{ number_format($order->total_amount, 0, ',', '.') }}đ
                                        </td>

                                        <td class="px-4 py-4">
                                            @if($order->payment_status)
                                                <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">Đã thanh toán</span>
                                            @else
                                                <span class="rounded-full bg-yellow-50 px-3 py-1 text-xs font-semibold text-yellow-700">Chưa thanh toán</span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-4">
                                            @if($order->status == 1)
                                                <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">Chờ xử lý</span>
                                            @elseif($order->status == 2)
                                                <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">Đang giao</span>
                                            @elseif($order->status == 3)
                                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Hoàn thành</span>
                                            @elseif($order->status == 4)
                                                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Đã hủy</span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-4 text-gray-600">
                                            {{ $order->created_at->format('d/m/Y H:i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-10 text-center text-gray-500">
                                            Khách hàng chưa có đơn hàng.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection