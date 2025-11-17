<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактировать задачу</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto px-4">
        <div class="bg-white p-6 rounded-xl shadow">
            <form method="POST" action="{{ route('tasks.update', $task->id) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium">Название</label>
                    <input type="text" name="title" value="{{ $task->title }}" class="w-full border rounded p-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium">Описание</label>
                    <textarea name="description" class="w-full border rounded p-2">{{ $task->description }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium">Фракция</label>
                    <select name="department_id" class="w-full border rounded p-2">
                        <option value="">— Не указано —</option>
                        @foreach($departments as $dep)
                            <option value="{{ $dep->id }}" @selected($task->department_id == $dep->id)>
                                {{ $dep->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium">Исполнитель</label>
                    <select name="assigned_to" class="w-full border rounded p-2">
                        <option value="">— Не назначен —</option>
                        @foreach($participants as $p)
                            <option value="{{ $p->id }}" @selected($task->assigned_to == $p->id)>
                                {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium">Статус</label>
                    <select name="status" class="w-full border rounded p-2" required>
                        <option value="not_assigned" @selected($task->status == 'not_assigned')>Не назначена</option>
                        <option value="assigned" @selected($task->status == 'assigned')>Назначена</option>
                        <option value="in_progress" @selected($task->status == 'in_progress')>В работе</option>
                        <option value="completed" @selected($task->status == 'completed')>Завершена</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium">Дедлайн</label>
                    <input type="datetime-local" name="deadline"
                           value="{{ $task->deadline ? $task->deadline->format('Y-m-d\TH:i') : '' }}"
                           class="w-full border rounded p-2">
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Сохранить изменения
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
