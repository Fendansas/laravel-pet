<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Назначить роли пользователю: {{ $user->name }}</h2>
    </x-slot>


    <div class="py-12 max-w-4xl mx-auto">


        <form method="POST" action="{{ route('admin.users.role.update', $user) }}"" class="space-y-6">
            @csrf
            @method('PUT')


            <div>
                <h3 class="font-bold mb-2">Роли</h3>


                @foreach($roles as $role)
                    <label class="flex items-center space-x-2 mb-1">
                        <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                            @checked($user->roles->contains($role))>
                        <span>{{ $role->label ?? $role->name }}</span>
                    </label>
                @endforeach
            </div>


            <button class="px-4 py-2 bg-blue-600 text-white rounded">Сохранить</button>
        </form>


    </div>
</x-app-layout>
