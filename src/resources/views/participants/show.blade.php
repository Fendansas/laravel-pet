<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Информация о участнике</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto px-4">
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <p><strong>Имя:</strong> {{ $eventParticipant->name }}</p>
            <p><strong>Email:</strong> {{ $eventParticipant->email }}</p>
            <p><strong>Телефон:</strong> {{ $eventParticipant->phone }}</p>
            <p><strong>Должность:</strong> {{ $eventParticipant->position }}</p>
            <p><strong>Заметки:</strong> {{ $eventParticipant->notes }}</p>

            <a href="{{ route('participants.index') }}" class="text-blue-600 hover:underline">← Назад</a>
        </div>
    </div>
</x-app-layout>
