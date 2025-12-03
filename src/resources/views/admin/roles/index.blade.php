<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Роли</h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <a href="{{ route('admin.roles.create') }}" class="text-blue-600 underline">Создать роль</a>


            <div class="mt-6 space-y-4">
                @foreach($roles as $role)
                    <div class="p-4 border rounded shadow flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold">{{ $role->label ?? $role->name }}</h3>
                            <p class="text-gray-500 text-sm">{{ $role->description }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.roles.edit', $role) }}" class="text-blue-600">Редактировать</a>
                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Удалить роль?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600">Удалить</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
