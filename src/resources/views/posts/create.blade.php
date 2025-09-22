<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Создать пост</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('posts.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block font-semibold">Заголовок</label>
                <input type="text" name="title" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label class="block font-semibold">Тема</label>
                <select name="topic_id" class="w-full border rounded p-2">
                    <option value="">-- Без темы --</option>
                    @foreach($topics as $topic)
                        <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Контент</label>
                <textarea name="content" class="w-full border rounded p-2" rows="5" required></textarea>
            </div>
            <x-success-button type="submit">Создать</x-success-button>
        </form>
    </div>
</x-app-layout>
