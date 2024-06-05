<x-app-layout>
    <x-slot name="header">
        <div class="flex gap-10 items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Procesadores') }}
            </h2>
            <x-nav-componentes />
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-10">
                @livewire('procesador.table')
            </div>
        </div>
    </div>
</x-app-layout>
