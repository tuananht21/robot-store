<header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-gray-200 bg-white px-4 sm:px-6">

    <div class="flex items-center gap-3">

        <button type="button" id="sidebarToggle"
            class="rounded-lg p-2 text-gray-600 transition hover:bg-gray-100 lg:hidden">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <h2 class="text-base font-semibold text-gray-800 sm:text-lg">
            @yield('header', 'Dashboard')
        </h2>

    </div>

    <div class="relative">

        <button type="button" id="adminMenuButton"
            class="flex items-center gap-2 rounded-lg px-1.5 py-1.5 transition hover:bg-gray-100 sm:gap-3 sm:px-2">

            <div class="hidden text-right sm:block">
                <p class="text-sm font-medium text-gray-800">
                    {{ auth()->user()->name }}
                </p>

                <p class="text-xs text-gray-500">
                    Administrator
                </p>
            </div>

            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-600 text-sm font-semibold text-white sm:h-10 sm:w-10">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <svg class="h-4 w-4 text-gray-500 transition-transform" id="adminMenuIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
            </svg>

        </button>

        <div id="adminMenu"
            class="absolute right-0 z-50 mt-2 hidden w-56 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lg">

            <div class="border-b border-gray-100 px-4 py-3">

                <p class="text-sm font-semibold text-gray-800">
                    {{ auth()->user()->name }}
                </p>

                <p class="mt-1 break-all text-xs text-gray-500">
                    {{ auth()->user()->email }}
                </p>

            </div>

            <div class="p-2">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                        class="flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50">

                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0-4-4m4 4H7m6 4v1a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1"/>
                        </svg>

                        Đăng xuất

                    </button>

                </form>

            </div>

        </div>

    </div>

</header>

<script>
    const adminMenuButton = document.getElementById('adminMenuButton');
    const adminMenu = document.getElementById('adminMenu');
    const adminMenuIcon = document.getElementById('adminMenuIcon');

    adminMenuButton.addEventListener('click', function (event) {
        event.stopPropagation();
        adminMenu.classList.toggle('hidden');
        adminMenuIcon.classList.toggle('rotate-180');
    });

    document.addEventListener('click', function (event) {
        if (!adminMenuButton.contains(event.target) && !adminMenu.contains(event.target)) {
            adminMenu.classList.add('hidden');
            adminMenuIcon.classList.remove('rotate-180');
        }
    });

    const sidebarToggle = document.getElementById('sidebarToggle');
    const adminSidebar = document.getElementById('adminSidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function openSidebar() {
        adminSidebar.classList.remove('-translate-x-full');
        sidebarOverlay.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeSidebar() {
        adminSidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    sidebarToggle.addEventListener('click', function () {
        if (adminSidebar.classList.contains('-translate-x-full')) {
            openSidebar();
        } else {
            closeSidebar();
        }
    });

    sidebarOverlay.addEventListener('click', closeSidebar);

    window.addEventListener('resize', function () {
        if (window.innerWidth >= 1024) {
            sidebarOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    });
</script>