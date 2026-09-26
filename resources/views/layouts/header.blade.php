<header class="sticky top-0 z-50 border-b border-gray-200 bg-white/95 backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-900 text-lg font-bold text-white">
                    R
                </div>
                <div>
                    <h1 class="text-lg font-bold leading-none text-gray-900">Robot Store</h1>
                    <p class="mt-1 text-[10px] font-medium uppercase tracking-wider text-gray-500">Smart Technology</p>
                </div>
            </a>

            {{-- Desktop navigation --}}
            <nav class="hidden items-center gap-8 md:flex">
                <a href="{{ url('/') }}" class="text-sm font-medium text-gray-900 transition hover:text-blue-600">Trang chủ</a>
                <a href="#" class="text-sm font-medium text-gray-600 transition hover:text-blue-600">Sản phẩm</a>
                <a href="{{ route('about') }}" class="text-sm font-medium text-gray-600 transition hover:text-blue-600">Giới thiệu</a>
                <a href="{{ route('contact') }}" class="text-sm font-medium text-gray-600 transition hover:text-blue-600">Liên hệ</a>
            </nav>

            {{-- Desktop actions --}}
            <div class="hidden items-center gap-3 md:flex">
                <a href="#" class="relative flex h-10 w-10 items-center justify-center rounded-lg text-gray-600 transition hover:bg-gray-100 hover:text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1 5h13M9 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z" />
                    </svg>
                </a>

                @auth
                    <span class="text-sm font-medium text-gray-700">
                        Xin chào, <span class="font-semibold text-gray-900">{{ auth()->user()->name }}</span>
                    </span>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-700">
                            Đăng xuất
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:border-gray-900 hover:text-gray-900">
                        Đăng nhập
                    </a>

                    <a href="{{ route('register') }}" class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-700">
                        Đăng ký
                    </a>
                @endauth
            </div>

            {{-- Mobile menu --}}
            <details class="relative md:hidden">
                <summary class="flex h-10 w-10 cursor-pointer list-none items-center justify-center rounded-lg text-gray-700 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </summary>

                <div class="absolute right-0 top-12 w-64 rounded-xl border border-gray-200 bg-white p-4 shadow-xl">
                    <nav class="flex flex-col">
                        <a href="{{ url('/') }}" class="rounded-lg px-3 py-3 text-sm font-medium text-gray-900 hover:bg-gray-100">Trang chủ</a>
                        <a href="#" class="rounded-lg px-3 py-3 text-sm font-medium text-gray-600 hover:bg-gray-100">Sản phẩm</a>
                        <a href="{{ route('about') }}" class="rounded-lg px-3 py-3 text-sm font-medium text-gray-600 hover:bg-gray-100">Giới thiệu</a>
                        <a href="{{ route('contact') }}" class="rounded-lg px-3 py-3 text-sm font-medium text-gray-600 hover:bg-gray-100">Liên hệ</a>
                    </nav>

                    <div class="mt-3 border-t border-gray-100 pt-3">
                        <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium text-gray-700 hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1 5h13M9 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z" />
                            </svg>
                            Giỏ hàng
                        </a>

                        @auth
                            <div class="mt-2 rounded-lg bg-gray-50 px-3 py-3 text-sm text-gray-700">
                                Xin chào, <span class="font-semibold text-gray-900">{{ auth()->user()->name }}</span>
                            </div>

                            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="w-full rounded-lg bg-gray-900 px-3 py-3 text-sm font-semibold text-white">
                                    Đăng xuất
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="mt-2 block rounded-lg px-3 py-3 text-sm font-medium text-gray-700 hover:bg-gray-100">
                                Đăng nhập
                            </a>

                            <a href="{{ route('register') }}" class="mt-2 block rounded-lg bg-gray-900 px-3 py-3 text-center text-sm font-semibold text-white">
                                Đăng ký
                            </a>
                        @endauth
                    </div>
                </div>
            </details>
        </div>
    </div>
</header>