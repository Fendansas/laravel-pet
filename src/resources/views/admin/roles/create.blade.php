<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Создать роль</h2>
    </x-slot>


    <div class="py-12 max-w-4xl mx-auto">
        <form method="POST" action="{{ route('admin.roles.store') }}" class="space-y-6">
            @csrf


            <div>
                <label class="block font-medium">Имя (name)</label>
                <input type="text" name="name" class="w-full border rounded p-2" required>
            </div>


            <div>
                <label class="block font-medium">Label</label>
                <input type="text" name="label" class="w-full border rounded p-2">
            </div>


            <button class="px-4 py-2 bg-green-600 text-white rounded">Создать</button>
        </form>
    </div>
</x-app-layout>
