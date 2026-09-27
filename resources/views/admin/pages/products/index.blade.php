@extends('admin.layouts.app')

@section('title', 'Products')

@section('header', 'Products')

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

    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Products</h1>
            <p class="mt-1 text-sm text-gray-500">Quản lý sản phẩm</p>
        </div>

        <a href="{{ route('admin.products.create') }}"
           class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800">
            Thêm sản phẩm
        </a>
    </div>

    <div class="rounded-xl bg-white p-5 shadow-sm">

        <form action="{{ route('admin.products.search') }}" method="POST"
              class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
            @csrf

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Tìm kiếm
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Tên sản phẩm..."
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-gray-900"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Danh mục
                </label>

                <select
                    name="category_id"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-gray-900">
                    <option value="">Tất cả danh mục</option>

                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Trạng thái
                </label>

                <select
                    name="status"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-gray-900">
                    <option value="">Tất cả</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>
                        Đang kinh doanh
                    </option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>
                        Ngừng kinh doanh
                    </option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button
                    type="submit"
                    class="flex-1 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800">
                    Tìm kiếm
                </button>

                <a
                    href="{{ route('admin.products.index') }}"
                    class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Xóa
                </a>
            </div>
        </form>

    </div>

    <div class="overflow-hidden rounded-xl bg-white shadow-sm">

        <div class="overflow-x-auto">
            <table class="w-full min-w-[1100px] text-left">

                <thead class="border-b bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">#</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Sản phẩm</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Danh mục</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Chi tiết</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Trạng thái</th>
                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-600">Thao tác</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($products as $product)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $products->firstItem() + $loop->index }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">

                                    @if($product->thumbnail)
                                        <img
                                            src="{{ asset('storage/' . $product->thumbnail) }}"
                                            alt="{{ $product->name }}"
                                            class="h-12 w-12 rounded-lg object-cover"
                                        >
                                    @else
                                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 text-xs text-gray-400">
                                            No image
                                        </div>
                                    @endif

                                    <div>
                                        <a href="{{ route('admin.products.show', $product->slug) }}"
                                           class="font-medium text-gray-800 hover:text-blue-600">
                                            {{ $product->name }}
                                        </a>

                                        <p class="text-xs text-gray-500">
                                            {{ $product->slug }}
                                        </p>
                                    </div>

                                </div>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $product->category?->name ?? 'Không có' }}
                            </td>

                            <td class="px-6 py-4">
                                <a href="{{ route('admin.products.detail-products.index', $product->id) }}"
                                   class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                    {{ $product->detailProducts->count() }} chi tiết
                                </a>
                            </td>

                            <td class="px-6 py-4">

                                @if($product->status)
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                        Đang kinh doanh
                                    </span>
                                @else
                                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                        Ngừng kinh doanh
                                    </span>
                                @endif

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    <a href="{{ route('admin.products.show', $product->slug) }}"
                                       class="rounded-lg border px-3 py-2 text-sm hover:bg-gray-50">
                                        Xem
                                    </a>

                                    <a href="{{ route('admin.products.edit', $product->slug) }}"
                                       class="rounded-lg bg-blue-600 px-3 py-2 text-sm text-white hover:bg-blue-700">
                                        Sửa
                                    </a>

                                    <form
                                        action="{{ route('admin.products.destroy', $product->slug) }}"
                                        method="POST"
                                        onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">

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
                            <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">
                                Chưa có sản phẩm nào.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

        @if($products->hasPages())
            <div class="border-t px-6 py-4">
                {{ $products->links() }}
            </div>
        @endif

    </div>

</div>

@endsection