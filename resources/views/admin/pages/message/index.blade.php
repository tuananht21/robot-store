@extends('admin.layouts.app')

@section('content')
    @php
        $chatData = [];

        foreach ($groupedMessages as $chatKey => $messages) {
            $lastMessage = $messages->last();

            $customerId = $lastMessage->user_from_id == $authUserId
                ? $lastMessage->user_to_id
                : $lastMessage->user_from_id;

            $customer = $lastMessage->user_from_id == $authUserId
                ? $lastMessage->userTo
                : $lastMessage->userFrom;

            $customerName = $customer?->name ?? 'Khách hàng';

            $chatData[$chatKey] = [
                'userId' => $customerId,
                'name' => $customerName,
                'messages' => $messages->map(function ($message) use ($authUserId) {
                    return [
                        'id' => $message->id,
                        'userFromId' => $message->user_from_id,
                        'userToId' => $message->user_to_id,
                        'message' => $message->message,
                        'time' => $message->created_at?->format('H:i'),
                        'isAdmin' => $message->user_from_id == $authUserId,
                    ];
                })->values()->toArray(),
            ];
        }

        $currentMessages = $firstChatKey
            ? $groupedMessages[$firstChatKey]
            : collect();

        $firstMessage = $currentMessages->first();
        $currentCustomer = null;

        if ($firstMessage) {
            $currentCustomer = $firstMessage->user_from_id == $authUserId
                ? $firstMessage->userTo
                : $firstMessage->userFrom;
        }

        $currentCustomerName = $currentCustomer?->name ?? 'Khách hàng';
    @endphp

    <div class="p-3 sm:p-6">
        <div class="mx-auto max-w-7xl">
            {{-- Header --}}
            <div class="mb-4 sm:mb-5">
                <h1 class="text-xl font-bold text-gray-900 sm:text-2xl">
                    Tin nhắn
                </h1>

                <p class="mt-1 text-xs text-gray-500 sm:text-sm">
                    Quản lý cuộc trò chuyện với khách hàng
                </p>
            </div>

            {{-- Chat wrapper --}}
            <div
                id="chatWrapper"
                class="relative flex h-[calc(100vh-145px)] min-h-[500px] overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm sm:h-[calc(100vh-180px)]"
            >
                {{-- Sidebar --}}
                <div
                    id="chatSidebar"
                    class="absolute inset-0 z-20 flex w-full flex-col border-r border-gray-200 bg-white transition-transform duration-300 md:relative md:inset-auto md:z-auto md:w-[280px] md:translate-x-0 lg:w-[320px]"
                >
                    <div class="shrink-0 border-b border-gray-200 px-4 py-4 sm:px-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-base font-semibold text-gray-900">
                                    Khách hàng
                                </h2>

                                <p class="mt-1 text-xs text-gray-500">
                                    {{ $groupedMessages->count() }} cuộc trò chuyện
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="min-h-0 flex-1 overflow-y-auto">
                        @forelse ($groupedMessages as $chatKey => $messages)
                            @php
                                $lastMessage = $messages->last();

                                $customerId = $lastMessage->user_from_id == $authUserId
                                    ? $lastMessage->user_to_id
                                    : $lastMessage->user_from_id;

                                $customer = $lastMessage->user_from_id == $authUserId
                                    ? $lastMessage->userTo
                                    : $lastMessage->userFrom;

                                $customerName = $customer?->name ?? 'Khách hàng';
                            @endphp

                            <button
                                type="button"
                                class="chat-item w-full border-b border-gray-100 px-3 py-3 text-left transition hover:bg-gray-50 sm:px-4"
                                data-chat-key="{{ $chatKey }}"
                                data-user-id="{{ $customerId }}"
                            >
                                <div class="flex items-center gap-3 rounded-xl p-2">
                                    {{-- Avatar --}}
                                    <div class="relative shrink-0">
                                        <div class="flex h-11 w-11 items-center justify-center rounded-full bg-gray-900 text-sm font-semibold text-white">
                                            {{ strtoupper(substr($customerName, 0, 1)) }}
                                        </div>

                                        <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-white bg-green-500"></span>
                                    </div>

                                    {{-- User info --}}
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center justify-between gap-2">
                                            <h3 class="truncate text-sm font-semibold text-gray-900">
                                                {{ $customerName }}
                                            </h3>

                                            <span class="shrink-0 text-[11px] text-gray-400">
                                                {{ $lastMessage->created_at?->format('H:i') }}
                                            </span>
                                        </div>

                                        <p class="mt-1 truncate text-xs text-gray-500">
                                            {{ $lastMessage->message }}
                                        </p>
                                    </div>
                                </div>
                            </button>
                        @empty
                            <div class="flex h-full flex-col items-center justify-center px-6 text-center">
                                <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-gray-100">
                                    <svg
                                        class="h-6 w-6 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.938L3 20l1.657-4.143A7.48 7.48 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                        />
                                    </svg>
                                </div>

                                <h3 class="text-sm font-semibold text-gray-700">
                                    Chưa có cuộc trò chuyện
                                </h3>

                                <p class="mt-1 text-xs text-gray-400">
                                    Tin nhắn của khách hàng sẽ xuất hiện ở đây.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Chat --}}
                <div
                    id="chatPanel"
                    class="absolute inset-0 z-10 flex min-w-0 flex-1 translate-x-full flex-col bg-white transition-transform duration-300 md:relative md:inset-auto md:z-auto md:translate-x-0"
                >
                    {{-- Chat header --}}
                    <div class="flex h-[65px] shrink-0 items-center border-b border-gray-200 px-3 sm:h-[73px] sm:px-6">
                        {{-- Back button mobile --}}
                        <button
                            id="backToChats"
                            type="button"
                            class="mr-2 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-gray-600 transition hover:bg-gray-100 md:hidden"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M15 19l-7-7 7-7"
                                />
                            </svg>
                        </button>

                        <div class="flex min-w-0 items-center gap-3">
                            <div class="relative shrink-0">
                                <div
                                    id="chatAvatar"
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-900 text-sm font-semibold text-white"
                                >
                                    {{ strtoupper(substr($currentCustomerName, 0, 1)) }}
                                </div>

                                <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-white bg-green-500"></span>
                            </div>

                            <div class="min-w-0">
                                <h2
                                    id="chatCustomerName"
                                    class="max-w-[180px] truncate text-sm font-semibold text-gray-900 sm:max-w-none"
                                >
                                    {{ $currentCustomerName }}
                                </h2>

                                <div class="mt-0.5 flex items-center gap-1.5">
                                    <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>

                                    <span class="text-xs text-gray-500">
                                        Đang hoạt động
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Messages --}}
                    <div
                        id="messages"
                        class="min-h-0 flex-1 overflow-y-auto bg-gray-50 px-3 py-4 sm:px-6 sm:py-5"
                    >
                        @if ($firstChatKey && isset($groupedMessages[$firstChatKey]))
                            @foreach ($groupedMessages[$firstChatKey] as $message)
                                @if ($message->user_from_id == $authUserId)
                                    {{-- Admin message --}}
                                    <div class="mb-3 flex justify-end">
                                        <div class="max-w-[85%] sm:max-w-[70%]">
                                            <div class="break-words rounded-2xl rounded-br-md bg-gray-900 px-4 py-2.5 text-sm leading-6 text-white shadow-sm">
                                                {{ $message->message }}
                                            </div>

                                            <div class="mt-1 text-right text-[10px] text-gray-400">
                                                {{ $message->created_at?->format('H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    {{-- Customer message --}}
                                    <div class="mb-3 flex justify-start">
                                        <div class="max-w-[85%] sm:max-w-[70%]">
                                            <div class="break-words rounded-2xl rounded-bl-md border border-gray-200 bg-white px-4 py-2.5 text-sm leading-6 text-gray-700 shadow-sm">
                                                {{ $message->message }}
                                            </div>

                                            <div class="mt-1 text-[10px] text-gray-400">
                                                {{ $message->created_at?->format('H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div class="flex h-full flex-col items-center justify-center px-4 text-center">
                                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-white shadow-sm">
                                    <svg
                                        class="h-7 w-7 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.938L3 20l1.657-4.143A7.48 7.48 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                        />
                                    </svg>
                                </div>

                                <h3 class="text-sm font-semibold text-gray-700">
                                    Chưa có tin nhắn
                                </h3>

                                <p class="mt-1 text-xs text-gray-400">
                                    Chọn một khách hàng để bắt đầu trò chuyện.
                                </p>
                            </div>
                        @endif
                    </div>

                    {{-- Input --}}
                    <div class="shrink-0 border-t border-gray-200 bg-white p-2.5 sm:p-4">
                        <div class="flex items-end gap-2 rounded-xl border border-gray-200 bg-gray-50 p-2 transition focus-within:border-gray-400 focus-within:bg-white sm:gap-3">
                            <textarea
                                id="messageInput"
                                rows="1"
                                placeholder="Nhập tin nhắn..."
                                class="max-h-32 min-h-[42px] flex-1 resize-none border-0 bg-transparent px-2 py-2 text-sm text-gray-900 outline-none placeholder:text-gray-400 focus:ring-0 sm:px-3"
                            ></textarea>

                            <button
                                id="sendBtn"
                                type="button"
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-900 text-white transition hover:bg-gray-700 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 12h14M12 5l7 7-7 7"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const authUserId = {{ $authUserId }};
        const firstChatKey = @json($firstChatKey);
        const chatData = @json($chatData);

        let currentChatKey = firstChatKey;
        let currentCustomerId = firstChatKey && chatData[firstChatKey]
            ? Number(chatData[firstChatKey].userId)
            : null;

        const messagesContainer = document.getElementById('messages');
        const messageInput = document.getElementById('messageInput');
        const sendBtn = document.getElementById('sendBtn');
        const chatCustomerName = document.getElementById('chatCustomerName');
        const chatAvatar = document.getElementById('chatAvatar');
        const chatSidebar = document.getElementById('chatSidebar');
        const chatPanel = document.getElementById('chatPanel');
        const backToChats = document.getElementById('backToChats');

        function renderMessages(messages) {
            if (!messages.length) {
                messagesContainer.innerHTML = `
                    <div class="flex h-full flex-col items-center justify-center px-4 text-center">
                        <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-white shadow-sm">
                            <svg class="h-7 w-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.938L3 20l1.657-4.143A7.48 7.48 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                />
                            </svg>
                        </div>

                        <h3 class="text-sm font-semibold text-gray-700">
                            Chưa có tin nhắn
                        </h3>

                        <p class="mt-1 text-xs text-gray-400">
                            Bắt đầu cuộc trò chuyện với khách hàng.
                        </p>
                    </div>
                `;

                return;
            }

            messagesContainer.innerHTML = messages.map(message => {
                if (message.isAdmin) {
                    return `
                        <div class="mb-3 flex justify-end">
                            <div class="max-w-[85%] sm:max-w-[70%]">
                                <div class="break-words rounded-2xl rounded-br-md bg-gray-900 px-4 py-2.5 text-sm leading-6 text-white shadow-sm">
                                    ${escapeHtml(message.message)}
                                </div>

                                <div class="mt-1 text-right text-[10px] text-gray-400">
                                    ${message.time ?? ''}
                                </div>
                            </div>
                        </div>
                    `;
                }

                return `
                    <div class="mb-3 flex justify-start">
                        <div class="max-w-[85%] sm:max-w-[70%]">
                            <div class="break-words rounded-2xl rounded-bl-md border border-gray-200 bg-white px-4 py-2.5 text-sm leading-6 text-gray-700 shadow-sm">
                                ${escapeHtml(message.message)}
                            </div>

                            <div class="mt-1 text-[10px] text-gray-400">
                                ${message.time ?? ''}
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            scrollToBottom();
        }

        function showChatPanel() {
            chatSidebar.classList.add('-translate-x-full');
            chatPanel.classList.remove('translate-x-full');
        }

        function showChatSidebar() {
            chatSidebar.classList.remove('-translate-x-full');
            chatPanel.classList.add('translate-x-full');
        }

        function openChat(chatKey) {
            const chat = chatData[chatKey];

            if (!chat) {
                return;
            }

            currentChatKey = chatKey;
            currentCustomerId = Number(chat.userId);

            chatCustomerName.textContent = chat.name;
            chatAvatar.textContent = chat.name.charAt(0).toUpperCase();

            document.querySelectorAll('.chat-item').forEach(item => {
                item.classList.remove('bg-gray-100');

                if (item.dataset.chatKey === chatKey) {
                    item.classList.add('bg-gray-100');
                }
            });

            showChatPanel();
            loadConversation(currentCustomerId);
        }

        async function loadConversation(userId) {
            try {
                const response = await fetch(`{{ url('/message') }}/${userId}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (!response.ok || result.status !== 'success') {
                    throw new Error(result.message || 'Không thể tải cuộc trò chuyện.');
                }

                const messages = result.data.map(message => ({
                    id: message.id,
                    userFromId: Number(message.user_from_id),
                    userToId: Number(message.user_to_id),
                    message: message.message,
                    time: message.created_at
                        ? new Date(message.created_at).toLocaleTimeString('vi-VN', {
                            hour: '2-digit',
                            minute: '2-digit'
                        })
                        : '',
                    isAdmin: Number(message.user_from_id) === Number(authUserId)
                }));

                renderMessages(messages);

                const chatKey = [authUserId, userId]
                    .sort((a, b) => a - b)
                    .join('-');

                if (chatData[chatKey]) {
                    chatData[chatKey].messages = messages;
                }
            } catch (error) {
                console.error('Lỗi tải cuộc trò chuyện:', error);
            }
        }

        function appendMessage(message) {
            const isAdmin = Number(message.userFromId) === Number(authUserId);

            const messageHtml = isAdmin
                ? `
                    <div class="mb-3 flex justify-end">
                        <div class="max-w-[85%] sm:max-w-[70%]">
                            <div class="break-words rounded-2xl rounded-br-md bg-gray-900 px-4 py-2.5 text-sm leading-6 text-white shadow-sm">
                                ${escapeHtml(message.message)}
                            </div>

                            <div class="mt-1 text-right text-[10px] text-gray-400">
                                ${message.time ?? ''}
                            </div>
                        </div>
                    </div>
                `
                : `
                    <div class="mb-3 flex justify-start">
                        <div class="max-w-[85%] sm:max-w-[70%]">
                            <div class="break-words rounded-2xl rounded-bl-md border border-gray-200 bg-white px-4 py-2.5 text-sm leading-6 text-gray-700 shadow-sm">
                                ${escapeHtml(message.message)}
                            </div>

                            <div class="mt-1 text-[10px] text-gray-400">
                                ${message.time ?? ''}
                            </div>
                        </div>
                    </div>
                `;

            messagesContainer.insertAdjacentHTML('beforeend', messageHtml);
            scrollToBottom();
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text ?? '';

            return div.innerHTML;
        }

        function scrollToBottom() {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        document.querySelectorAll('.chat-item').forEach(item => {
            item.addEventListener('click', function () {
                openChat(this.dataset.chatKey);
            });
        });

        backToChats.addEventListener('click', showChatSidebar);

        sendBtn.addEventListener('click', sendMessage);

        messageInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        });

        async function sendMessage() {
            const message = messageInput.value.trim();

            if (!message || !currentCustomerId) {
                return;
            }

            sendBtn.disabled = true;

            try {
                const response = await fetch('{{ route('message.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        user_to_id: currentCustomerId,
                        message: message
                    })
                });

                const result = await response.json();

                if (!response.ok || result.status !== 'success') {
                    throw new Error(result.message || 'Gửi tin nhắn thất bại.');
                }

                const newMessage = {
                    id: result.data.id,
                    userFromId: Number(result.data.user_from_id),
                    userToId: Number(result.data.user_to_id),
                    message: result.data.message,
                    time: result.data.created_at
                        ? new Date(result.data.created_at).toLocaleTimeString('vi-VN', {
                            hour: '2-digit',
                            minute: '2-digit'
                        })
                        : new Date().toLocaleTimeString('vi-VN', {
                            hour: '2-digit',
                            minute: '2-digit'
                        }),
                    isAdmin: true
                };

                const chatKey = [authUserId, currentCustomerId]
                    .sort((a, b) => a - b)
                    .join('-');

                if (!chatData[chatKey]) {
                    chatData[chatKey] = {
                        userId: currentCustomerId,
                        name: chatCustomerName.textContent,
                        messages: []
                    };
                }

                chatData[chatKey].messages.push(newMessage);
                currentChatKey = chatKey;

                appendMessage(newMessage);

                messageInput.value = '';
                messageInput.style.height = '42px';
            } catch (error) {
                console.error('Lỗi gửi tin nhắn:', error);
                alert(error.message);
            } finally {
                sendBtn.disabled = false;
                messageInput.focus();
            }
        }

        function initMessageRealtime() {
            if (!window.Echo || !authUserId) {
                console.error('Echo chưa được khởi tạo hoặc Admin chưa đăng nhập.');
                return;
            }

            console.log('Admin Echo đã sẵn sàng:', window.Echo);
            console.log('Đang lắng nghe:', `message.${authUserId}`);

            window.Echo.private(`message.${authUserId}`).listen('.messageEvent', event => {
                console.log('Admin nhận realtime:', event);
                const userId = Number(event.userFromID);

                if (userId === Number(authUserId)) {
                    return;
                }

                const chatKey = [authUserId, userId].sort((a, b) => a - b).join('-');
                const newMessage = {
                    id: Date.now(),
                    userFromId: userId,
                    userToId: Number(event.userToID),
                    message: event.message,
                    time: new Date().toLocaleTimeString('vi-VN', {
                        hour: '2-digit',
                        minute: '2-digit'
                    }),
                    isAdmin: false
                };

                if (!chatData[chatKey]) {
                        chatData[chatKey] = {
                        userId: userId,
                        name: `Khách hàng ${userId}`,
                        messages: []
                    };
                }

                chatData[chatKey].messages.push(newMessage);

                if (currentChatKey === chatKey) {
                    appendMessage(newMessage);
                }
            });
        }
        window.addEventListener('load', initMessageRealtime);

        if (currentChatKey && window.innerWidth >= 768) {
            openChat(currentChatKey);
        }
    </script>
@endsection