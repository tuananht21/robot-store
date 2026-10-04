@extends('layouts.app')

@section('title', 'Sản phẩm - Robot Store')

@section('content')
    <section class="bg-gray-50 py-12 sm:py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Sản phẩm</h1>
                <p class="mt-2 text-gray-600">Khám phá các sản phẩm robot tại Robot Store.</p>
            </div>

            <div class="mb-8 rounded-2xl bg-white p-5 shadow-sm">
                <form action="{{ route('products') }}" method="GET">
                    <div class="grid gap-4 md:grid-cols-3">
                        <div>
                            <label for="search" class="mb-2 block text-sm font-medium text-gray-700">Tìm kiếm</label>

                            <input type="text" id="search" name="search" value="{{ request('search') }}"
                                placeholder="Tìm kiếm sản phẩm..."
                                class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-gray-900 focus:ring-1 focus:ring-gray-900">
                        </div>

                        <div>
                            <label for="category" class="mb-2 block text-sm font-medium text-gray-700">Danh mục</label>

                            <select id="category" name="category"
                                class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-gray-900 focus:ring-1 focus:ring-gray-900">
                                <option value="">Tất cả danh mục</option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                        {{ $category->name }} ({{ $category->products_count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-end gap-3">
                            <button type="submit"
                                class="flex-1 rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white hover:bg-gray-800">
                                Lọc sản phẩm
                            </button>

                            @if (request('search') || request('category'))
                                <a href="{{ route('products') }}"
                                    class="rounded-xl border border-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50">Xóa</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <div class="mb-6">
                <p class="text-sm text-gray-600">
                    Có <span class="font-semibold text-gray-900">{{ $products->total() }}</span> sản phẩm
                </p>
            </div>

            @if ($products->count())
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($products as $product)
                        @php
                            $detail = $product->detailProducts->first();
                            $price = $detail?->price ?? 0;
                            $salePrice = $detail?->sale_price ?? 0;
                            $stock = $detail?->inStock?->stock ?? 0;
                            $displayPrice = $salePrice > 0 ? $salePrice : $price;
                            $hasSale = $salePrice > 0 && $salePrice < $price;
                        @endphp

                        <article
                            class="group overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-100 transition hover:-translate-y-1 hover:shadow-lg">
                            <div class="relative aspect-square overflow-hidden bg-gray-100">
                                @if ($product->thumbnail)
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                                        class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                @else
                                    <div class="flex h-full items-center justify-center">
                                        <i class="fa-regular fa-image text-5xl text-gray-300"></i>
                                    </div>
                                @endif

                                @if ($hasSale)
                                    <span
                                        class="absolute left-3 top-3 rounded-full bg-red-500 px-3 py-1 text-xs font-bold text-white">SALE</span>
                                @endif
                            </div>

                            <div class="p-5">
                                @if ($product->category)
                                    <p class="mb-2 text-xs font-medium uppercase tracking-wide text-gray-500">
                                        {{ $product->category->name }}</p>
                                @endif

                                <h2 class="min-h-[3.5rem] text-lg font-semibold text-gray-900">{{ $product->name }}</h2>

                                <div class="mt-4">
                                    @if ($displayPrice > 0)
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="text-xl font-bold text-gray-900">{{ number_format($displayPrice, 0, ',', '.') }}đ</span>

                                            @if ($hasSale)
                                                <span
                                                    class="text-sm text-gray-400 line-through">{{ number_format($price, 0, ',', '.') }}đ</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-xl font-bold text-gray-400">Liên hệ</span>
                                    @endif
                                </div>

                                <div class="mt-4 border-t border-gray-100 pt-4">
                                    <span class="text-sm text-gray-500">
                                        <i class="fa-solid fa-box mr-1"></i>
                                        {{ $stock > 0 ? 'Còn ' . $stock . ' sản phẩm' : 'Hết hàng' }}
                                    </span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            @else
                <div class="rounded-2xl bg-white px-6 py-16 text-center shadow-sm">
                    <i class="fa-solid fa-box-open text-4xl text-gray-300"></i>
                    <h2 class="mt-5 text-xl font-semibold text-gray-900">Không tìm thấy sản phẩm</h2>
                    <p class="mt-2 text-sm text-gray-500">Không có sản phẩm nào phù hợp với điều kiện tìm kiếm.</p>
                </div>
            @endif

        </div>
    </section>
@endsection
