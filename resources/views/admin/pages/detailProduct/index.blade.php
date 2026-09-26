@extends('admin.layouts.app')

@section('title', 'Detail Products')

@section('header', 'Detail Products')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Detail Products
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Các phiên bản của {{ $product->name }}
            </p>
        </div>

        <a
            href="{{ route('admin.products.detail-products.create', $product->id) }}"
            class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800">
            Thêm detail product
        </a>

    </div>

    <div class="rounded-xl bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px] text-left">

                <thead class="border-b bg-gray-50">

                    <tr>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">#</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Thông tin</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Giá</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Tồn kho</th>
                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-600">Thao tác</th>
                    </tr>

                </thead>

                <tbody class="divide-y">

                    @forelse($detailProducts as $detail)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $detailProducts->firstItem() + $loop->index }}
                            </td>

                            <td class="px-6 py-4">

                                <div class="font-medium text-gray-800">
                                    {{ $detail->name ?? 'Detail #' . $detail->id }}
                                </div>

                                <div class="mt-1 text-xs text-gray-500">
                                    ID: {{ $detail->id }}
                                </div>

                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ number_format($detail->price ?? 0) }} đ
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700">

                                @php
                                    $stock = $detail->inStocks->sum('stock');
                                @endphp

                                {{ $stock }}

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    <a
                                        href="{{ route('admin.products.detail-products.edit', [$product->id, $detail->id]) }}"
                                        class="rounded-lg bg-blue-600 px-3 py-2 text-sm text-white hover:bg-blue-700">
                                        Sửa
                                    </a>

                                    <a
                                        href="{{ route('admin.detail-products.in-stock.index', $detail->id) }}"
                                        class="rounded-lg border px-3 py-2 text-sm hover:bg-gray-50">
                                        Tồn kho
                                    </a>

                                    <form
                                        action="{{ route('admin.products.detail-products.destroy', [$product->id, $detail->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Bạn có chắc muốn xóa detail product này?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg bg-red-600 px-3 py-2 text-sm text-white hover:bg-red-700">
                                            Xóa
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500">
                                Chưa có detail product.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($detailProducts->hasPages())
            <div class="border-t px-6 py-4">
                {{ $detailProducts->links() }}
            </div>
        @endif

    </div>

</div>

@endsection