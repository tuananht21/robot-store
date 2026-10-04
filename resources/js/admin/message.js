const chatWrapper = document.getElementById("chatWrapper");

const authUserId = Number(chatWrapper.dataset.authUserId);
const firstChatKey = chatWrapper.dataset.firstChatKey || null;
const chatData = JSON.parse(chatWrapper.dataset.chatData || "{}");

const messageUrl = chatWrapper.dataset.messageUrl;
const storeUrl = chatWrapper.dataset.storeUrl;
const csrfToken = chatWrapper.dataset.csrfToken;

let currentChatKey = firstChatKey;

let currentCustomerId =
    firstChatKey && chatData[firstChatKey]
        ? Number(chatData[firstChatKey].userId)
        : null;

const messagesContainer = document.getElementById("messages");
const messageInput = document.getElementById("messageInput");
const sendBtn = document.getElementById("sendBtn");

const chatCustomerName = document.getElementById("chatCustomerName");
const chatAvatar = document.getElementById("chatAvatar");

const chatSidebar = document.getElementById("chatSidebar");
const chatPanel = document.getElementById("chatPanel");

const backToChats = document.getElementById("backToChats");
const conversationList = document.getElementById("conversationList");
const conversationCount = document.getElementById("conversationCount");

function escapeHtml(text) {
    const div = document.createElement("div");

    div.textContent = text ?? "";

    return div.innerHTML;
}

