<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Список отделов</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto px-4">
        <a href="{{ route('departments.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Добавить отдел</a>

        <div class="mt-4 bg-white p-6 rounded-xl shadow">
            <table class="w-full">
                <thead>
                <tr class="border-b">
                    <th class="py-2 text-left">Название</th>
                    <th class="text-left">Тип</th>
                    <th class="text-left">Активность</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($departments as $department)
                    <tr class="border-b">
                        <td class="py-2">{{ $department->name }}</td>
                        <td>{{ $department->type }}</td>
                        <td>
                            @if($department->is_active)
                                <span class="text-green-600">Активен</span>
                            @else
                                <span class="text-gray-500">Не активен</span>
                            @endif
                        </td>
                        <td class="text-right space-x-2">
                            <a href="{{ route('departments.show', $department) }}" class="text-blue-600 hover:underline">Просмотр</a>
                            <a href="{{ route('departments.edit', $department) }}" class="text-yellow-600 hover:underline">Редактировать</a>
                            <form action="{{ route('departments.destroy', $department) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline"
                                        onclick="return confirm('Удалить отдел?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $departments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
