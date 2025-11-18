<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Создать отдел</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto px-4">
        <div class="bg-white p-6 rounded-xl shadow space-y-4">

            <form action="{{ route('departments.store') }}" method="POST">
                @csrf

                <div>
                    <label>Название</label>
                    <input type="text" name="name" class="w-full border rounded p-2" required>
                </div>

                <div>
                    <label>Тип</label>
                    <input type="text" name="type" class="w-full border rounded p-2">
                </div>

                <div>
                    <label>Цвет</label>
                    <input type="text" name="color" class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="is_active" value="1">
                        <span>Активен</span>
                    </label>
                </div>

                <div>
                    <label>Описание</label>
                    <textarea name="description" class="w-full border rounded p-2"></textarea>
                </div>

                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Создать
                </button>
            </form>

        </div>
    </div>
</x-app-layout>
