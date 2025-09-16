<section class="mt-8">
    <header>
        <h2 class="text-lg font-medium text-gray-900">Статус</h2>
        <p class="mt-1 text-sm text-gray-600">Ваш статус, который будет отображаться другим пользователям.</p>
    </header>

    <form method="POST"
          action="{{ $profile->exists ? route('user-profile.update') : route('user-profile.store') }}"
          class="mt-6 space-y-6">
        @csrf
        @if($profile->exists)
            @method('PUT')
        @endif

        <div>
            <x-input-label for="status_message" value="Статус" />
            <x-text-input id="status_message" name="status_message" type="text" class="mt-1 block w-full"
                          :value="old('status_message', $profile->status_message)" />
            <x-input-error :messages="$errors->get('status_message')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-primary-button>Сохранить</x-primary-button>
        </div>
    </form>
</section>
