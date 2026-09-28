@extends('layouts/app')

@push('style')

@endpush

@section('content')

<div class="container mx-auto">

    <section class="text-center pt-10 mt-10 flex justify-center items-center gap-1">
        <i class="fa-solid fa-magnifying-glass text-4xl text-gray-900"></i>
        <h1 class="text-4xl text-gray-900 font-bold">
            {{ $q }}
        </h1>
    </section>

    <section class="pt-10 mt-10 px-4">

        @if ($products->isNotEmpty())

            <div class="grid grid-cols-12 gap-4">

                @foreach ($products as $product)

                    <div class="col-span-12 sm:col-span-6 md:col-span-4 lg:col-span-3">

                        <a
                            class="block w-full text-center"
                            href="{{ route('detail', $product->slug) }}"
                        >

                            <div class="rounded-2xl bg-white hover:shadow-lg flex justify-center items-center py-10 transition-all duration-300 cursor-pointer">

                                <div class="w-9/12 min-h-[400px]">

                                    @if ($product->thumbnail)
                                        <img
                                            class="w-full h-64 object-contain"
                                            src="{{ Storage::url($product->thumbnail) }}"
                                            alt="{{ $product->name }}"
                                        >
                                    @else
                                        <div class="w-full h-64 flex items-center justify-center bg-gray-100 rounded-lg">
                                            <span class="text-gray-400">Không có hình ảnh</span>
                                        </div>
                                    @endif

                                    <h2 class="text-xl font-bold text-gray-900 mt-5 truncate">
                                        {{ $product->name }}
                                    </h2>

                                    @if ($product->detailProducts->isNotEmpty())

                                        <div class="text-gray-900 mt-5 text-lg block font-bold">

                                            {{ number_format($product->detailProducts->first()->sale_price) }}đ

                                            @if ($product->detailProducts->first()->price != $product->detailProducts->first()->sale_price)
                                                <span class="line-through text-gray-400 ml-2">
                                                    {{ number_format($product->detailProducts->first()->price) }}đ
                                                </span>
                                            @endif

                                        </div>

                                        <p class="mt-5 text-yellow-500 text-lg">
                                            Online giá rẻ quá
                                        </p>

                                    @else

                                        <p class="mt-5 text-yellow-500 text-lg">
                                            Sản phẩm đang cập nhật!
                                        </p>

                                    @endif

                                </div>

                            </div>

                        </a>

                    </div>

                @endforeach

            </div>

        @else

            <div class="text-center py-10">
                <h1 class="text-2xl font-bold text-gray-700">
                    Không có sản phẩm nào
                </h1>

                <p class="mt-2 text-gray-500">
                    Không tìm thấy sản phẩm phù hợp với từ khóa "{{ $q }}".
                </p>
            </div>

        @endif

    </section>

    @if ($products->hasPages())

        <div class="flex justify-center mt-6">
            {{ $products->links() }}
        </div>

    @endif

</div>

@endsection

@push('script')

@endpush