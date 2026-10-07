@extends('admin.layouts.app')

@section('title', 'Users')

@section('header', 'Users')

@section('content')
    <div class="space-y-6">
        @if(session('success'))
            <div class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="rounded-xl bg-white p-6 shadow-sm">
            <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Quản lý khách hàng</h2>
                    <p class="mt-1 text-sm text-gray-500">Danh sách tài khoản khách hàng của Robot Store.</p>
                </div>

                <form action="{{ route('admin.users.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Tìm tên hoặc email..." class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm outline-none focus:border-gray-500 focus:ring-1 focus:ring-gray-500 sm:w-72">

                    <button type="submit" class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-700">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-xs uppercase text-gray-500">
                            <th class="px-4 py-3">Khách hàng</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Đơn hàng</th>
                            <th class="px-4 py-3">Ngày tham gia</th>
                            <th class="px-4 py-3 text-right">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $user)
                            <tr class="transition hover:bg-gray-50">
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($user->avatar)
                                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="h-10 w-10 rounded-full object-cover">
                                        @else
                                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-600">
                                                <i class="fa-solid fa-user"></i>
                                            </div>
                                        @endif

                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-500">ID: #{{ $user->id }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-gray-600">
                                    {{ $user->email }}
                                </td>

                                <td class="px-4 py-4">
                                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                        {{ $user->orders_count }} đơn
                                    </span>
                                </td>

                                <td class="px-4 py-4 text-gray-600">
                                    {{ $user->created_at->format('d/m/Y') }}
                                </td>

                                <td class="px-4 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 text-gray-600 transition hover:bg-gray-200" title="Xem chi tiết">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa khách hàng này?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-red-600 transition hover:bg-red-100" title="Xóa">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-gray-500">
                                    Không tìm thấy khách hàng.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection