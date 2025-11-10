<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Чат') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Сообщения -->
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Сообщения</h3>
                <div id="messages" class="h-96 overflow-y-auto border rounded p-4 space-y-2 bg-gray-50"></div>
            </div>

            <!-- Форма отправки -->
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <form id="chat-form" class="flex space-x-2">
                    <input type="text" id="message" placeholder="Напишите сообщение..."
                           class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Отправить
                    </button>
                </form>
            </div>

        </div>
    </div>

    <script>
        const form = document.getElementById('chat-form');
        const input = document.getElementById('message');
        const messages = document.getElementById('messages');
        const recipientId = {{ $recipientId ?? 'null' }};

        function appendMessage(user, message) {
            const div = document.createElement('div');
            div.classList.add('p-2', 'rounded', 'bg-white', 'shadow-sm');
            div.innerHTML = `<strong>${user}:</strong> ${message}`;
            messages.appendChild(div);
            messages.scrollTop = messages.scrollHeight;
        }

        // 🟢 Загружаем историю сообщений при открытии чата
        async function loadMessages() {
            if (!recipientId) return;

            try {
                const response = await fetch(`/chat/${recipientId}`);
                const data = await response.json();

                messages.innerHTML = ''; // очистим старые
                data.messages.forEach(msg => {
                    appendMessage(msg.sender.name, msg.message);
                });
            } catch (err) {
                console.error('Ошибка загрузки сообщений:', err);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadMessages(); // ← вот это ключевая строка

            const waitForEcho = setInterval(() => {
                if (window.Echo) {
                    clearInterval(waitForEcho);
                    console.log('Echo подключён, слушаем канал chat...');

                    window.Echo.private(`chat.${recipientId}`)
                        .listen('MessageSent', (e) => {
                            appendMessage(e.message.sender.name, e.message.message);
                        });
                }
            }, 500);
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const msg = input.value.trim();
            if (!msg) return;

            try {
                await fetch('/chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        recipient_id: recipientId,
                        message: msg
                    })
                });
                input.value = '';
                appendMessage('Вы', msg); // можно добавить локально
            } catch (err) {
                console.error('Ошибка отправки сообщения:', err);
            }
        });
    </script>
</x-app-layout>
