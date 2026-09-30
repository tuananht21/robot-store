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

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
        integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    <main>
        @include('layouts.header')

        @yield('content')
    </main>

    @if (Auth::check())
        <!-- Chat button -->
        <button
            id="openChat"
            type="button"
            class="fixed bottom-20 right-16 z-[9999] flex cursor-pointer items-center gap-2 rounded-full bg-black px-6 py-4 text-sm font-medium text-white shadow-xl transition hover:bg-gray-800"
        >
            <i class="fa-solid fa-comments"></i>
            <span>Liên hệ</span>
        </button>

        <!-- Chat modal -->
        <div id="chatModal" class="fixed bottom-8 right-8 z-[9999] hidden">
            <div class="flex h-[480px] w-[360px] flex-col overflow-hidden rounded-2xl border border-gray-800 bg-white shadow-2xl">
                <!-- Header -->
                <div class="flex items-center justify-between bg-black px-4 py-3 text-white">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-white text-black">
                            <i class="fa-solid fa-headset"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold">Chat Support</h2>
                            <p class="text-xs text-gray-400">Hỗ trợ khách hàng</p>
                        </div>
                    </div>

                    <button
                        id="closeChat"
                        type="button"
                        class="flex h-8 w-8 items-center justify-center rounded-full text-gray-300 transition hover:bg-gray-800 hover:text-white"
                    >
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Messages -->
                <div id="chatMessages" class="flex-1 space-y-3 overflow-y-auto bg-gray-50 p-4">
                    <div class="flex items-start gap-2">
                        <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-black text-white">
                            <i class="fa-solid fa-headset text-xs"></i>
                        </div>
                        <div class="max-w-[75%] rounded-2xl rounded-tl-none border border-gray-200 bg-white px-3 py-2 text-sm text-gray-800 shadow-sm">
                            Xin chào! Tôi có thể giúp gì?
                        </div>
                    </div>
                </div>

                <!-- Input -->
                <div class="border-t border-gray-200 bg-white p-3">
                    <div class="flex items-center gap-2 rounded-xl border border-gray-300 bg-gray-50 p-1 focus-within:border-black">
                        <input
                            id="chatInput"
                            type="text"
                            placeholder="Nhập tin nhắn..."
                            autocomplete="off"
                            class="flex-1 border-0 bg-transparent px-3 py-2 text-sm text-gray-900 outline-none placeholder:text-gray-400 focus:ring-0"
                        />

                        <button
                            id="sendMsg"
                            type="button"
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-black text-white transition hover:bg-gray-800"
                        >
                            <i class="fa-solid fa-paper-plane text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const openChat = document.getElementById('openChat');
                const closeChat = document.getElementById('closeChat');
                const chatModal = document.getElementById('chatModal');
                const sendMsg = document.getElementById('sendMsg');
                const chatInput = document.getElementById('chatInput');
                const chatMessages = document.getElementById('chatMessages');

                const userId = @json(Auth::id());
                const adminId = 1;

                // Mở chatbox
                openChat.addEventListener('click', function () {
                    chatModal.classList.remove('hidden');
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                    chatInput.focus();
                });

                // Đóng chatbox
                closeChat.addEventListener('click', function () {
                    chatModal.classList.add('hidden');
                });

                // Thêm tin nhắn của user
                function appendUserMessage(message) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'flex justify-end';

                    const messageElement = document.createElement('div');
                    messageElement.textContent = message;
                    messageElement.className =
                        'max-w-[75%] rounded-2xl rounded-tr-none bg-black px-3 py-2 text-sm text-white shadow-sm';

                    wrapper.appendChild(messageElement);
                    chatMessages.appendChild(wrapper);

                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }

                // Thêm tin nhắn của admin
                function appendAdminMessage(message) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'flex items-start gap-2';

                    const avatar = document.createElement('div');
                    avatar.className =
                        'flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-black text-white';
                    avatar.innerHTML =
                        '<i class="fa-solid fa-headset text-xs"></i>';

                    const messageElement = document.createElement('div');
                    messageElement.textContent = message;
                    messageElement.className =
                        'max-w-[75%] rounded-2xl rounded-tl-none border border-gray-200 bg-white px-3 py-2 text-sm text-gray-800 shadow-sm';

                    wrapper.appendChild(avatar);
                    wrapper.appendChild(messageElement);
                    chatMessages.appendChild(wrapper);

                    chatMessages.scrollTo({
                        top: chatMessages.scrollHeight,
                        behavior: 'smooth',
                    });
                }

                // Gửi tin nhắn
                async function sendMessage() {
                    const message = chatInput.value.trim();

                    if (!message) {
                        return;
                    }

                    appendUserMessage(message);
                    chatInput.value = '';

                    try {
                        const csrfToken = document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content');

                        const response = await fetch('{{ route('message.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            credentials: 'include',
                            body: JSON.stringify({
                                user_to_id: adminId,
                                message: message,
                            }),
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            console.error('Lỗi gửi tin nhắn:', data);
                            return;
                        }

                        if (data.status !== 'success') {
                            console.error(data.message);
                        }
                    } catch (error) {
                        console.error('Không thể gửi tin nhắn:', error);
                    }
                }

                // Click gửi
                sendMsg.addEventListener('click', function () {
                    sendMessage();
                });

                // Enter để gửi
                chatInput.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        sendMessage();
                    }
                });

                // Nhận tin nhắn realtime
                if (window.Echo && userId) {
                    window.Echo
                        .private(`message.${userId}`)
                        .listen('.messageEvent', function (event) {
                            if (Number(event.userFromID) !== Number(userId)) {
                                appendAdminMessage(event.message);
                            }
                        });
                } else {
                    console.error('Echo chưa được khởi tạo.');
                }
            });
        </script>
    @endif

    @include('layouts.footer')

</body>

</html>