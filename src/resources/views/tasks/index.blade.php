<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Задачи события: ') . $event->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 lg:px-8">
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Список задач</h3>
                <a href="{{ route('tasks.create', ['event_id' => $event->id]) }}"
                   class="bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700">➕ Новая задача</a>
            </div>

            @foreach($tasks as $task)
                <div class="border rounded-lg p-4">
                    <div class="flex justify-between">
                        <div>
                            <h3 class="font-semibold">{{ $task->title }}</h3>
                            <p class="text-sm text-gray-500">
                                Фракция: {{ $task->department->name ?? '—' }}
                            </p>
                            <p class="text-sm text-gray-500">
                                Исполнитель: {{ $task->assignedTo->name ?? 'Не назначен' }}
                            </p>
                        </div>
                        <span class="text-xs text-gray-400 uppercase">{{ $task->status }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
