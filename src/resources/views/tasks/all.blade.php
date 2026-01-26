<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Все задачи
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 lg:px-8">
        <div class="bg-white p-6 rounded-xl shadow space-y-4">


            <form method="POST" action="{{ route('tasks.bulk') }}">
                @csrf

                <div class="flex flex-wrap gap-2 items-center mb-4 bg-gray-50 p-3 rounded-lg">
                    <select name="action" required class="border rounded p-2">
                        <option value="">— Действие —</option>
                        <option value="status">Изменить статус</option>
                        <option value="assign">Назначить исполнителя</option>
                        <option value="department">Назначить фракцию</option>
                        <option value="delete">Удалить</option>
                    </select>

                    <select name="status" class="border rounded p-2">
                        <option value="">— Статус —</option>
                        <option value="not_assigned">Не назначена</option>
                        <option value="assigned">Назначена</option>
                        <option value="in_progress">В работе</option>
                        <option value="completed">Завершена</option>
                    </select>

                    <select name="assigned_to" class="border rounded p-2">
                        <option value="">— Исполнитель —</option>
                        @foreach($participants as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>

                    <select name="department_id" class="border rounded p-2">
                        <option value="">— Фракция —</option>
                        @foreach($departments as $dep)
                            <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                        @endforeach
                    </select>

                    <button type="submit"
                            onclick="return confirm('Применить массовое действие?')"
                            class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Применить
                    </button>
                </div>

                {{-- СПИСОК ЗАДАЧ --}}
                <div class="space-y-3">
                    @foreach($tasks as $task)
                        <a href="{{ route('tasks.show', $task->id) }}" class="hover:bg-gray-50" >
                            <div class="border rounded-lg p-4 flex gap-3 items-start">

                                <input type="checkbox"
                                       name="task_ids[]"
                                       value="{{ $task->id }}"
                                       class="mt-1">

                                <div class="flex-1">
                                    <h3 class="font-semibold">{{ $task->title }}</h3>

                                    <p class="text-sm text-gray-500">
                                        Фракция: {{ $task->department->name ?? '—' }}
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        Исполнитель: {{ $task->assignedTo->name ?? 'Не назначен' }}
                                    </p>
                                </div>

                                <span class="text-xs text-gray-400 uppercase">
                                {{ $task->status }}
                            </span>
                            </div>
                        </a>
                    @endforeach
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
