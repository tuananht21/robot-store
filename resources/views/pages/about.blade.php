@extends('layouts.app')

@section('title', 'Giới thiệu - Robot Store')

@section('content')

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gray-950">
        <div class="absolute inset-0">
            <div class="absolute -left-40 -top-40 h-96 w-96 rounded-full bg-blue-600/20 blur-3xl"></div>
            <div class="absolute -bottom-40 -right-40 h-96 w-96 rounded-full bg-cyan-500/10 blur-3xl"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 lg:py-28">
            <div class="max-w-3xl">
                <span
                    class="inline-flex items-center gap-2 rounded-full border border-blue-400/20 bg-blue-500/10 px-4 py-2 text-sm font-medium text-blue-300">
                    <span class="h-2 w-2 rounded-full bg-blue-400"></span>
                    Về Robot Store
                </span>

                <h1 class="mt-6 text-4xl font-bold leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Công nghệ robot
                    <span class="text-blue-400">cho cuộc sống hiện đại</span>
                </h1>

                <p class="mt-6 max-w-2xl text-base leading-7 text-gray-400 sm:text-lg">
                    Robot Store là nơi cung cấp các sản phẩm robot thông minh,
                    giúp khách hàng tiếp cận công nghệ hiện đại và nâng cao
                    chất lượng cuộc sống.
                </p>
            </div>
        </div>
    </section>


    {{-- About --}}
    <section class="bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-12 lg:grid-cols-2">

                <div>
                    <span class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                        Chúng tôi là ai?
                    </span>

                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Robot Store
                    </h2>

                    <div class="mt-6 space-y-4 text-gray-600 leading-7">
                        <p>
                            Robot Store là một cửa hàng trực tuyến chuyên cung cấp
                            các sản phẩm robot phục vụ cho gia đình và cuộc sống
                            hiện đại.
                        </p>

                        <p>
                            Chúng tôi hướng đến việc mang những công nghệ robot
                            tiện ích đến gần hơn với người dùng, từ robot hút bụi,
                            robot lau nhà đến các thiết bị robot thông minh khác.
                        </p>

                        <p>
                            Với giao diện mua sắm đơn giản và thông tin sản phẩm
                            rõ ràng, Robot Store giúp khách hàng dễ dàng tìm kiếm,
                            lựa chọn và tìm hiểu sản phẩm phù hợp với nhu cầu.
                        </p>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-3xl bg-gray-100">
                    <img
                        src="{{ asset('images/banner-robot.png') }}"
                        alt="Robot Store"
                        class="h-[360px] w-full object-cover sm:h-[420px]"
                    >

                    <div class="absolute inset-0 bg-gradient-to-t from-gray-950/50 to-transparent"></div>

                    <div class="absolute bottom-6 left-6">
                        <p class="text-lg font-semibold text-white">
                            Smart Technology
                        </p>
                        <p class="mt-1 text-sm text-gray-200">
                            Công nghệ cho cuộc sống tốt hơn
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>


    {{-- Mission & Vision --}}
    <section class="bg-gray-50 py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mx-auto max-w-2xl text-center">
                <span class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                    Định hướng
                </span>

                <h2 class="mt-2 text-3xl font-bold text-gray-900 sm:text-4xl">
                    Sứ mệnh & Tầm nhìn
                </h2>

                <p class="mt-4 text-gray-500">
                    Những giá trị Robot Store hướng đến trong quá trình phát triển.
                </p>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-2">

                {{-- Mission --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-8 transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-blue-50 text-2xl">
                        🎯
                    </div>

                    <h3 class="mt-6 text-xl font-bold text-gray-900">
                        Sứ mệnh
                    </h3>

                    <p class="mt-4 leading-7 text-gray-500">
                        Mang đến những sản phẩm robot hữu ích, giúp người dùng
                        tiết kiệm thời gian, giảm bớt công việc hằng ngày và
                        tận hưởng cuộc sống tiện nghi hơn.
                    </p>
                </div>

                {{-- Vision --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-8 transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-blue-50 text-2xl">
                        🚀
                    </div>

                    <h3 class="mt-6 text-xl font-bold text-gray-900">
                        Tầm nhìn
                    </h3>

                    <p class="mt-4 leading-7 text-gray-500">
                        Trở thành một nền tảng thương mại điện tử chuyên về robot,
                        nơi khách hàng có thể dễ dàng tìm hiểu và lựa chọn các
                        sản phẩm công nghệ phù hợp.
                    </p>
                </div>

            </div>
        </div>
    </section>


    {{-- Why choose us --}}
    <section class="bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="text-center">
                <span class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                    Robot Store
                </span>

                <h2 class="mt-2 text-3xl font-bold text-gray-900 sm:text-4xl">
                    Vì sao chọn Robot Store?
                </h2>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

                <div class="rounded-2xl border border-gray-200 p-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-xl">
                        ✓
                    </div>

                    <h3 class="mt-5 font-semibold text-gray-900">
                        Sản phẩm chất lượng
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Thông tin sản phẩm rõ ràng, giúp khách hàng dễ dàng
                        tìm hiểu trước khi lựa chọn.
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-200 p-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-xl">
                        🔍
                    </div>

                    <h3 class="mt-5 font-semibold text-gray-900">
                        Dễ dàng tìm kiếm
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Hệ thống sản phẩm được phân loại giúp việc tìm kiếm
                        robot phù hợp trở nên đơn giản hơn.
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-200 p-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-xl">
                        💬
                    </div>

                    <h3 class="mt-5 font-semibold text-gray-900">
                        Hỗ trợ khách hàng
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Luôn hướng đến trải nghiệm mua sắm thuận tiện và
                        hỗ trợ khách hàng khi cần thiết.
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-200 p-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-xl">
                        ⚡
                    </div>

                    <h3 class="mt-5 font-semibold text-gray-900">
                        Công nghệ hiện đại
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Tập trung vào các sản phẩm robot và giải pháp công nghệ
                        phục vụ cuộc sống hiện đại.
                    </p>
                </div>

            </div>
        </div>
    </section>


    {{-- Robot categories --}}
    <section class="bg-gray-50 py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <span class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                        Sản phẩm
                    </span>

                    <h2 class="mt-2 text-3xl font-bold text-gray-900">
                        Khám phá thế giới robot
                    </h2>

                    <p class="mt-3 max-w-2xl text-gray-500">
                        Tìm hiểu những dòng sản phẩm robot đang được cung cấp
                        tại Robot Store.
                    </p>
                </div>

                <a
                    href="{{ route('products') }}"
                    class="text-sm font-semibold text-gray-900 transition hover:text-blue-600"
                >
                    Xem sản phẩm →
                </a>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-3">

                <div class="rounded-2xl border border-gray-200 bg-white p-6">
                    <div class="text-4xl">🧹</div>

                    <h3 class="mt-5 text-lg font-bold text-gray-900">
                        Robot hút bụi
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Hỗ trợ tự động làm sạch sàn nhà, tiết kiệm thời gian
                        và công sức cho gia đình.
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6">
                    <div class="text-4xl">🤖</div>

                    <h3 class="mt-5 text-lg font-bold text-gray-900">
                        Robot thông minh
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Những thiết bị robot ứng dụng công nghệ hiện đại
                        trong cuộc sống hàng ngày.
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6">
                    <div class="text-4xl">🏠</div>

                    <h3 class="mt-5 text-lg font-bold text-gray-900">
                        Robot gia đình
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Các sản phẩm hỗ trợ tự động hóa và nâng cao sự
                        tiện nghi cho không gian sống.
                    </p>
                </div>

            </div>
        </div>
    </section>


    {{-- Commitment --}}
    <section class="bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            <div class="overflow-hidden rounded-3xl bg-gray-950 px-6 py-12 text-center sm:px-12 sm:py-16">

                <span class="text-sm font-semibold uppercase tracking-wider text-blue-400">
                    Cam kết
                </span>

                <h2 class="mt-3 text-3xl font-bold text-white sm:text-4xl">
                    Mang công nghệ đến gần bạn hơn
                </h2>

                <p class="mx-auto mt-5 max-w-2xl leading-7 text-gray-400">
                    Robot Store luôn hướng đến một trải nghiệm mua sắm đơn giản,
                    minh bạch và thuận tiện, giúp bạn dễ dàng tìm được sản phẩm
                    robot phù hợp với nhu cầu sử dụng.
                </p>

                <a
                    href="{{ route('products') }}"
                    class="mt-8 inline-flex rounded-lg bg-white px-6 py-3 text-sm font-semibold text-gray-900 transition hover:bg-gray-200"
                >
                    Khám phá sản phẩm
                    <span class="ml-2">→</span>
                </a>

            </div>

        </div>
    </section>

@endsection