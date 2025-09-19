<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">UI Компоненты</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="p-6 bg-white shadow rounded-lg">
                <h3 class="text-lg font-bold mb-4">Logo</h3>
                <x-application-logo class="w-8 h-8" />
                <div class="flex flex-wrap gap-4">

                </div>
            </div>
            {{-- Кнопки --}}
            <div class="p-6 bg-white shadow rounded-lg">
                <h3 class="text-lg font-bold mb-4">Кнопки</h3>

                <div class="flex flex-wrap gap-4">
                    <x-danger-button>danger</x-danger-button>
                    <x-info-button>info</x-info-button>
                    <x-success-button>success</x-success-button>
                    <x-warning-button>warning</x-warning-button>
                    <x-secondary-button>secondary</x-secondary-button>
                </div>
            </div>

            {{-- Ссылки-кнопки --}}
            <div class="p-6 bg-white shadow rounded-lg">
                <h3 class="text-lg font-bold mb-4">Ссылки-кнопки</h3>
                <div class="flex flex-wrap gap-4">
                    <x-link-button>link</x-link-button>
                </div>
            </div>



        </div>
    </div>
</x-app-layout>
