<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Редактировать участника</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto px-4">
        <div class="bg-white p-6 rounded-xl shadow">
            <form method="POST" action="{{ route('participants.update', $participant) }}" class="space-y-4">
                @csrf
                @method('PUT')

                @include('participants.form')

                <button class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                    Обновить
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
