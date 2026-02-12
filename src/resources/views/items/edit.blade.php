<x-app-layout>

    <form method="POST"
          action="{{ route('items.update',$item->id) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

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
