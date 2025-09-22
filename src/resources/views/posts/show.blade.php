<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1>{{ $post->title }}</h1>
        <p>{{ $post->content }}</p>
        <p><strong>Автор:</strong> {{ $post->user->name }}</p>
        <p><strong>Тема:</strong> {{ $post->topic->name ?? 'Без темы' }}</p>
        <p><strong>Рейтинг:</strong> {{ $post->rating ?? '—' }}</p>

        @if(Auth::id() === $post->user_id || Auth::user()->hasRole('admin'))
            <x-link-button href="{{ route('posts.edit', $post) }}">Редактировать</x-link-button>
{{--            <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary">Редактировать</a>--}}

            <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline-block;"
                  onsubmit="return confirm('Вы уверены, что хотите удалить этот пост?')">
                @csrf
                @method('DELETE')
                <x-danger-button type="submit">Удалить</x-danger-button>
            </form>
        @endif
    </div>
</x-app-layout>
