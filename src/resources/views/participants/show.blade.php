<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Информация о участнике</h2>
    </x-slot>
    <div class="py-6 max-w-3xl mx-auto px-4">
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <p><strong>Имя:</strong> {{ $participant->name }}</p>
            <p><strong>Email:</strong> {{ $participant->email }}</p>
            <p><strong>Телефон:</strong> {{ $participant->phone }}</p>
            <p><strong>Должность:</strong> {{ $participant->position }}</p>
            <p><strong>Заметки:</strong> {{ $participant->notes }}</p>

            <a href="{{ route('participants.index') }}" class="text-blue-600 hover:underline">← Назад</a>
        </div>
        <form method="GET" class="mb-4">
            <label class="font-semibold">Фильтр по статусу:</label>
            <select name="status" class="border rounded p-2">
                <option value="">Все</option>
                <option value="not_assigned" @selected($status == 'not_assigned')>Не назначена</option>
                <option value="assigned" @selected($status == 'assigned')>Назначена</option>
                <option value="in_progress" @selected($status == 'in_progress')>В работе</option>
                <option value="completed" @selected($status == 'completed')>Завершена</option>
            </select>
            <button class="bg-blue-600 text-white px-3 py-1 rounded">Фильтровать</button>
        </form>
        @if($tasks->count())
            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-lg font-semibold mb-3">Задачи участника:</h3>

                <ul class="space-y-2">
                    @foreach($tasks as $task)
                        <li class="border p-3 rounded">
                            <strong>{{ $task->title }}</strong><br>
                            <span class="text-sm text-gray-600">Статус: {{ $task->status }}</span><br>
                            <span class="text-sm">Событие: {{ $task->event->title ?? '—' }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <p class="text-gray-600">Нет задач по выбранному фильтру.</p>
        @endif

    </div>
</x-app-layout>
