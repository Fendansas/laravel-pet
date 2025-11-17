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
            <div class="flex gap-3 mb-5">
                @php
                    $filters = [
                        '' => 'Все',
                        'not_assigned' => 'Не назначена',
                        'in_progress' => 'В процессе',
                        'completed' => 'Завершено',
                    ];
                @endphp

                @foreach($filters as $key => $label)
                    <a href="{{ url()->current() }}?status={{ $key }}"
                       class="px-4 py-2 rounded-lg border
           {{ ($status === $key || ($key === '' && $status === null))
                ? 'bg-blue-600 text-white border-blue-700'
                : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            @foreach($event->tasks as $task)
                <a href="{{ route('tasks.show', $task->id) }}" class="hover:bg-gray-50" >
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
                </a>
            @endforeach
        </div>
    </div>
</x-app-layout>
