<x-app-layout>

    <form method="POST" enctype="multipart/form-data"
          action="{{ route('items.store') }}"
          class="max-w-xl mx-auto py-6 space-y-4">

        @csrf

        <input name="title" placeholder="Название" class="w-full">

        <textarea name="description" placeholder="Описание"></textarea>

        <input type="file" name="image">

        <input name="price" type="number" step="0.01">

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

</x-app-layout>
