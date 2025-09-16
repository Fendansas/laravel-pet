<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Расширенный профиль') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('user-profile.partials.update-profile-info-form')
            @include('user-profile.partials.update-status-form')
            @include('user-profile.partials.update-avatar-form')
        </div>
    </div>
</x-app-layout>
