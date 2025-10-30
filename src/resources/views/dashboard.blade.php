<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Лента новостей') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <!-- сетка -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- Левая колонка (меню) -->
                <div class="lg:col-span-3 bg-white p-4 rounded-xl shadow">
                    <nav class="space-y-2">
                        <a href="{{ route('posts.index') }}" class="block p-2 rounded hover:bg-gray-100 font-medium">
                            📰 Новости
                        </a>
                        <a href="{{ route('user-profile.edit') }}" class="block p-2 rounded hover:bg-gray-100 font-medium">
                            👤 Мой профиль
                        </a>
                        <a href="{{ route('users.index') }}" class="block p-2 rounded hover:bg-gray-100 font-medium">
                            👥 Пользователи
                        </a>
                        <a href="{{ route('deposit') }}" class="block p-2 rounded hover:bg-gray-100 font-medium">
                            💰 Баланс
                        </a>
                        <a href="{{ route('profile.edit') }}" class="block p-2 rounded hover:bg-gray-100 font-medium">
                            ⚙️ Настройки
                        </a>
                    </nav>
                </div>

                <!-- Центральная колонка (лента постов) -->
                <div class="lg:col-span-6 space-y-4">
                    @foreach($posts as $post)
                        <div class="bg-white p-4 rounded-xl shadow">
                            <div class="flex justify-between items-center mb-2">
                                <div>
                                    <h3 class="font-semibold text-lg">{{ $post->title }}</h3>
                                    <p class="text-sm text-gray-500">Автор: {{ $post->user->name }}</p>
                                </div>
                                <p class="text-xs text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                            <p class="text-gray-700">{{ Str::limit($post->content, 200) }}</p>

                            <div class="mt-3">
                                <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:underline text-sm">
                                    Читать далее →
                                </a>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-6">
                        {{ $posts->links() }}
                    </div>
                </div>

                <!-- Правая колонка (виджеты) -->
                <div class="lg:col-span-3 space-y-4">
                    <div class="bg-white p-4 rounded-xl shadow">
                        <h3 class="font-semibold mb-2">Ваш профиль</h3>
                        <p>{{ auth()->user()->name }}</p>
                        <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                    </div>

                    <div class="bg-white p-4 rounded-xl shadow">
                        <h3 class="font-semibold mb-2">Популярные темы</h3>
                        @foreach($topics as $topic)
                            <a href="{{ route('posts.index', ['topic_id' => $topic->id]) }}"
                               class="block text-sm text-blue-600 hover:underline">
                                #{{ $topic->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
