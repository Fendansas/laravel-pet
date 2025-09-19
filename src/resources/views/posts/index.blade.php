<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Посты</h2>
    </x-slot>

    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex flex-wrap gap-4">
                <x-link-button href="{{ route('posts.create') }}" >New post</x-link-button>
            </div>


        <div class="mt-6 space-y-4">
            @foreach($posts as $post)
                <div class="p-4 border rounded shadow">
                    <h3 class="text-lg font-bold">{{ $post->title }}</h3>
                    <p class="text-gray-700">{{ Str::limit($post->content, 150) }}</p>
                    <p class="text-sm text-gray-500">
                        Автор: {{ $post->user->name }} | Рейтинг: {{ $post->rating }}
                    </p>
                    <p class="text-sm text-gray-500">
                        Автор: {{ $post->user->name }}
                        @if($post->topic)
                            | Тема: {{ $post->topic->name }}
                        @endif
                        | Рейтинг: {{ $post->rating }}
                    </p>

                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
    </div>
</x-app-layout>
