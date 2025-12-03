<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Редактировать роль: {{ $role->label ?? $role->name }}</h2>
    </x-slot>


    <div class="py-12 max-w-4xl mx-auto">
        <form method="POST" action="{{ route('admin.roles.update', $role) }}" class="space-y-6">
            @csrf
            @method('PUT')


            <div>
                <label class="block font-medium">Имя</label>
                <input type="text" name="name" value="{{ old('name', $role->name) }}" class="w-full border rounded p-2" required>
            </div>


            <div>
                <label class="block font-medium">Label</label>
                <input type="text" name="label" value="{{ old('label', $role->label) }}" class="w-full border rounded p-2">
            </div>


            <div>
                <h3 class="font-bold mb-2">Права роли</h3>
                @foreach($permissions as $permission)
                    <label class="flex items-center space-x-2 mb-1">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                            @checked($role->permissions->contains($permission))>
                        <span>{{ $permission->label ?? $permission->name }}</span>
                    </label>
                @endforeach
            </div>


            <button class="px-4 py-2 bg-blue-600 text-white rounded">Сохранить</button>
        </form>
    </div>
</x-app-layout>
