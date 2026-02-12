<x-app-layout>

    <div class="max-w-3xl mx-auto py-6">

        <h1 class="text-xl font-bold">{{ $item->title }}</h1>

        @if($item->image)
            <img src="{{ asset('storage/'.$item->image) }}" class="w-64 my-4">
        @endif

        <p>{{ $item->description }}</p>

        <p>Фракция: {{ $item->department->name ?? '—' }}</p>

        <p>Цена: {{ $item->price }}</p>

        <div class="flex gap-2 mt-4">

            @can('update',$item)
                <a href="{{ route('items.edit',$item->id) }}"
                   class="bg-blue-600 text-white px-3 py-1 rounded">
                    Редактировать
                </a>
            @endcan

            @can('delete',$item)
                <form method="POST" action="{{ route('items.destroy',$item->id) }}">
                    @csrf
                    @method('DELETE')

                    <button class="bg-red-600 text-white px-3 py-1 rounded">
                        Удалить
                    </button>

                </form>
            @endcan

        </div>

    </div>

</x-app-layout>
