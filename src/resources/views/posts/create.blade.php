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
                <label class="block font-semibold">Статус</label>
                <select name="status" class="w-full border rounded p-2">
                    <option value="draft">Черновик</option>
                    <option value="published">Опубликовать</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Дата публикации (опционально)</label>
                <input type="datetime-local" name="published_at" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Контент</label>
                <textarea name="content" class="w-full border rounded p-2" rows="5" required></textarea>
            </div>
            <x-success-button type="submit">Создать</x-success-button>
        </form>
    </div>
    <script src="https://cdn.tiny.cloud/1/9hd47l7g64xj2gvndut91allsjl2w9o9kbgmh7959m9xjtr9/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
    <script>
        tinymce.init({
            selector: 'textarea[name=content]',
            plugins: 'link image media table lists code',
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright | bullist numlist | link image media | code',
            height: 400,
            setup: function (editor) {
                // 👇 Перед отправкой формы обновляем textarea
                editor.on('change', function () {
                    tinymce.triggerSave();
                });
            }
        });

        // Дополнительно гарантируем, что при submit данные сохраняются
        document.querySelector('form').addEventListener('submit', function () {
            tinymce.triggerSave();
        });
    </script>
</x-app-layout>
