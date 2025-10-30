<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Лента новостей') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Основное изменение здесь: на мобильных grid-cols-1 (вертикально), на больших экранах grid-cols-12 (горизонтально) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- Левая колонка (меню) - на мобильных первая, на десктопе слева -->
                <aside class="lg:col-span-3 order-1 lg:order-1">
                    <div class="bg-white shadow-md rounded-2xl p-4">
                        <nav class="space-y-2">
                            <a href="{{ route('posts.index') }}" class="block p-2 rounded-lg hover:bg-gray-100 font-medium">
                                📰 Новости
                            </a>
                            <a href="{{ route('user-profile.edit') }}" class="block p-2 rounded-lg hover:bg-gray-100 font-medium">
                                👤 Мой профиль
                            </a>
                            <a href="{{ route('users.index') }}" class="block p-2 rounded-lg hover:bg-gray-100 font-medium">
                                👥 Пользователи
                            </a>
                            <a href="{{ route('deposit') }}" class="block p-2 rounded-lg hover:bg-gray-100 font-medium">
                                💰 Баланс
                            </a>
                            <a href="{{ route('profile.edit') }}" class="block p-2 rounded-lg hover:bg-gray-100 font-medium">
                                ⚙️ Настройки
                            </a>
                        </nav>
                    </div>
                </aside>

                <!-- Центральная колонка (лента постов) - на мобильных вторая, на десктопе в центре -->
                <main class="lg:col-span-6 space-y-6 order-3 lg:order-2">
                    @forelse($posts as $post)
                        <div class="bg-white shadow-md rounded-2xl overflow-hidden hover:shadow-lg transition">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $post->title }}
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            Автор: {{ $post->user->name }}
                                        </p>
                                    </div>
                                    <p class="text-xs text-gray-400">
                                        {{ $post->created_at->diffForHumans() }}
                                    </p>
                                </div>

                                <p class="text-gray-700 leading-relaxed">
                                    {{ Str::limit($post->content, 200) }}
                                </p>

                                <div class="mt-4">
                                    <x-link-button href="{{ route('posts.show', $post) }}">
                                        Читать далее →
                                    </x-link-button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white shadow-md rounded-2xl p-6 text-center text-gray-500">
                            Постов пока нет
                        </div>
                    @endforelse

                    <div class="mt-6">
                        {{ $posts->onEachSide(1)->links() }}
                    </div>
                </main>

                <!-- Правая колонка (профиль + темы) - на мобильных третья, на десктопе справа -->
                <aside class="lg:col-span-3 space-y-6 order-2 lg:order-3">
                    <!-- Блок профиля -->
                    <div class="bg-white shadow-md rounded-2xl p-4">
                        <h3 class="font-semibold mb-3">Ваш профиль</h3>
                        <div class="flex items-center gap-3">
                            <div class="w-14 h-14 rounded-full overflow-hidden border">
                                @if(auth()->user()->profile && auth()->user()->profile->avatar)
                                    <img src="{{ asset('storage/'.auth()->user()->profile->avatar) }}"
                                         alt="avatar"
                                         class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('images/default-avatar.png') }}"
                                         alt="avatar"
                                         class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Блок популярных тем -->
                    <div class="bg-white shadow-md rounded-2xl p-4">
                        <h3 class="font-semibold mb-3">Популярные темы</h3>
                        <div class="flex flex-wrap gap-2">
                            @forelse($topics as $topic)
                                <a href="{{ route('posts.index', ['topic_id' => $topic->id]) }}"
                                   class="px-3 py-1 text-sm bg-blue-50 text-blue-600 rounded-full hover:bg-blue-100 transition">
                                    #{{ $topic->name }}
                                </a>
                            @empty
                                <p class="text-gray-500 text-sm">Темы пока не добавлены</p>
                            @endforelse
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
