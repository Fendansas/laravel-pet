<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Участники
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto px-4">
        @if(session('message'))
            <div class="mb-4 text-green-600">
                {{ session('message') }}
            </div>
        @endif

        <div class="flex justify-end mb-4">
            <a href="{{ route('participants.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Добавить участника
            </a>
        </div>

        <div class="bg-white shadow rounded-xl p-6">
            <table class="w-full border-collapse">
                <thead @php
                    $direction = request('direction', 'desc') === 'asc' ? 'desc' : 'asc';
                @endphp
                >
                <tr class="border-b">
                    <th class="p-3 text-left">Имя</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Телефон</th>
                    <th class="p-3 text-left">
                        <a href="{{ route('participants.index', [
                                            'sort' => 'completed_tasks_count',
                                            'direction' => $direction
                                ]) }}" class="hover:underline">
                            Выполнено задач {{ request('direction') === 'asc' ? '↑' : '↓' }}
                        </a>
                    </th>
                    <th class="p-3 text-left">
                        <a href="{{ route('participants.index', [
                                            'sort' => 'tasks_count',
                                            'direction' => $direction
                                        ]) }}" class="hover:underline">
                            Всего задач {{ request('direction') === 'asc' ? '↑' : '↓' }}
                        </a>
                    </th>
                    <th class="p-3"></th>
                </tr>
                </thead>

                <tbody>
                @foreach($participants as $p)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $p->name }}</td>
                        <td class="p-3">{{ $p->email }}</td>
                        <td class="p-3">{{ $p->phone }}</td>
                        <td class="p-3">
                            {{ $p->completed_tasks_count }}
                        </td>

                        <td class="p-3">
                            {{ $p->tasks_count }}
                        </td>
                        <td class="p-3 text-right space-x-2">
                            <a href="{{ route('participants.show', $p) }}"
                               class="text-blue-600 hover:underline">Просмотр</a>

                            <a href="{{ route('participants.edit', $p) }}"
                               class="text-yellow-600 hover:underline">Изменить</a>

                            <form action="{{ route('participants.destroy', $p) }}" method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('Удалить участника?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">
                                    Удалить
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $participants->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
