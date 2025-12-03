<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Права</h2>
    </x-slot>


    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <a href="{{ route('admin.permissions.create') }}" class="text-blue-600 underline">Создать право</a>


        <div class="mt-6 space-y-4">
            @foreach($permissions as $permission)
                <div class="p-4 border rounded shadow flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold">{{ $permission->label ?? $permission->name }}</h3>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.permissions.edit', $permission) }}" class="text-blue-600">Редактировать</a>
                        <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" onsubmit="return confirm('Удалить право?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600">Удалить</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
