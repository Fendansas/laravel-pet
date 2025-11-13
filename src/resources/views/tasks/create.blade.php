<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Новая задача</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto px-4">
        <div class="bg-white p-6 rounded-xl shadow">
            <form method="POST" action="{{ route('tasks.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">

                <div>
                    <label class="block text-sm font-medium">Название</label>
                    <input type="text" name="title" class="w-full border rounded p-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium">Описание</label>
                    <textarea name="description" class="w-full border rounded p-2"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium">Фракция</label>
                    <select name="department_id" class="w-full border rounded p-2">
                        <option value="">— Не указано —</option>
                        @foreach($departments as $dep)
                            <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium">Исполнитель</label>
                    <select name="assigned_to" class="w-full border rounded p-2">
                        <option value="">— Не назначен —</option>
                        @foreach($participants as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Добавить задачу
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
