@extends('layouts.app')

@section('title', $product->name . ' - Robot Store')

@section('content')
    <section class="bg-gray-50 py-8 sm:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-6">
                <a href="{{ route('products') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-500 transition hover:text-gray-900">
                    ← Quay lại sản phẩm
                </a>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">

                <div class="rounded-2xl bg-white p-4 shadow-sm sm:p-6">
                    @if ($product->thumbnail)
                        <div class="overflow-hidden rounded-xl bg-gray-100">
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                                class="aspect-square w-full object-cover">
                        </div>
                    @else
                        <div class="flex aspect-square items-center justify-center rounded-xl bg-gray-100">
                            <span class="text-7xl">🤖</span>
                        </div>
                    @endif
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm sm:p-8">

                    <p class="text-sm font-medium text-blue-600">
                        {{ $product->category?->name ?? 'Robot Store' }}
                    </p>

                    <h1 class="mt-2 text-3xl font-bold leading-tight text-gray-900 sm:text-4xl">
                        {{ $product->name }}
                    </h1>

                    <div class="mt-5">
                        <p class="text-sm font-semibold text-gray-900">
                            Mô tả sản phẩm
                        </p>

                        <p class="mt-2 whitespace-pre-line leading-7 text-gray-600">
                            {{ $product->description ?? 'Sản phẩm chưa có mô tả.' }}
                        </p>
                    </div>

                    @if ($product->detailProducts->count())
                        <form action="{{ route('cart.store') }}" method="POST" class="mt-8">
                            @csrf

                            <div class="border-t border-gray-200 pt-6">
                                <h2 class="text-xl font-bold text-gray-900">
                                    Phiên bản sản phẩm
                                </h2>

                                <div class="mt-5 space-y-3">
                                    @foreach ($product->detailProducts as $detail)
                                        @php
                                            $stock = $detail->inStock?->stock ?? 0;
                                            $price = $detail->sale_price > 0 ? $detail->sale_price : $detail->price;
                                        @endphp

                                        <label class="block cursor-pointer">
                                            <input type="radio" name="detail_product_id" value="{{ $detail->id }}"
                                                class="peer hidden" {{ $loop->first ? 'checked' : '' }}
                                                {{ $stock <= 0 ? 'disabled' : '' }}>

                                            <div
                                                class="rounded-xl border border-gray-200 p-5 peer-checked:border-gray-900 peer-checked:ring-1 peer-checked:ring-gray-900 {{ $stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                                <div class="grid grid-cols-2 gap-5 sm:grid-cols-4">
                                                    <div>
                                                        <p class="text-xs text-gray-500">Phiên bản</p>
                                                        <p class="mt-1 font-semibold text-gray-900">
                                                            {{ $detail->version ?? 'Mặc định' }}
                                                        </p>
                                                    </div>

                                                    <div>
                                                        <p class="text-xs text-gray-500">Màu sắc</p>
                                                        <p class="mt-1 font-semibold text-gray-900">
                                                            {{ $detail->color ?? 'Không có' }}
                                                        </p>
                                                    </div>

                                                    <div>
                                                        <p class="text-xs text-gray-500">Tồn kho</p>
                                                        <p
                                                            class="mt-1 font-semibold {{ $stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                            {{ $stock > 0 ? $stock : 'Hết hàng' }}
                                                        </p>
                                                    </div>

                                                    <div>
                                                        <p class="text-xs text-gray-500">Giá</p>

                                                        @if ($detail->sale_price > 0)
                                                            <p class="mt-1 text-lg font-bold text-red-600">
                                                                {{ number_format($detail->sale_price, 0, ',', '.') }} đ
                                                            </p>
                                                            <p class="text-xs text-gray-400 line-through">
                                                                {{ number_format($detail->price, 0, ',', '.') }} đ
                                                            </p>
                                                        @else
                                                            <p class="mt-1 text-lg font-bold text-gray-900">
                                                                {{ number_format($detail->price, 0, ',', '.') }} đ
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-6 flex items-center gap-3">
                                <label class="font-semibold text-gray-900">
                                    Số lượng:
                                </label>

                                <input type="number" name="quantity" value="1" min="1"
                                    class="w-20 rounded-lg border border-gray-300 px-3 py-2 text-center">
                            </div>

                            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                                <button type="submit"
                                    class="rounded-xl bg-gray-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-gray-700">
                                    <i class="fa-solid fa-cart-plus mr-2"></i>
                                    Thêm vào giỏ hàng
                                </button>

                                <button type="submit" name="buy_now" value="1"
                                    class="rounded-xl border border-gray-300 px-6 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-100">
                                    <i class="fa-solid fa-bolt mr-2"></i>
                                    Mua ngay
                                </button>
                            </div>
                        </form>
                    @endif

                </div>
            </div>

            @if ($product->detailProducts->contains(fn($detail) => $detail->specifications->count()))
                <div class="mt-8 rounded-2xl bg-white p-6 shadow-sm sm:p-8">

                    <h2 class="text-2xl font-bold text-gray-900">
                        Thông số kỹ thuật
                    </h2>

                    <div class="mt-6 overflow-x-auto">
                        <table class="w-full min-w-[500px] text-left text-sm">

                            <thead>
                                <tr class="border-b border-gray-200 bg-gray-50">
                                    <th class="px-5 py-4 font-semibold text-gray-900">
                                        Thông số
                                    </th>

                                    <th class="px-5 py-4 font-semibold text-gray-900">
                                        Giá trị
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">

                                @foreach ($product->detailProducts as $detail)
                                    @foreach ($detail->specifications as $specification)
                                        <tr class="transition hover:bg-gray-50">

                                            <td class="px-5 py-4 font-medium text-gray-700">
                                                {{ $specification->spec_name }}
                                            </td>

                                            <td class="px-5 py-4 text-gray-600">
                                                {{ $specification->spec_value }}
                                            </td>

                                        </tr>
                                    @endforeach
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
            @endif

            @if ($product->detailProducts->contains(fn($detail) => $detail->images->count()))
                <div class="mt-8 rounded-2xl bg-white p-6 shadow-sm sm:p-8">

                    <h2 class="text-2xl font-bold text-gray-900">
                        Hình ảnh sản phẩm
                    </h2>

                    <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">

                        @foreach ($product->detailProducts as $detail)
                            @foreach ($detail->images as $image)
                                <div class="group overflow-hidden rounded-xl border border-gray-200 bg-gray-100">
                                    <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->name }}"
                                        class="aspect-square w-full object-cover transition duration-300 group-hover:scale-105">
                                </div>
                            @endforeach
                        @endforeach

                    </div>

                </div>
            @endif

            {{-- Reviews --}}
            <div class="mt-8 rounded-2xl bg-white p-6 shadow-sm sm:p-8">

                <div
                    class="flex flex-col gap-5 border-b border-gray-200 pb-6 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">
                            Đánh giá sản phẩm
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $reviewCount }} đánh giá
                        </p>
                    </div>

                    @if ($reviewCount > 0)
                        <div class="sm:text-right">
                            <div class="flex items-center gap-3 sm:justify-end">
                                <span class="text-3xl font-bold text-gray-900">
                                    {{ number_format($averageRating, 1) }}
                                </span>

                                <span class="text-sm text-gray-500">
                                    / 5
                                </span>
                            </div>

                            <div class="mt-1 text-yellow-400">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i
                                        class="fa-solid fa-star {{ $i <= round($averageRating) ? '' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                        </div>
                    @endif
                </div>

                @if ($reviews->count())
                    <div class="mt-6 space-y-6">
                        @foreach ($reviews as $review)
                            <div class="border-b border-gray-200 pb-6 last:border-0 last:pb-0">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                    <div>
                                        <p class="font-semibold text-gray-900">
                                            {{ $review->detailOrder?->order?->customer_name ?? 'Khách hàng' }}
                                        </p>

                                        <div class="mt-1 flex items-center gap-1 text-yellow-400">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fa-solid fa-star text-sm {{ $i <= $review->rating ? '' : 'text-gray-300' }}"></i>
                                            @endfor

                                            <span class="ml-2 text-sm font-medium text-gray-600">
                                                {{ $review->rating }}/5
                                            </span>
                                        </div>
                                    </div>

                                    <span class="text-sm text-gray-400">
                                        {{ $review->created_at?->format('d/m/Y') }}
                                    </span>
                                </div>

                                @if ($review->content)
                                    <p class="mt-4 leading-7 text-gray-600">
                                        {{ $review->content }}
                                    </p>
                                @else
                                    <p class="mt-4 text-sm italic text-gray-400">
                                        Khách hàng không để lại nhận xét.
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="mt-6 rounded-xl bg-gray-50 px-5 py-10 text-center">
                        <i class="fa-regular fa-comment-dots text-4xl text-gray-300"></i>

                        <p class="mt-4 font-medium text-gray-600">
                            Sản phẩm chưa có đánh giá nào.
                        </p>

                        <p class="mt-1 text-sm text-gray-400">
                            Hãy là người đầu tiên đánh giá sản phẩm này.
                        </p>
                    </div>
                @endif

            </div>

            @if ($relatedProducts->count())
                <div class="mt-12">

                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                            Gợi ý cho bạn
                        </p>

                        <h2 class="mt-1 text-2xl font-bold text-gray-900">
                            Sản phẩm liên quan
                        </h2>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

                        @foreach ($relatedProducts as $related)
                            <div
                                class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md">

                                <div class="h-56 overflow-hidden bg-gray-100">

                                    @if ($related->thumbnail)
                                        <img src="{{ asset('storage/' . $related->thumbnail) }}"
                                            alt="{{ $related->name }}"
                                            class="h-full w-full object-cover transition duration-300 hover:scale-105">
                                    @endif

                                </div>

                                <div class="p-5">

                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                        {{ $related->category?->name ?? 'Robot Store' }}
                                    </p>

                                    <h3 class="mt-2 line-clamp-2 min-h-[3rem] font-semibold text-gray-900">
                                        {{ $related->name }}
                                    </h3>

                                    @php
                                        $relatedDetail = $related->detailProducts->first();
                                    @endphp

                                    @if ($relatedDetail)
                                        <p class="mt-3 text-lg font-bold text-gray-900">
                                            {{ number_format($relatedDetail->sale_price > 0 ? $relatedDetail->sale_price : $relatedDetail->price, 0, ',', '.') }}
                                            đ
                                        </p>
                                    @endif

                                    <a href="{{ route('product.detail', $related->slug) }}"
                                        class="mt-4 block rounded-lg bg-gray-900 px-4 py-2.5 text-center text-sm font-semibold text-white transition hover:bg-gray-700">
                                        Xem chi tiết
                                    </a>

                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            @endif

        </div>
    </section>
@endsection