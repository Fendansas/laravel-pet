<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Мои фотографии</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

        {{-- Форма загрузки --}}
        <form action="{{ route('user-photos.store') }}" method="POST" enctype="multipart/form-data" class="mb-6">
            @csrf
            <label class="block mb-2 font-medium">Загрузить фотографии:</label>
            <input type="file" name="photos[]" multiple accept="image/*"
                   class="block w-full border rounded p-2 mb-4">

            <x-primary-button>Загрузить</x-primary-button>
        </form>

        {{-- Галерея --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4" x-data="{ open: false, img: '' }">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($photos as $photo)
                    <div class="relative photo-size group">
                        <img src="{{ asset('storage/'.$photo->path) }}"
                             alt="photo"
                             class="w-full h-64 object-cover rounded-lg cursor-pointer hover:opacity-80 transition"
                             @click="open = true; img = '{{ asset('storage/'.$photo->path) }}'">

                        <form action="{{ route('user-photos.destroy', $photo) }}"
                              method="POST"
                              class="absolute top-2 left-2 z-10"
                              onsubmit="return confirm('Вы действительно хотите удалить это фото?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-lg shadow-md hover:bg-red-700 transition">
                                ✕
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            {{-- Модальное окно увеличенного фото --}}
            <div x-show="open" @click="open = false"
                 class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50">
                <img :src="img" class="max-h-full max-w-full rounded-lg">
            </div>
        </div>
        </div>
    </div>
</x-app-layout>
