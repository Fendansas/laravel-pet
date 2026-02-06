<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Добавить участника</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto px-4">
        <div class="bg-white p-6 rounded-xl shadow">
            <form method="POST" action="{{ route('participants.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                @include('participants.form')

                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Сохранить
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
