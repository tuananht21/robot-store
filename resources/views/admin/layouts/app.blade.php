<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin')</title>
    @vite(['resources/css/app.css'])
    @stack('style')
</head>

<body class="bg-gray-50">

    @include('admin.layouts.sidebar')

    <div id="adminContent" class="min-h-screen transition-all duration-300 lg:ml-64">

        @include('admin.layouts.header')

        <main class="p-4 sm:p-6">
            @yield('content')
        </main>
    </div>

    @vite(['resources/js/admin.js'])
    @stack('script')

</body>

</html>