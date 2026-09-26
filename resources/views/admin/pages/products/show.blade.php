@extends('admin.layouts.app')

@section('title', 'Chi tiết sản phẩm')

@section('header', 'Chi tiết sản phẩm')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                {{ $product->name }}
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Chi tiết sản phẩm
            </p>
        </div>

        <div class="flex gap-2">

            <a href="{{ route('admin.products.edit', $product->slug) }}"
               class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                Sửa
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="rounded-lg border px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Quay lại
            </a>

        </div>

    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        <div class="rounded-xl bg-white p-6 shadow-sm">

            @if($product->thumbnail)

                <img
                    src="{{ asset('storage/' . $product->thumbnail) }}"
                    alt="{{ $product->name }}"
                    class="w-full rounded-xl object-cover"
                >

            @else

                <div class="flex aspect-square items-center justify-center rounded-xl bg-gray-100 text-gray-400">
                    Không có hình ảnh
                </div>

            @endif

        </div>

        <div class="rounded-xl bg-white p-6 shadow-sm lg:col-span-2">

            <div class="space-y-5">

                <div>
                    <p class="text-sm text-gray-500">Tên sản phẩm</p>
                    <p class="mt-1 font-semibold text-gray-800">
                        {{ $product->name }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Slug</p>
                    <p class="mt-1 text-gray-800">
                        {{ $product->slug }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Danh mục</p>
                    <p class="mt-1 text-gray-800">
                        {{ $product->category?->name ?? 'Không có' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Trạng thái</p>

                    <div class="mt-1">

                        @if($product->status)
                            <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                Đang kinh doanh
                            </span>
                        @else
                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                Ngừng kinh doanh
                            </span>
                        @endif

                    </div>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Mô tả</p>

                    <div class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-700">
                        {{ $product->description ?: 'Chưa có mô tả.' }}
                    </div>
                </div>

            </div>

        </div>

    </div>

    <div class="rounded-xl bg-white shadow-sm">

        <div class="flex flex-col gap-3 border-b p-6 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="font-bold text-gray-800">Chi tiết sản phẩm</h2>

                <p class="mt-1 text-sm text-gray-500">
                    {{ $product->detailProducts->count() }} chi tiết
                </p>
            </div>

            <a
                href="{{ route('admin.products.detail-products.create', $product->id) }}"
                class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800">
                Thêm chi tiết
            </a>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full min-w-[800px] text-left">

                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">#</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Tên</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Giá</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Thao tác</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($product->detailProducts as $detail)

                        <tr>

                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-800">
                                {{ $detail->name ?? $detail->id }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-800">
                                {{ number_format($detail->price ?? 0) }} đ
                            </td>

                            <td class="px-6 py-4">

                                <a
                                    href="{{ route('admin.products.detail-products.edit', [$product->id, $detail->id]) }}"
                                    class="rounded-lg bg-blue-600 px-3 py-2 text-sm text-white">
                                    Sửa
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">
                                Chưa có detail product.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection