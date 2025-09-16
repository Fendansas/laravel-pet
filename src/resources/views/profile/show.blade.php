<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Профиль пользователя') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Основная информация</h3>
                <p><strong>Имя:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
            </div>

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Дополнительная информация</h3>
                <p><strong>Дата рождения:</strong> {{ $profile->date_of_birth ?? 'Не указано' }}</p>
                <p><strong>Город:</strong> {{ $profile->city ?? 'Не указано' }}</p>
                <p><strong>Страна:</strong> {{ $profile->country ?? 'Не указано' }}</p>
                <p><strong>Статус:</strong> {{ $profile->status_message ?? 'Не указано' }}</p>
                @if($profile->avatar)
                    <img src="{{ asset('storage/' . $profile->avatar) }}" class="w-32 h-32 rounded-full mt-4">
                @endif
            </div>

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <a href="{{ route('user-profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Редактировать профиль
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
