<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Дополнительная информация профиля') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Заполните информацию о себе, которая будет отображаться в профиле.') }}
        </p>
    </header>

    <form method="POST" action="{{ $profile ? route('profile.update') : route('profile.store') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @if($profile)
            @method('PUT')
        @endif

        <!-- Дата рождения -->
        <div>
            <x-input-label for="date_of_birth" value="Дата рождения" />
            <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full"
                          :value="old('date_of_birth', $profile->date_of_birth ?? '')" />
            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
        </div>

        <!-- Город -->
        <div>
            <x-input-label for="city" value="Город" />
            <x-text-input id="city" name="city" type="text" class="mt-1 block w-full"
                          :value="old('city', $profile->city ?? '')" />
            <x-input-error :messages="$errors->get('city')" class="mt-2" />
        </div>

        <!-- Статус -->
        <div>
            <x-input-label for="status_message" value="Статус" />
            <x-text-input id="status_message" name="status_message" type="text" class="mt-1 block w-full"
                          :value="old('status_message', $profile->status_message ?? '')" />
            <x-input-error :messages="$errors->get('status_message')" class="mt-2" />
        </div>

        <!-- Аватар -->
        <div>
            <x-input-label for="avatar" value="Аватар" />
            <input id="avatar" name="avatar" type="file" class="mt-1 block w-full">
            @if($profile && $profile->avatar)
                <img src="{{ asset('storage/' . $profile->avatar) }}" class="mt-2 w-20 h-20 rounded-full">
            @endif
            <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Сохранить') }}</x-primary-button>
        </div>
    </form>
</section>
