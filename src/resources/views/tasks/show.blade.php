<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Задача: {{ $task->title }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto px-4">
        <div class="bg-white p-6 rounded-xl shadow space-y-4">

            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold">Информация о задаче</h3>

                <a href="{{ route('tasks.edit', $task->id) }}"
                   class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                    ✏️ Редактировать
                </a>
            </div>

            <div class="border p-4 rounded-lg space-y-2">
                <p><strong>Название:</strong> {{ $task->title }}</p>

                <p><strong>Описание:</strong><br>
                    {{ $task->description ?? '—' }}
                </p>

                <p><strong>Фракция:</strong>
                    {{ $task->department->name ?? '—' }}
                </p>

                <p><strong>Исполнитель:</strong>
                    {{ $task->assignedTo->name ?? 'Не назначен' }}
                </p>

                <p><strong>Статус:</strong>
                    <span class="px-2 py-1 text-xs bg-gray-200 rounded">
                        {{ $task->status }}
                    </span>
                </p>

                <p><strong>Дедлайн:</strong>
                    {{ $task->deadline ? $task->deadline->format('d.m.Y H:i') : '—' }}
                </p>

                <p><strong>Событие:</strong>
                    <a href="{{ route('events.show', $task->event_id) }}"
                       class="text-blue-600 hover:underline">
                        {{ $task->event->name }}
                    </a>
                </p>
            </div>

            <form action="{{ route('tasks.destroy', $task->id) }}"
                  method="POST"
                  onsubmit="return confirm('Удалить задачу?');">
                @csrf
                @method('DELETE')

                <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    🗑 Удалить задачу
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
