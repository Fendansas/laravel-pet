<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Дополнительная информация</h2>
        <p class="mt-1 text-sm text-gray-600">Дата рождения, город и страна.</p>
    </header>

    <form method="POST"
          action="{{ $profile->exists ? route('user-profile.update') : route('user-profile.store') }}"
          class="mt-6 space-y-6">
        @csrf
        @if($profile->exists)
            @method('PUT')
        @endif

        <div>
            <x-input-label for="date_of_birth" value="Дата рождения" />
            <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full"
                          :value="old('date_of_birth', optional($profile->date_of_birth)->format('Y-m-d'))" />
            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="city" value="Город" />
            <x-text-input id="city" name="city" type="text" class="mt-1 block w-full"
                          :value="old('city', $profile->city)" />
            <x-input-error :messages="$errors->get('city')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="country" value="Страна" />
            <x-text-input id="country" name="country" type="text" class="mt-1 block w-full"
                          :value="old('country', $profile->country)" />
            <x-input-error :messages="$errors->get('country')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-primary-button>Сохранить</x-primary-button>
        </div>
    </form>
</section>
