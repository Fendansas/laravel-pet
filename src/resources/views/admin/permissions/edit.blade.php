<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Редактировать право: {{ $permission->name }}</h2>
    </x-slot>


    <div class="py-12 max-w-4xl mx-auto">
        <form method="POST" action="{{ route('admin.permissions.update', $permission) }}" class="space-y-6">
            @csrf
            @method('PUT')


            <div>
                <label class="block font-medium">Имя</label>
                <input type="text" name="name" value="{{ old('name', $permission->name) }}" class="w-full border rounded p-2" required>
            </div>


            <div>
                <label class="block font-medium">Label</label>
                <input type="text" name="label" value="{{ old('label', $permission->label) }}" class="w-full border rounded p-2">
            </div>


            <button class="px-4 py-2 bg-blue-600 text-white rounded">Сохранить</button>
        </form>
    </div>
</x-app-layout>
