<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Подписчики пользователя {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @forelse($followers as $follower)
                <div class="bg-white shadow-sm rounded-lg p-4 flex items-center space-x-4">
                    <div class="w-[8rem] rounded-full overflow-hidden border mb-4">
                        @if($follower->profile && $follower->profile->avatar)
                            <img src="{{ asset('storage/'.$follower->profile->avatar) }}" alt="{{ $follower->name }}" class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('images/default-avatar.png') }}" alt="{{ $follower->name }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div>
                        <a href="{{ route('users.show', $follower) }}" class="text-lg font-semibold hover:underline">
                            {{ $follower->name }}
                        </a>
                        <p class="text-gray-500 text-sm">{{ $follower->profile->status_message ?? '' }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-600">Пока нет подписчиков.</p>
            @endforelse

            <div>{{ $followers->links() }}</div>
        </div>
    </div>
</x-app-layout>
