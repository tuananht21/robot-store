@extends('layouts.app')

@section('title', 'Đặt lại mật khẩu - Robot Store')

@section('content')
<div class="min-h-[calc(100vh-8rem)] bg-gray-50 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Đặt lại mật khẩu</h1>
                <p class="mt-2 text-sm text-gray-500">Tạo mật khẩu mới cho tài khoản của bạn</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 @error('email') border-red-500 @enderror" placeholder="Nhập email của bạn">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu mới</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 @error('password') border-red-500 @enderror" placeholder="Nhập mật khẩu mới">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Xác nhận mật khẩu</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10" placeholder="Nhập lại mật khẩu">
                </div>

                <button type="submit" class="w-full rounded-lg bg-gray-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-gray-800">
                    Đặt lại mật khẩu
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-900 hover:underline">
                    ← Quay lại đăng nhập
                </a>
            </div>
        </div>
    </div>
</div>
@endsection