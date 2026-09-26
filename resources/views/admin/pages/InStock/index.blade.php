@extends('admin.layouts.app')

@section('title', 'Tồn kho')

@section('header', 'Tồn kho')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Tồn kho
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Detail Product #{{ $detailID }}
            </p>
        </div>

        <a
            href="{{ route('admin.detail-products.in-stock.edit', $detailID) }}"
            class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700">
            Cập nhật tồn kho
        </a>

    </div>

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

        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm text-gray-500">
                    Mã Detail Product
                </p>

                <p class="mt-1 text-lg font-bold text-gray-800">
                    #{{ $detailID }}
                </p>
            </div>

            <div class="rounded-xl bg-gray-100 px-6 py-4 text-center">
                <p class="text-xs text-gray-500">
                    Tồn kho
                </p>

                <p class="mt-1 text-2xl font-bold text-gray-800">
                    {{ $inStock->stock ?? 0 }}
                </p>
            </div>

        </div>

    </div>

</div>

@endsection