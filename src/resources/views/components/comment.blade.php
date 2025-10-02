<div class="border p-2 mt-2 ml-{{ $level * 4 }}">
    <strong>{{ $comment->user->name }}</strong>
    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
    <p>{{ $comment->content }}</p>

    @auth
        {{-- Кнопка ответить --}}
        <x-success-button onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('hidden')" class="text-sm text-blue-500">Ответить</x-success-button>

        {{-- Форма ответа --}}
        <form id="reply-form-{{ $comment->id }}" action="{{ route('comments.store', $comment->post) }}" method="POST" class="hidden mt-2">
            @csrf
            <textarea name="content" class="w-full border rounded p-2" rows="2" required></textarea>
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <x-success-button type="submit">Отправить</x-success-button>
        </form>
    @endauth

    {{-- Удаление --}}
    @if(Auth::id() === $comment->user_id || Auth::user()?->hasRole('admin'))
        <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Удалить комментарий?')">
            @csrf
            @method('DELETE')
            <x-danger-button>Удалить</x-danger-button>
        </form>
    @endif

    {{-- Дочерние комментарии --}}
    @foreach($comment->replies as $reply)
        <x-comment :comment="$reply" :level="$level+1" />
    @endforeach
</div>
