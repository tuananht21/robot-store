<aside id="adminSidebar" class="fixed left-0 top-0 z-50 h-screen w-64 -translate-x-full bg-gray-900 text-white transition-transform duration-300 lg:translate-x-0">
    <div class="flex h-16 items-center border-b border-gray-800 px-6">
        <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold">
            Robot Store
        </a>
    </div>

    <nav class="h-[calc(100vh-4rem)] overflow-y-auto px-3 py-4">
        <div class="space-y-1">

            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0 7-7 7 7M5 10v10h14V10M9 20v-6h6v6"/>
                </svg>
                <span>Trang chủ</span>
            </a>

            <div>
                <div class="flex items-center">
                    <a href="{{ route('admin.categories.index') }}"
                        class="flex flex-1 items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.categories.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7H4m16 0v10H4V7m16 0-2-3H6L4 7"/>
                        </svg>
                        <span>Danh mục</span>
                    </a>

                    <button type="button" data-menu="categoryMenu"
                        class="rounded-lg p-2.5 text-gray-400 transition hover:bg-gray-800 hover:text-white">
                        <svg class="menu-arrow h-4 w-4 transition-transform {{ request()->routeIs('admin.categories.*') ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>
                </div>

                <div id="categoryMenu" class="{{ request()->routeIs('admin.categories.*') ? '' : 'hidden' }} mt-1 space-y-1 pl-11">
                    <a href="{{ route('admin.categories.index') }}"
                        class="block rounded-lg px-3 py-2 text-sm transition {{ request()->routeIs('admin.categories.index') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Danh sách
                    </a>

                    <a href="{{ route('admin.categories.create') }}"
                        class="block rounded-lg px-3 py-2 text-sm transition {{ request()->routeIs('admin.categories.create') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Thêm danh mục
                    </a>
                </div>
            </div>

            <div>
                <div class="flex items-center">
                    <a href="{{ route('admin.products.index') }}"
                        class="flex flex-1 items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.products.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7H4m0 0v10h16V7M4 7l2-3h12l2 3"/>
                        </svg>
                        <span>Sản phẩm</span>
                    </a>

                    <button type="button" data-menu="productMenu"
                        class="rounded-lg p-2.5 text-gray-400 transition hover:bg-gray-800 hover:text-white">
                        <svg class="menu-arrow h-4 w-4 transition-transform {{ request()->routeIs('admin.products.*') ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>
                </div>

                <div id="productMenu" class="{{ request()->routeIs('admin.products.*') ? '' : 'hidden' }} mt-1 space-y-1 pl-11">
                    <a href="{{ route('admin.products.index') }}"
                        class="block rounded-lg px-3 py-2 text-sm transition {{ request()->routeIs('admin.products.index') || request()->routeIs('admin.products.show') || request()->routeIs('admin.products.edit') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Danh sách
                    </a>

                    <a href="{{ route('admin.products.create') }}"
                        class="block rounded-lg px-3 py-2 text-sm transition {{ request()->routeIs('admin.products.create') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Thêm sản phẩm
                    </a>
                </div>
            </div>

            <a href="{{ route('admin.orders.index') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.orders.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h18v14H3V5zm0 4h18M7 13h4"/>
                </svg>
                <span>Đơn hàng</span>
            </a>

        </div>
    </nav>
</aside>

<div id="sidebarOverlay" class="fixed inset-0 z-40 hidden bg-black/50 lg:hidden"></div>

<script>
    document.querySelectorAll('[data-menu]').forEach(button => {
        button.addEventListener('click', function () {
            const menu = document.getElementById(this.dataset.menu);
            const arrow = this.querySelector('.menu-arrow');

            menu.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        });
    });
</script>