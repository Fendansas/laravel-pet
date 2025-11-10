<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Список пользователей') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Поиск -->
            <div class="mb-6 flex flex-col sm:flex-row items-center justify-between gap-3">
                <form method="GET" action="{{ route('users.index') }}" class="flex flex-wrap gap-2 w-full sm:w-auto">
                    <input
                        type="text"
                        name="name"
                        value="{{ request('name') }}"
                        placeholder="Поиск по имени..."
                        class="border rounded-lg p-2 w-full sm:w-64 focus:ring-2 focus:ring-blue-400"
                    >
                    <input
                        type="text"
                        name="city"
                        value="{{ request('city') }}"
                        placeholder="Город"
                        class="border rounded-lg p-2 w-full sm:w-48 focus:ring-2 focus:ring-blue-400"
                    >
                    <input
                        type="text"
                        name="country"
                        value="{{ request('country') }}"
                        placeholder="Страна"
                        class="border rounded-lg p-2 w-full sm:w-48 focus:ring-2 focus:ring-blue-400"
                    >
                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition"
                    >
                        🔍 Найти
                    </button>
                </form>

                @if(request()->hasAny(['name','city','country']))
                    <a href="{{ route('users.index') }}" class="text-sm text-gray-500 hover:underline">Сбросить фильтры</a>
                @endif
            </div>

            <!-- Сетка пользователей -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($users as $user)
                    <div class="bg-white shadow-md rounded-2xl overflow-hidden hover:shadow-lg transition">
                        <div class="flex flex-col items-center p-6">
                            <div class="w-[8rem] rounded-full overflow-hidden border mb-4">
                                @if($user->profile && $user->profile->avatar)
                                    <img src="{{ asset('storage/'.$user->profile->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('images/default-avatar.png') }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                @endif
                            </div>

                            <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                            @if($user->profile)
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $user->profile->city ?? 'Город не указан' }},
                                    {{ $user->profile->country ?? 'Страна не указана' }}
                                </p>
                            @endif

                            <div class="mt-4">
                                <x-link-button href="{{ route('users.show', $user) }}">Смотреть профиль</x-link-button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-10">
                        Пользователи не найдены
                    </div>
                @endforelse
            </div>

            <!-- Пагинация -->
            <div class="mt-8">
                {{ $users->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
