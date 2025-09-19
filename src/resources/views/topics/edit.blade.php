<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Редактировать тему</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('topics.update', $topic) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium">Название</label>
                    <input type="text" name="name" value="{{ old('name', $topic->name) }}"
                           class="w-full border rounded p-2">
                    @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-primary-button type="submit">
                        Сохранить
                    </x-primary-button>

                    <a href="{{ route('topics.index') }}">
                        <x-secondary-button>Назад</x-secondary-button>
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
