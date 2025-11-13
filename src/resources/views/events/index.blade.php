<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">События</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4">
        <div class="bg-white p-6 rounded-xl shadow">
            <div class="flex justify-between mb-4">
                <h3 class="font-semibold text-lg">Список событий</h3>
                <a href="{{ route('events.create') }}" class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700">+ Добавить</a>
            </div>

            @foreach($events as $event)
                <div class="p-4 border-b">
                    <div class="flex justify-between">
                        <div>
                            <h3 class="font-semibold text-lg">{{ $event->name }}</h3>
                            <p class="text-gray-500">{{ $event->description }}</p>
                        </div>
                        <a href="{{ route('events.show', $event) }}" class="text-blue-600 hover:underline">Подробнее →</a>
                    </div>
                </div>
            @endforeach

            <div class="mt-4">{{ $events->links() }}</div>
        </div>
    </div>
</x-app-layout>
