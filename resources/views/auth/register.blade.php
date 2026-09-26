@extends('layouts.app')

@section('title', 'Đăng ký - Robot Store')

@section('content')
    <div class="min-h-[calc(100vh-8rem)] bg-gray-50 flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Tạo tài khoản</h1>
                    <p class="mt-2 text-sm text-gray-500">Đăng ký tài khoản để bắt đầu mua sắm</p>
                </div>

                <form id="registerForm" method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Họ và tên</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 @error('name') border-red-500 @enderror" placeholder="Nhập họ và tên">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 @error('email') border-red-500 @enderror" placeholder="Nhập email của bạn">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 @error('password') border-red-500 @enderror" placeholder="Nhập mật khẩu">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Xác nhận mật khẩu</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10" placeholder="Nhập lại mật khẩu">
                    </div>

                    <button id="registerButton" type="submit" class="w-full rounded-lg bg-gray-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-70">
                        <span id="registerButtonText">Đăng ký</span>
                        <span id="registerLoading" class="hidden items-center justify-center gap-2">
                            <svg class="h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            Đang đăng ký...
                        </span>
                    </button>
                </form>

                <div class="my-6 flex items-center gap-4">
                    <div class="h-px flex-1 bg-gray-200"></div>
                    <span class="text-xs text-gray-400">HOẶC</span>
                    <div class="h-px flex-1 bg-gray-200"></div>
                </div>

                <a id="googleRegisterButton" href="{{ route('google.login') }}" class="flex w-full items-center justify-center gap-3 rounded-lg border border-gray-300 px-4 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                    <span id="googleRegisterContent" class="flex items-center justify-center gap-3">
                        <svg class="h-5 w-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M21.35 12.23c0-.79-.07-1.55-.2-2.27H12v4.3h5.24a4.48 4.48 0 0 1-1.94 2.94v2.45h3.14c1.84-1.69 2.91-4.18 2.91-7.42z"/>
                            <path fill="#34A853" d="M12 21.75c2.63 0 4.84-.87 6.45-2.35l-3.14-2.45c-.87.58-1.98.92-3.31.92-2.54 0-4.69-1.72-5.46-4.03H3.3v2.53A9.75 9.75 0 0 0 12 21.75z"/>
                            <path fill="#FBBC05" d="M6.54 13.84a5.87 5.87 0 0 1 0-3.68V7.63H3.3a9.75 9.75 0 0 0 0 8.74l3.24-2.53z"/>
                            <path fill="#EA4335" d="M12 6.13c1.43 0 2.71.49 3.72 1.46l2.79-2.79C16.84 3.1 14.63 2.25 12 2.25a9.75 9.75 0 0 0-8.7 5.38l3.24 2.53C7.31 7.85 9.46 6.13 12 6.13z"/>
                        </svg>
                        Đăng ký bằng Google
                    </span>

                    <span id="googleRegisterLoading" class="hidden items-center justify-center gap-2">
                        <svg class="h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        Đang kết nối Google...
                    </span>
                </a>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-500">
                        Đã có tài khoản?
                        <a href="{{ route('login') }}" class="font-semibold text-gray-900 hover:underline">Đăng nhập</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function() {
            const button = document.getElementById('registerButton');
            const text = document.getElementById('registerButtonText');
            const loading = document.getElementById('registerLoading');

            button.disabled = true;
            text.classList.add('hidden');
            loading.classList.remove('hidden');
            loading.classList.add('flex');
        });

        document.getElementById('googleRegisterButton').addEventListener('click', function() {
            const button = this;
            const content = document.getElementById('googleRegisterContent');
            const loading = document.getElementById('googleRegisterLoading');

            button.classList.add('pointer-events-none', 'opacity-70');
            content.classList.add('hidden');
            loading.classList.remove('hidden');
            loading.classList.add('flex');
        });
    </script>
@endsection