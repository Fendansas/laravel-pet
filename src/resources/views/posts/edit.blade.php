<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Редактировать пост</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('posts.update', $post) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block font-semibold">Заголовок</label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}" class="form-control" required>
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
                <textarea name="content" class="w-full border rounded p-2" rows="5" required>{{ old('content', $post->content) }}</textarea>
            </div>

            <x-success-button type="submit">Обновить</x-success-button>
        </form>
    </div>
</x-app-layout>
