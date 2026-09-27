<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    <main>
        @include('layouts.header')

        @yield('content')
    </main>

    @include('layouts.footer')
    {{-- Toast --}}
    <div id="toast"
        class="fixed top-5 right-5 w-72 p-4 text-white rounded-lg shadow-lg opacity-0 translate-x-5 transition-all duration-300 pointer-events-none z-[99999]">
        <p id="toast-message"></p>
    </div>

    <script>
        let toastTimeout;

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');

            if (!toast || !toastMessage) return;

            toast.classList.remove('bg-green-500', 'bg-red-500', 'bg-yellow-500', 'bg-blue-500', 'opacity-0',
                'translate-x-5', 'opacity-100', 'translate-x-0');

            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                warning: 'bg-yellow-500',
                info: 'bg-blue-500'
            };

            toast.classList.add(colors[type] || colors.success);
            toastMessage.textContent = message;

            toast.classList.add('opacity-100', 'translate-x-0');

            clearTimeout(toastTimeout);

            toastTimeout = setTimeout(() => {
                toast.classList.remove('opacity-100', 'translate-x-0');
                toast.classList.add('opacity-0', 'translate-x-5');
            }, 5000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                showToast(@json(session('success')), 'success');
            @elseif (session('error'))
                showToast(@json(session('error')), 'error');
            @elseif (session('warning'))
                showToast(@json(session('warning')), 'warning');
            @elseif (session('info'))
                showToast(@json(session('info')), 'info');
            @endif
        });
    </script>
</body>

</html>
