<footer class="border-t border-gray-200 bg-gray-950 text-gray-300">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-lg font-bold text-gray-900">
                        R
                    </div>

                    <span class="text-lg font-bold text-white">Robot Store</span>
                </a>

                <p class="mt-4 max-w-sm text-sm leading-6 text-gray-400">
                    Cửa hàng chuyên cung cấp các sản phẩm robot thông minh phục vụ cuộc sống hiện đại.
                </p>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-white">Sản phẩm</h3>

                <div class="mt-4 space-y-3 text-sm">
                    <a href="#" class="block transition hover:text-white">Robot hút bụi</a>
                    <a href="#" class="block transition hover:text-white">Robot lau nhà</a>
                    <a href="#" class="block transition hover:text-white">Robot thông minh</a>
                    <a href="#" class="block transition hover:text-white">Phụ kiện robot</a>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-white">Hỗ trợ</h3>

                <div class="mt-4 space-y-3 text-sm">
                    <a href="#" class="block transition hover:text-white">Chính sách mua hàng</a>
                    <a href="#" class="block transition hover:text-white">Chính sách bảo hành</a>
                    <a href="#" class="block transition hover:text-white">Chính sách đổi trả</a>
                    <a href="#" class="block transition hover:text-white">Liên hệ hỗ trợ</a>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-white">Liên hệ</h3>

                <div class="mt-4 space-y-3 text-sm text-gray-400">
                    <p>Việt Nam</p>
                    <p>support@robotstore.com</p>
                    <p>0123 456 789</p>
                </div>
            </div>
        </div>

        <div class="mt-10 border-t border-gray-800 pt-6 text-center text-sm text-gray-500">
            © {{ date('Y') }} Robot Store. All rights reserved.
        </div>
    </div>
</footer>