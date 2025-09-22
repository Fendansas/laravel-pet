<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1>{{ $post->title }}</h1>
        <p>{{ $post->content }}</p>
        <p><strong>Автор:</strong> {{ $post->user->name }}</p>
        <p><strong>Тема:</strong> {{ $post->topic->name ?? 'Без темы' }}</p>
        <p><strong>Средний рейтинг:</strong> {{ number_format($post->averageRating(), 1) ?? '—' }}</p>

        @auth
            @if(!$post->userRating(Auth::id()))
                <form action="{{ route('posts.rate', $post) }}" method="POST">
                    @csrf
                    <div class="star-rating">
                        @for($i = 5; $i >= 0; $i--)
                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" />
                            <label for="star{{ $i }}">{{ $i }}★</label>
                        @endfor
                    </div>
                    <x-success-button type="submit" class="mt-2">Оценить</x-success-button>
                </form>
            @else
                <p>Вы уже поставили оценку: {{ $post->userRating(Auth::id())->rating }} ⭐</p>
            @endif
        @endauth

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
