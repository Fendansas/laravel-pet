<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">{{$user->name}} фотографии</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">


        {{-- Галерея --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4" x-data="{ open: false, img: '' }">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($photos as $photo)
                    <div class="relative photo-size group">
                        <img src="{{ asset('storage/'.$photo->path) }}"
                             alt="photo"
                             class="w-full h-64 object-cover rounded-lg cursor-pointer hover:opacity-80 transition"
                             @click="open = true; img = '{{ asset('storage/'.$photo->path) }}'">
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
