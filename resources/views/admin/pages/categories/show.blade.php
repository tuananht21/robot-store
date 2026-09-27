@extends('admin.layouts.app')

@section('title', 'Chi tiết danh mục')

@section('header', 'Chi tiết danh mục')

@section('content')

<div class="mx-auto max-w-3xl">

    <div class="rounded-xl bg-white p-6 shadow-sm">

        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-bold text-gray-800">
                    {{ $category->name }}
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Thông tin chi tiết danh mục
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.categories.edit', $category->slug) }}"
                   class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                    Sửa
                </a>

                <a href="{{ route('admin.categories.index') }}"
                   class="rounded-lg border px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Quay lại
                </a>
            </div>
        </div>

        <div class="divide-y rounded-lg border">

            <div class="grid gap-2 px-5 py-4 sm:grid-cols-3">
                <span class="text-sm font-medium text-gray-500">
                    ID
                </span>

                <span class="text-sm text-gray-800 sm:col-span-2">
                    {{ $category->id }}
                </span>
            </div>

            <div class="grid gap-2 px-5 py-4 sm:grid-cols-3">
                <span class="text-sm font-medium text-gray-500">
                    Tên danh mục
                </span>

                <span class="text-sm text-gray-800 sm:col-span-2">
                    {{ $category->name }}
                </span>
            </div>

            <div class="grid gap-2 px-5 py-4 sm:grid-cols-3">
                <span class="text-sm font-medium text-gray-500">
                    Slug
                </span>

                <span class="text-sm text-gray-800 sm:col-span-2">
                    {{ $category->slug }}
                </span>
            </div>

            <div class="grid gap-2 px-5 py-4 sm:grid-cols-3">
                <span class="text-sm font-medium text-gray-500">
                    Ngày tạo
                </span>

                <span class="text-sm text-gray-800 sm:col-span-2">
                    {{ $category->created_at?->format('d/m/Y H:i') }}
                </span>
            </div>

            <div class="grid gap-2 px-5 py-4 sm:grid-cols-3">
                <span class="text-sm font-medium text-gray-500">
                    Cập nhật
                </span>

                <span class="text-sm text-gray-800 sm:col-span-2">
                    {{ $category->updated_at?->format('d/m/Y H:i') }}
                </span>
            </div>

        </div>

    </div>

</div>

@endsection