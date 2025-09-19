<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Темы</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <a href="{{ route('topics.create') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">Создать тему</a>

            <div class="mt-6 space-y-4">
                @foreach($topics as $topic)
                    <div class="p-4 border rounded shadow flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold">{{ $topic->name }}</h3>
                            <p class="text-gray-500 text-sm">Slug: {{ $topic->slug }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('topics.edit', $topic) }}">
                                <x-primary-button>Редактировать</x-primary-button>
                            </a>

                            <form action="{{ route('topics.destroy', $topic) }}" method="POST"
                                  onsubmit="return confirm('Удалить тему?');">
                                @csrf
                                @method('DELETE')
                                <x-danger-button>Удалить</x-danger-button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>


            <div class="mt-4">
                {{ $topics->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
