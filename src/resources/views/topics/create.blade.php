<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Создать тему</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <form method="POST" action="{{ route('topics.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block font-semibold">Название темы</label>
                <input type="text" name="name" class="w-full border rounded p-2" required>
            </div>
            <x-primary-button>Создать</x-primary-button>
{{--            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Создать</button>--}}
        </form>
    </div>
    </div>
</x-app-layout>
