@extends('admin.layouts.app')

@section('title', 'Categories')

@section('header', 'Categories')

@section('content')

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Categories
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Quản lý danh mục sản phẩm
                </p>
            </div>

            <a href="{{ route('admin.categories.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-700">
                + Thêm category
            </a>

        </div>


        {{-- Success message --}}
        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif


        {{-- Error message --}}
        @if (session('error'))
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif


        {{-- Table --}}
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                #
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Name
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Slug
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Ngày tạo
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">

                        @forelse ($categories as $category)

                            <tr class="transition hover:bg-gray-50">

                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ $category->id }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">

                                    <div class="font-medium text-gray-900">
                                        {{ $category->name }}
                                    </div>

                                </td>

                                <td class="whitespace-nowrap px-6 py-4">

                                    <span class="rounded-md bg-gray-100 px-2.5 py-1 text-xs text-gray-600">
                                        {{ $category->slug }}
                                    </span>

                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ $category->created_at?->format('d/m/Y H:i') }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">

                                    <div class="flex justify-end gap-2">

                                        {{-- Edit --}}
                                        <a href="{{ route('admin.categories.edit', $category->id) }}"
                                            class="rounded-lg border border-blue-200 bg-blue-50 px-3 py-1.5 text-sm font-medium text-blue-600 transition hover:bg-blue-100">
                                            Sửa
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Bạn có chắc muốn xóa category này?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-sm font-medium text-red-600 transition hover:bg-red-100">
                                                Xóa
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="px-6 py-12 text-center">

                                    <div class="text-gray-500">
                                        Chưa có category nào.
                                    </div>

                                    <a href="{{ route('admin.categories.create') }}"
                                        class="mt-3 inline-block text-sm font-medium text-blue-600 hover:underline">
                                        Thêm category đầu tiên
                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection