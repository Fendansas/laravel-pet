<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Темы</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <a href="{{ route('topics.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Создать тему</a>

            <div class="mt-6 space-y-4">
                @foreach($topics as $topic)
                    <div class="p-4 border rounded shadow">
                        <h3 class="text-lg font-bold">{{ $topic->name }}</h3>
                        <p class="text-gray-500 text-sm">Slug: {{ $topic->slug }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $topics->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
