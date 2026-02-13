<x-app-layout>
    <div class="max-w-3xl mx-auto py-6">
        <form method="POST"
              action="{{ route('items.update',$item->id) }}"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input name="title" placeholder="Название" class="w-full" value="{{ old('title', $item->title) }}">

            <textarea name="description" placeholder="Описание">{{ old('description', $item->description) }}</textarea>

            @if($item->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/'.$item->image) }}"
                         class="h-32 rounded">
                </div>
            @endif

            <input type="file" name="image">

            <input name="price" required type="number" step="0.01" value="{{ old('price', $item->price) }}">

            <select name="department_id">
                <option value="">Фракция</option>
                @foreach($departments as $dep)
                    <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                @endforeach
            </select>

            <button class="bg-green-600 text-white px-4 py-2 rounded">
                Сохранить
            </button>

        </form>
    </div>

</x-app-layout>
