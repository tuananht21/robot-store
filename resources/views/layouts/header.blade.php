<header class="sticky top-0 z-50 border-b border-gray-200 bg-white/95 backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between gap-6">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex shrink-0 items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-900 text-lg font-bold text-white">R</div>

                <div>
                    <h1 class="text-lg font-bold leading-none text-gray-900">Robot Store</h1>
                    <p class="mt-1 text-[10px] font-medium uppercase tracking-wider text-gray-500">Smart Technology</p>
                </div>
            </a>

            {{-- Desktop navigation --}}
            <nav class="hidden items-center gap-8 md:flex">
                <a href="{{ url('/') }}" class="text-sm font-medium text-gray-900 transition hover:text-blue-600">Trang chủ</a>
                <a href="{{ route('products') }}" class="text-sm font-medium text-gray-600 transition hover:text-blue-600">Sản phẩm</a>
                <a href="{{ route('about') }}" class="text-sm font-medium text-gray-600 transition hover:text-blue-600">Giới thiệu</a>
                <a href="{{ route('contact') }}" class="text-sm font-medium text-gray-600 transition hover:text-blue-600">Liên hệ</a>
            </nav>

            {{-- Desktop search --}}
            <form action="{{ route('search') }}" method="GET" class="hidden flex-1 md:block lg:max-w-sm">
                <div class="relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm sản phẩm..." class="w-full rounded-lg border border-gray-300 bg-gray-50 py-2 pl-4 pr-10 text-sm text-gray-900 outline-none transition focus:border-gray-900 focus:bg-white focus:ring-1 focus:ring-gray-900">

                    <button type="submit" class="absolute right-0 top-0 flex h-full w-10 items-center justify-center text-gray-500 transition hover:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m21 21-4.35-4.35m1.35-5.15a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0Z" />
                        </svg>
                    </button>
                </div>
            </form>

            {{-- Desktop actions --}}
            <div class="hidden shrink-0 items-center gap-3 md:flex">

                {{-- Cart --}}
                <a href="{{ route('cart') }}" class="relative flex h-10 w-10 items-center justify-center rounded-lg text-gray-600 transition hover:bg-gray-100 hover:text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1 5h13M9 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z" />
                    </svg>
                </a>

                @auth
                    {{-- User menu --}}
                    <div class="relative">
                        <button type="button" id="userMenuButton" class="flex items-center gap-2 rounded-lg px-1.5 py-1.5 transition hover:bg-gray-100">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-900 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                                </svg>
                            </div>

                            <svg id="userMenuIcon" class="h-4 w-4 text-gray-500 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6" />
                            </svg>
                        </button>

                        {{-- User dropdown --}}
                        <div id="userMenu" class="absolute right-0 z-50 mt-2 hidden w-64 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lg">
                            <div class="border-b border-gray-100 px-4 py-3">
                                <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                <p class="mt-1 break-all text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>

                            <div class="p-2">
                                {{-- Orders --}}
                                <a href="{{ route('orders.index') }}" class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5h6m-8 3h10M7 5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2m-8 5h6m-6 4h6m-6 4h4" />
                                    </svg>
                                    Chi tiết đơn hàng
                                </a>

                                {{-- Logout --}}
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center rounded-lg px-3 py-2.5 text-sm font-medium text-red-600 transition hover:bg-red-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0-4-4m4 4H7m6 4v1a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1" />
                                        </svg>
                                        Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:border-gray-900 hover:text-gray-900">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-700">Đăng ký</a>
                @endauth
            </div>

            {{-- Mobile menu --}}
            <details class="relative md:hidden">
                <summary class="flex h-10 w-10 cursor-pointer list-none items-center justify-center rounded-lg text-gray-700 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </summary>

                <div class="absolute right-0 top-12 w-72 rounded-xl border border-gray-200 bg-white p-4 shadow-xl">

                    {{-- Mobile search --}}
                    <form action="{{ route('search') }}" method="GET" class="mb-3">
                        <div class="relative">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm sản phẩm..." class="w-full rounded-lg border border-gray-300 bg-gray-50 py-2.5 pl-3 pr-10 text-sm outline-none focus:border-gray-900 focus:bg-white">

                            <button type="submit" class="absolute right-0 top-0 flex h-full w-10 items-center justify-center text-gray-500 hover:text-gray-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m21 21-4.35-4.35m1.35-5.15a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0Z" />
                                </svg>
                            </button>
                        </div>
                    </form>

                    {{-- Mobile navigation --}}
                    <nav class="flex flex-col">
                        <a href="{{ url('/') }}" class="rounded-lg px-3 py-3 text-sm font-medium text-gray-900 hover:bg-gray-100">Trang chủ</a>
                        <a href="{{ route('products') }}" class="rounded-lg px-3 py-3 text-sm font-medium text-gray-600 hover:bg-gray-100">Sản phẩm</a>
                        <a href="{{ route('about') }}" class="rounded-lg px-3 py-3 text-sm font-medium text-gray-600 hover:bg-gray-100">Giới thiệu</a>
                        <a href="{{ route('contact') }}" class="rounded-lg px-3 py-3 text-sm font-medium text-gray-600 hover:bg-gray-100">Liên hệ</a>
                    </nav>

                    <div class="mt-3 border-t border-gray-100 pt-3">

                        {{-- Mobile cart --}}
                        <a href="{{ route('cart') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium text-gray-700 hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1 5h13M9 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z" />
                            </svg>
                            Giỏ hàng
                        </a>

                        @auth
                            {{-- Mobile user information --}}
                            <div class="mt-2 rounded-lg bg-gray-50 px-3 py-3">
                                <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="mt-1 break-all text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>

                            {{-- Mobile orders --}}
                            <a href="{{ route('orders.index') }}" class="mt-2 flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium text-gray-700 hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5h6m-8 3h10M7 5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2m-8 5h6m-6 4h6m-6 4h4" />
                                </svg>
                                Chi tiết đơn hàng
                            </a>

                            {{-- Mobile logout --}}
                            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium text-red-600 hover:bg-red-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0-4-4m4 4H7m6 4v1a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1" />
                                    </svg>
                                    Đăng xuất
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="mt-2 block rounded-lg px-3 py-3 text-sm font-medium text-gray-700 hover:bg-gray-100">Đăng nhập</a>
                            <a href="{{ route('register') }}" class="mt-2 block rounded-lg bg-gray-900 px-3 py-3 text-center text-sm font-semibold text-white">Đăng ký</a>
                        @endauth
                    </div>
                </div>
            </details>
        </div>
    </div>
</header>

<script>
    const userMenuButton = document.getElementById('userMenuButton');
    const userMenu = document.getElementById('userMenu');
    const userMenuIcon = document.getElementById('userMenuIcon');

    if (userMenuButton && userMenu && userMenuIcon) {
        userMenuButton.addEventListener('click', function (event) {
            event.stopPropagation();
            userMenu.classList.toggle('hidden');
            userMenuIcon.classList.toggle('rotate-180');
        });

        document.addEventListener('click', function (event) {
            if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
                userMenuIcon.classList.remove('rotate-180');
            }
        });
    }
</script>