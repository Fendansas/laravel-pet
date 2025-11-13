<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Новое событие</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto px-4">
        <div class="bg-white p-6 rounded-xl shadow">
            <form method="POST" action="{{ route('events.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium">Название</label>
                    <input type="text" name="name" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Описание</label>
                    <textarea name="description" class="w-full border rounded p-2"></textarea>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Создать</button>
            </form>
        </div>
    </div>
</x-app-layout>
