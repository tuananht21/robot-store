@extends('layouts.app')

@section('title', 'Trang chủ - Robot Store')

@section('content')

    @include('components.banner')

    <section class="bg-gray-50 py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <span class="text-sm font-semibold uppercase tracking-wider text-blue-600">Sản phẩm</span>
                    <h2 class="mt-2 text-3xl font-bold text-gray-900">Sản phẩm nổi bật</h2>
                </div>
                <a href="{{ route('products') }}"
                    class="text-sm font-semibold text-gray-900 transition hover:text-blue-600">
                    Xem tất cả →
                </a>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($products as $product)
                    <div class="flex flex-col justify-between overflow-hidden rounded-2xl border border-gray-200 bg-white transition hover:-translate-y-1 hover:shadow-lg">
                        <div>
                            <div class="flex h-56 items-center justify-center overflow-hidden bg-gray-100">
                                @if ($product->thumbnail)
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                                        class="h-full w-full object-cover transition duration-300 hover:scale-105">
                                @else
                                    <span class="text-6xl">🤖</span>
                                @endif
                            </div>
                            <div class="p-5">
                                <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                                    {{ $product->category?->name ?? 'Robot Store' }}
                                </p>
                                <h3 class="mt-2 line-clamp-1 font-semibold text-gray-900">
                                    {{ $product->name }}
                                </h3>
                                <p class="mt-2 line-clamp-2 text-sm text-gray-500">
                                    {{ $product->description ?? 'Sản phẩm robot hiện đại và tiện lợi.' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-5 pt-0">
                            @php
                                $firstDetail = $product->detailProducts->first();
                            @endphp
                            <span class="text-sm font-bold text-gray-900">
                                @if ($firstDetail && $firstDetail->price)
                                    {{ number_format($firstDetail->price, 0, ',', '.') }} đ
                                @else
                                    Liên hệ
                                @endif
                            </span>
                            <a href="{{ route('product.detail', $product->slug) }}"
                                class="inline-block rounded-lg bg-gray-900 px-4 py-2 text-xs font-semibold text-white transition hover:bg-gray-700">
                                Xem sản phẩm
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-10 text-center text-gray-500">
                        Chưa có sản phẩm nổi bật nào.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    @include('components.video')

    <section class="bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-gray-950 px-6 py-12 text-center sm:px-12">
                <h2 class="text-3xl font-bold text-white">Sẵn sàng trải nghiệm công nghệ thông minh?</h2>
                <p class="mx-auto mt-4 max-w-2xl text-gray-400">
                    Đăng ký tài khoản để theo dõi đơn hàng và trải nghiệm đầy đủ các tính năng của Robot Store.
                </p>
                <a href="{{ url('/register') }}"
                    class="mt-8 inline-flex rounded-lg bg-white px-6 py-3 text-sm font-semibold text-gray-900 transition hover:bg-gray-200">
                    Tạo tài khoản
                </a>
            </div>
        </div>
    </section>

@endsection