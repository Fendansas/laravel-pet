<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $event->name }}</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4">
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <div>
                <p class="text-gray-600">{{ $event->description }}</p>
            </div>

            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold">Задачи</h3>
                <a href="{{ route('tasks.create', ['event_id' => $event->id]) }}"
                   class="bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700">+ Добавить задачу</a>
            </div>

            @foreach($event->tasks as $task)
                <div class="border rounded-lg p-4">
                    <div class="flex justify-between">
                        <div>
                            <h4 class="font-semibold">{{ $task->title }}</h4>
                            <p class="text-sm text-gray-500">
                                Фракция: {{ $task->department->name ?? '—' }},
                                Исполнитель: {{ $task->assignedTo->name ?? '—' }}
                            </p>
                        </div>
                        <span class="text-xs uppercase text-gray-400">{{ $task->status }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
