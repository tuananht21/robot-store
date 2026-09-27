@extends('layouts.app')

@section('title', 'Liên hệ - Robot Store')

@section('content')

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gray-950">
        <div class="absolute inset-0">
            <div class="absolute -left-40 -top-40 h-96 w-96 rounded-full bg-blue-600/20 blur-3xl"></div>
            <div class="absolute -bottom-40 -right-40 h-96 w-96 rounded-full bg-cyan-500/10 blur-3xl"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 lg:py-24">
            <div class="max-w-3xl">

                <span
                    class="inline-flex items-center gap-2 rounded-full border border-blue-400/20 bg-blue-500/10 px-4 py-2 text-sm font-medium text-blue-300">
                    <span class="h-2 w-2 rounded-full bg-blue-400"></span>
                    Liên hệ Robot Store
                </span>

                <h1 class="mt-6 text-4xl font-bold leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Chúng tôi luôn sẵn sàng
                    <span class="text-blue-400"> hỗ trợ bạn</span>
                </h1>

                <p class="mt-6 max-w-2xl text-base leading-7 text-gray-400 sm:text-lg">
                    Nếu bạn có câu hỏi về sản phẩm, đơn hàng hoặc cần tư vấn
                    về robot, hãy liên hệ với Robot Store. Chúng tôi rất vui
                    được hỗ trợ bạn.
                </p>

            </div>
        </div>
    </section>


    {{-- Contact information --}}
    <section class="bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

                {{-- Address --}}
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6 transition hover:-translate-y-1 hover:shadow-lg">

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-xl">
                        📍
                    </div>

                    <h3 class="mt-5 font-semibold text-gray-900">
                        Địa chỉ
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Đà Nẵng, Việt Nam
                    </p>

                </div>


                {{-- Phone --}}
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6 transition hover:-translate-y-1 hover:shadow-lg">

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-xl">
                        📞
                    </div>

                    <h3 class="mt-5 font-semibold text-gray-900">
                        Điện thoại
                    </h3>

                    <a href="tel:0123456789" class="mt-2 block text-sm text-gray-500 transition hover:text-blue-600">
                        0123 456 789
                    </a>

                </div>


                {{-- Email --}}
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6 transition hover:-translate-y-1 hover:shadow-lg">

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-xl">
                        ✉️
                    </div>

                    <h3 class="mt-5 font-semibold text-gray-900">
                        Email
                    </h3>

                    <a href="mailto:contact@robotstore.com"
                        class="mt-2 block break-all text-sm text-gray-500 transition hover:text-blue-600">
                        contact@robotstore.com
                    </a>

                </div>


                {{-- Working hours --}}
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6 transition hover:-translate-y-1 hover:shadow-lg">

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-xl">
                        🕐
                    </div>

                    <h3 class="mt-5 font-semibold text-gray-900">
                        Thời gian làm việc
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Thứ 2 - Chủ nhật
                        <br>
                        08:00 - 22:00
                    </p>

                </div>

            </div>

        </div>
    </section>


    {{-- Contact form --}}
    <section class="bg-gray-50 py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="grid gap-12 lg:grid-cols-2">

                {{-- Left --}}
                <div>
                    <span class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                        Gửi tin nhắn
                    </span>

                    <h2 class="mt-2 text-3xl font-bold text-gray-900 sm:text-4xl">
                        Bạn cần hỗ trợ?
                    </h2>

                    <p class="mt-4 max-w-lg leading-7 text-gray-500">
                        Điền thông tin vào biểu mẫu bên cạnh và gửi câu hỏi
                        cho chúng tôi. Robot Store sẽ tiếp nhận thông tin
                        và hỗ trợ bạn trong thời gian sớm nhất.
                    </p>

                    <div class="mt-8 space-y-5">

                        <div class="flex items-start gap-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white shadow-sm">
                                ✓
                            </div>

                            <div>
                                <h3 class="font-semibold text-gray-900">
                                    Tư vấn sản phẩm
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    Hỗ trợ lựa chọn sản phẩm phù hợp với nhu cầu.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white shadow-sm">
                                ✓
                            </div>

                            <div>
                                <h3 class="font-semibold text-gray-900">
                                    Hỗ trợ đơn hàng
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    Giải đáp các vấn đề liên quan đến đơn hàng.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white shadow-sm">
                                ✓
                            </div>

                            <div>
                                <h3 class="font-semibold text-gray-900">
                                    Hỗ trợ sau bán hàng
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    Đồng hành cùng khách hàng trong quá trình sử dụng.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>


                {{-- Form --}}
                <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">

                    <form action="#" method="POST" class="space-y-5">

                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Họ và tên
                            </label>

                            <input type="text" id="name" name="name" placeholder="Nhập họ và tên"
                                class="mt-2 block w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                        </div>


                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                Email
                            </label>

                            <input type="email" id="email" name="email" placeholder="example@email.com"
                                class="mt-2 block w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                        </div>


                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">
                                Số điện thoại
                            </label>

                            <input type="text" id="phone" name="phone" placeholder="0123 456 789"
                                class="mt-2 block w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                        </div>


                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700">
                                Chủ đề
                            </label>

                            <select id="subject" name="subject"
                                class="mt-2 block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                                <option value="">Chọn chủ đề</option>
                                <option value="product">
                                    Tư vấn sản phẩm
                                </option>
                                <option value="order">
                                    Hỗ trợ đơn hàng
                                </option>
                                <option value="technical">
                                    Hỗ trợ kỹ thuật
                                </option>
                                <option value="other">
                                    Khác
                                </option>
                            </select>
                        </div>


                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">
                                Nội dung
                            </label>

                            <textarea id="message" name="message" rows="5" placeholder="Nhập nội dung bạn muốn liên hệ..."
                                class="mt-2 block w-full resize-none rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"></textarea>
                        </div>


                        <button type="submit"
                            class="w-full rounded-lg bg-gray-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-gray-800">
                            Gửi tin nhắn
                        </button>

                    </form>

                </div>

            </div>
        </div>
    </section>


    {{-- Map --}}
    <section class="bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <span class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                    Vị trí
                </span>

                <h2 class="mt-2 text-3xl font-bold text-gray-900">
                    Tìm chúng tôi
                </h2>

                <p class="mt-3 text-gray-500">
                    143 Nguyễn Lương Bằng, Đà Nẵng
                </p>
            </div>

            <div class="overflow-hidden rounded-3xl border border-gray-200 shadow-sm">
                <iframe
                    src="https://www.google.com/maps?q=143%20Nguyen%20Luong%20Bang%2C%20Da%20Nang%2C%20Vietnam&output=embed"
                    class="h-80 w-full sm:h-96 lg:h-[450px]" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

        </div>
    </section>


    {{-- CTA --}}
    <section class="bg-gray-50 py-16 sm:py-20">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-3xl bg-gray-950 px-6 py-12 text-center sm:px-12 sm:py-16">

                <h2 class="text-3xl font-bold text-white sm:text-4xl">
                    Bạn đang tìm một sản phẩm robot?
                </h2>

                <p class="mx-auto mt-4 max-w-2xl leading-7 text-gray-400">
                    Khám phá các sản phẩm robot đang có tại Robot Store
                    và tìm sản phẩm phù hợp với nhu cầu của bạn.
                </p>

                <a href="{{ route('products') }}"
                    class="mt-8 inline-flex rounded-lg bg-white px-6 py-3 text-sm font-semibold text-gray-900 transition hover:bg-gray-200">
                    Xem sản phẩm
                    <span class="ml-2">→</span>
                </a>

            </div>

        </div>
    </section>

@endsection
