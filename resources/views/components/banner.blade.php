<section class="relative overflow-hidden bg-gray-950">
    <div class="absolute inset-0">
        <img
            src="{{ asset('images/banner-robot.png') }}"
            alt="Robot Store"
            class="h-full w-full object-cover object-[65%] sm:object-[65%]"
        >

        <div class="absolute inset-0 bg-gradient-to-b from-gray-950/80 via-gray-950/70 to-gray-950"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8 lg:py-28">
        <div class="flex min-h-[520px] items-center sm:min-h-[560px]">

            <div class="max-w-2xl">
                <span class="inline-flex rounded-full border border-blue-400/30 bg-blue-500/10 px-4 py-2 text-xs font-medium text-blue-300 sm:text-sm">
                    Công nghệ robot thông minh
                </span>

                <h1 class="mt-5 text-3xl font-bold leading-tight text-white sm:text-5xl lg:text-6xl">
                    Công nghệ robot
                    <span class="block text-blue-400">
                        cho cuộc sống hiện đại
                    </span>
                </h1>

                <p class="mt-5 max-w-xl text-sm leading-6 text-gray-300 sm:text-base sm:leading-7 lg:text-lg">
                    Khám phá những sản phẩm robot thông minh giúp ngôi nhà
                    trở nên tiện nghi, hiện đại và tự động hơn.
                </p>

                <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                    <a
                        href="{{ route('products') }}"
                        class="inline-flex items-center justify-center rounded-lg bg-white px-5 py-3 text-sm font-semibold text-gray-900 transition hover:bg-gray-200"
                    >
                        Khám phá sản phẩm
                        <span class="ml-2">→</span>
                    </a>

                    <a
                        href="#featured-products"
                        class="inline-flex items-center justify-center rounded-lg border border-white/30 bg-white/5 px-5 py-3 text-sm font-semibold text-white backdrop-blur-sm transition hover:bg-white/10"
                    >
                        Sản phẩm nổi bật
                    </a>
                </div>

                <div class="mt-8 grid max-w-md grid-cols-3 border-t border-white/10 pt-6">
                    <div>
                        <p class="text-base font-bold text-white sm:text-xl">100%</p>
                        <p class="mt-1 text-[11px] text-gray-400 sm:text-sm">
                            Chính hãng
                        </p>
                    </div>

                    <div class="border-l border-white/10 pl-3 sm:pl-5">
                        <p class="text-base font-bold text-white sm:text-xl">24/7</p>
                        <p class="mt-1 text-[11px] text-gray-400 sm:text-sm">
                            Hỗ trợ
                        </p>
                    </div>

                    <div class="border-l border-white/10 pl-3 sm:pl-5">
                        <p class="text-base font-bold text-white sm:text-xl">Fast</p>
                        <p class="mt-1 text-[11px] text-gray-400 sm:text-sm">
                            Giao hàng
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>