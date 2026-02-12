<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold">Каталог вещей</h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto">

        @can('create', App\Models\Item::class)
            <a href="{{ route('items.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded">
                ➕ Добавить
            </a>
        @endcan

        <div class="grid grid-cols-3 gap-4 mt-6">

            @foreach($items as $item)

                <a href="{{ route('items.show',$item->id) }}"
                   class="border p-4 rounded shadow hover:bg-gray-50">

                    @if($item->image)
                        <img src="{{ asset('storage/'.$item->image) }}" class="h-40 mx-auto">
                    @endif

                    <h3 class="font-bold mt-2">{{ $item->title }}</h3>

                    <p>{{ $item->department->name ?? '—' }}</p>

                    <p class="text-green-600">{{ $item->price }}</p>

                </a>

            @endforeach

        </div>

        <div class="mt-6">
            {{ $items->links() }}
        </div>

    </div>
</x-app-layout>
