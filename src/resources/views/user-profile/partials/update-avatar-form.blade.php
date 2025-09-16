<section class="mt-8">
    <header>
        <h2 class="text-lg font-medium text-gray-900">Аватар</h2>
        <p class="mt-1 text-sm text-gray-600">Загрузите ваш аватар.</p>
    </header>

    <form method="POST"
          action="{{ $profile->exists ? route('user-profile.update') : route('user-profile.store') }}"
          enctype="multipart/form-data"
          class="mt-6 space-y-6">
        @csrf
        @if($profile->exists)
            @method('PUT')
        @endif

        <div>
            <x-input-label for="avatar" value="Аватар" />
            <input id="avatar" name="avatar" type="file" class="mt-1 block w-full">
            @if($profile->avatar)
                <img src="{{ asset('storage/' . $profile->avatar) }}" class="mt-2 w-20 h-20 rounded-full">
            @endif
            <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-primary-button>Сохранить</x-primary-button>
        </div>
    </form>
</section>
