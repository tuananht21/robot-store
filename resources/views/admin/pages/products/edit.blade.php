@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa sản phẩm')

@section('header', 'Chỉnh sửa sản phẩm')

@section('content')

<div class="mx-auto max-w-4xl">

    <div class="rounded-xl bg-white p-6 shadow-sm">

        <div class="mb-6">
            <h1 class="text-xl font-bold text-gray-800">Chỉnh sửa sản phẩm</h1>
            <p class="mt-1 text-sm text-gray-500">
                Cập nhật thông tin sản phẩm
            </p>
        </div>

        @if($errors->any())
            <div class="mb-6 rounded-lg bg-red-50 p-4 text-sm text-red-600">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('admin.products.update', $product->slug) }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-5">

            @csrf
            @method('PUT')

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Tên sản phẩm
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $product->name) }}"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-gray-900"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Danh mục
                </label>

                <select
                    name="category_id"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">

                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Mô tả
                </label>

                <textarea
                    name="description"
                    rows="6"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none focus:border-gray-900">{{ old('description', $product->description) }}</textarea>
            </div>

            @if($product->thumbnail)

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Hình ảnh hiện tại
                    </label>

                    <img
                        src="{{ asset('storage/' . $product->thumbnail) }}"
                        alt="{{ $product->name }}"
                        class="h-40 w-40 rounded-xl object-cover"
                    >
                </div>

            @endif

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Hình ảnh mới
                </label>

                <input
                    type="file"
                    name="thumbnail"
                    accept="image/*"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Trạng thái
                </label>

                <select
                    name="status"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">

                    <option value="1" {{ old('status', $product->status) == '1' ? 'selected' : '' }}>
                        Đang kinh doanh
                    </option>

                    <option value="0" {{ old('status', $product->status) == '0' ? 'selected' : '' }}>
                        Ngừng kinh doanh
                    </option>

                </select>
            </div>

            <div class="flex justify-end gap-3 pt-4">

                <a href="{{ route('admin.products.index') }}"
                   class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Hủy
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700">
                    Cập nhật
                </button>

            </div>

        </form>

    </div>

</div>

@endsection