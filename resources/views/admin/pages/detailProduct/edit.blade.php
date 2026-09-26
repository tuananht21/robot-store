@extends('admin.layouts.app')

@section('title', 'Sửa Detail Product')

@section('header', 'Sửa Detail Product')

@section('content')

<div class="mx-auto max-w-3xl">

    <div class="rounded-xl bg-white p-6 shadow-sm">

        <div class="mb-6">
            <h1 class="text-xl font-bold text-gray-800">
                Sửa Detail Product
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Sản phẩm: {{ $product->name }}
            </p>
        </div>

        @if($errors->any())
            <div class="mb-6 rounded-lg bg-red-50 p-4 text-sm text-red-600">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('admin.products.detail-products.update', [$product->id, $detailProduct->id]) }}"
            method="POST"
            class="space-y-5">

            @csrf
            @method('PUT')

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Tên detail
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $detailProduct->name) }}"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Giá
                </label>

                <input
                    type="number"
                    name="price"
                    value="{{ old('price', $detailProduct->price) }}"
                    min="0"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm"
                >
            </div>

            <div class="flex justify-end gap-3">

                <a
                    href="{{ route('admin.products.detail-products.index', $product->id) }}"
                    class="rounded-lg border px-5 py-2.5 text-sm">
                    Hủy
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm text-white">
                    Cập nhật
                </button>

            </div>

        </form>

    </div>

</div>

@endsection