function scrollToBottom() {
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

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
                            d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.938L3 20l1.657-4.143A7.48 7.48 0 013 12c0-4.418 4.03 8 9 8s9-3.582 9-8z"
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

    messagesContainer.innerHTML = messages
        .map((message) => {
            if (message.isAdmin) {
                return `
                <div class="mb-3 flex justify-end">
                    <div class="max-w-[85%] sm:max-w-[70%]">
                        <div class="break-words rounded-2xl rounded-br-md bg-gray-900 px-4 py-2.5 text-sm leading-6 text-white shadow-sm">
                            ${escapeHtml(message.message)}
                        </div>

                        <div class="mt-1 text-right text-[10px] text-gray-400">
                            ${message.time ?? ""}
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
                        ${message.time ?? ""}
                    </div>
                </div>
            </div>
        `;
        })
        .join("");

    scrollToBottom();
}

function showChatPanel() {
    chatSidebar.classList.add("-translate-x-full");
    chatPanel.classList.remove("translate-x-full");
}

function showChatSidebar() {
    chatSidebar.classList.remove("-translate-x-full");
    chatPanel.classList.add("translate-x-full");
}

function updateActiveChat(chatKey) {
    document.querySelectorAll(".chat-item").forEach((item) => {
        item.classList.toggle("bg-gray-100", item.dataset.chatKey === chatKey);
    });
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

    updateActiveChat(chatKey);
    showChatPanel();

    loadConversation(currentCustomerId);
}

async function loadConversation(userId) {
    try {
        const response = await fetch(`${messageUrl}/${userId}`, {
            headers: {
                Accept: "application/json",
            },
        });

        const result = await response.json();

        if (!response.ok || result.status !== "success") {
            throw new Error(result.message || "Không thể tải cuộc trò chuyện.");
        }

        const messages = result.data.map((message) => ({
            id: message.id,
            userFromId: Number(message.user_from_id),
            userToId: Number(message.user_to_id),
            message: message.message,

            time: message.created_at
                ? new Date(message.created_at).toLocaleTimeString("vi-VN", {
                      hour: "2-digit",
                      minute: "2-digit",
                  })
                : "",

            isAdmin: Number(message.user_from_id) === Number(authUserId),
        }));

        renderMessages(messages);

        const chatKey = [authUserId, userId].sort((a, b) => a - b).join("-");

        if (chatData[chatKey]) {
            chatData[chatKey].messages = messages;
        }
    } catch (error) {
        console.error("Lỗi tải cuộc trò chuyện:", error);
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
                        ${message.time ?? ""}
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
                        ${message.time ?? ""}
                    </div>
                </div>
            </div>
        `;

    messagesContainer.insertAdjacentHTML("beforeend", messageHtml);

    scrollToBottom();
}

function updateConversationCount() {
    if (!conversationCount) {
        return;
    }

    const count = document.querySelectorAll(".chat-item").length;

    conversationCount.textContent = `${count} cuộc trò chuyện`;
}

function updateConversationSidebar(chatKey, chat, message) {
    let chatItem = document.querySelector(
        `.chat-item[data-chat-key="${chatKey}"]`,
    );

    const time =
        message.time ||
        new Date().toLocaleTimeString("vi-VN", {
            hour: "2-digit",
            minute: "2-digit",
        });

    if (chatItem) {
        const timeElement = chatItem.querySelector('[data-role="time"]');

        const previewElement = chatItem.querySelector('[data-role="preview"]');

        if (timeElement) {
            timeElement.textContent = time;
        }

        if (previewElement) {
            previewElement.textContent = message.message;
        }

        conversationList.prepend(chatItem);

        updateActiveChat(currentChatKey);

        return;
    }

    const emptyState = document.getElementById("emptyConversationState");

    if (emptyState) {
        emptyState.remove();
    }

    chatItem = document.createElement("button");

    chatItem.type = "button";

    chatItem.className =
        "chat-item w-full border-b border-gray-100 px-3 py-3 text-left transition hover:bg-gray-50 sm:px-4";

    chatItem.dataset.chatKey = chatKey;
    chatItem.dataset.userId = chat.userId;

    chatItem.innerHTML = `
        <div class="flex items-center gap-3 rounded-xl p-2">
            <div class="relative shrink-0">
                <div class="flex h-11 w-11 items-center justify-center rounded-full bg-gray-900 text-sm font-semibold text-white">
                    ${escapeHtml(chat.name.charAt(0).toUpperCase())}
                </div>

                <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-white bg-green-500"></span>
            </div>

            <div class="min-w-0 flex-1">
                <div class="flex items-center justify-between gap-2">
                    <h3 class="truncate text-sm font-semibold text-gray-900">
                        ${escapeHtml(chat.name)}
                    </h3>

                    <span
                        data-role="time"
                        class="shrink-0 text-[11px] text-gray-400"
                    >
                        ${time}
                    </span>
                </div>

                <p
                    data-role="preview"
                    class="mt-1 truncate text-xs text-gray-500"
                >
                    ${escapeHtml(message.message)}
                </p>
            </div>
        </div>
    `;

    chatItem.addEventListener("click", function () {
        openChat(this.dataset.chatKey);
    });

    conversationList.prepend(chatItem);

    updateConversationCount();
}

async function sendMessage() {
    const message = messageInput.value.trim();

    if (!message || !currentCustomerId) {
        return;
    }

    sendBtn.disabled = true;

    try {
        const response = await fetch(storeUrl, {
            method: "POST",

            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },

            body: JSON.stringify({
                user_to_id: currentCustomerId,
                message: message,
            }),
        });

        const result = await response.json();

        if (!response.ok || result.status !== "success") {
            throw new Error(result.message || "Gửi tin nhắn thất bại.");
        }

        const newMessage = {
            id: result.data.id,
            userFromId: Number(result.data.user_from_id),
            userToId: Number(result.data.user_to_id),
            message: result.data.message,

            time: result.data.created_at
                ? new Date(result.data.created_at).toLocaleTimeString("vi-VN", {
                      hour: "2-digit",
                      minute: "2-digit",
                  })
                : new Date().toLocaleTimeString("vi-VN", {
                      hour: "2-digit",
                      minute: "2-digit",
                  }),

            isAdmin: true,
        };

        const chatKey = [authUserId, currentCustomerId]
            .sort((a, b) => a - b)
            .join("-");

        if (!chatData[chatKey]) {
            chatData[chatKey] = {
                userId: currentCustomerId,
                name: chatCustomerName.textContent,
                messages: [],
            };
        }

        chatData[chatKey].messages.push(newMessage);

        currentChatKey = chatKey;

        appendMessage(newMessage);

        updateConversationSidebar(chatKey, chatData[chatKey], newMessage);

        messageInput.value = "";
        messageInput.style.height = "42px";
    } catch (error) {
        console.error("Lỗi gửi tin nhắn:", error);

        alert(error.message);
    } finally {
        sendBtn.disabled = false;
        messageInput.focus();
    }
}

function initMessageRealtime() {
    if (!window.Echo || !authUserId) {
        console.error("Echo chưa được khởi tạo hoặc Admin chưa đăng nhập.");

        return;
    }

    console.log("Admin Echo đã sẵn sàng:", window.Echo);

    console.log("Đang lắng nghe:", `message.${authUserId}`);

    window.Echo.private(`message.${authUserId}`).listen(
        ".messageEvent",
        (event) => {
            console.log("Admin nhận realtime:", event);

            const userId = Number(event.userFromID);

            if (userId === Number(authUserId)) {
                return;
            }

            const chatKey = [authUserId, userId]
                .sort((a, b) => a - b)
                .join("-");

            const newMessage = {
                id: Date.now(),
                userFromId: userId,
                userToId: Number(event.userToID),
                message: event.message,

                time: new Date().toLocaleTimeString("vi-VN", {
                    hour: "2-digit",
                    minute: "2-digit",
                }),

                isAdmin: false,
            };

            if (!chatData[chatKey]) {
                chatData[chatKey] = {
                    userId: userId,
                    name: event.userFromName || `Khách hàng ${userId}`,
                    messages: [],
                };
            }

            chatData[chatKey].messages.push(newMessage);

            updateConversationSidebar(chatKey, chatData[chatKey], newMessage);

            if (currentChatKey === chatKey) {
                appendMessage(newMessage);
            }
        },
    );
}

document.querySelectorAll(".chat-item").forEach((item) => {
    item.addEventListener("click", function () {
        openChat(this.dataset.chatKey);
    });
});

backToChats.addEventListener("click", showChatSidebar);

sendBtn.addEventListener("click", sendMessage);

messageInput.addEventListener("keydown", function (event) {
    if (event.key === "Enter" && !event.shiftKey) {
        event.preventDefault();

        sendMessage();
    }
});

window.addEventListener("load", initMessageRealtime);

if (currentChatKey && window.innerWidth >= 768) {
    openChat(currentChatKey);
}
