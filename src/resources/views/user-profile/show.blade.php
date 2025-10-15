<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Профиль пользователя: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center space-x-4">
                    <img src="{{ $user->profile->avatarUrl ?? asset('images/default-avatar.png') }}"
                         alt="avatar" class="w-20 h-20 rounded-full">
                    <div>
                        <h3 class="text-lg font-bold">{{ $user->name }}</h3>
                    </div>
                </div>

                <div class="mt-6">
                    <p><strong>Дата рождения:</strong> {{ $user->profile->date_of_birth?->format('Y-m-d') ?? '-' }}</p>
                    <p><strong>Город:</strong> {{ $user->profile->city ?? '-' }}</p>
                    <p><strong>Страна:</strong> {{ $user->profile->country ?? '-' }}</p>
                    <p><strong>Язык:</strong> {{ $user->profile->language ?? '-' }}</p>
                    <p><strong>Статус:</strong> {{ $user->profile->status_message ?? '-' }}</p>
                    <p><strong>Количество постов:</strong> {{ $postsCount }}</p>
                    <p><strong>Количество комментариев:</strong> {{ $commentsCount }}</p>

                    <p>
                        <a href="{{ route('user.followers', $user) }}" class="text-blue-500 hover:underline">
                            Подписчики: {{ $user->followers()->count() }}
                        </a>
                    </p>
                    <p>
                        <a href="{{ route('user.following', $user) }}" class="text-blue-500 hover:underline">
                            Подписки: {{ $user->followings()->count() }}
                        </a>
                    </p>

                    @if(Auth::check() && Auth::id() !== $user->id)
                        @if(Auth::user()->isFollowing($user))
                            <form action="{{ route('unfollow', $user) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-success-button type="submit" class="btn btn-secondary">Отписаться</x-success-button>
                            </form>
                        @else
                            <form action="{{ route('follow', $user) }}" method="POST">
                                @csrf
                                <x-warning-button type="submit" class="btn btn-primary">Подписаться</x-warning-button>
                            </form>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
