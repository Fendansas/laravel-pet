<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Подписки пользователя {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @forelse($followings as $followed)
                <div class="bg-white shadow-sm rounded-lg p-4 flex items-center space-x-4">
                    <img src="{{ $followed->profile->avatarUrl ?? asset('images/default-avatar.png') }}"
                         alt="avatar" class="w-12 h-12 rounded-full">
                    <div>
                        <a href="{{ route('users.show', $followed) }}" class="text-lg font-semibold hover:underline">
                            {{ $followed->name }}
                        </a>
                        <p class="text-gray-500 text-sm">{{ $followed->profile->status_message ?? '' }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-600">Вы пока ни на кого не подписаны.</p>
            @endforelse

            <div>{{ $followings->links() }}</div>
        </div>
    </div>
</x-app-layout>
