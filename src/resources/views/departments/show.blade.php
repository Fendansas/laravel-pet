<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Информация об отделе</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto px-4">
        <div class="bg-white p-6 rounded-xl shadow space-y-4">

            <p><strong>Название:</strong> {{ $department->name }}</p>
            <p><strong>Тип:</strong> {{ $department->type }}</p>
            <p><strong>Цвет:</strong> {{ $department->color }}</p>
            <p><strong>Активен:</strong> {{ $department->is_active ? 'Да' : 'Нет' }}</p>
            <p><strong>Описание:</strong> {{ $department->description }}</p>

            <a href="{{ route('departments.index') }}" class="text-blue-600 hover:underline">
                ← Назад
            </a>
        </div>
    </div>
</x-app-layout>
