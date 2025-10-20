@props(['sticker'])

<div x-data="{ modalOpen: false }"
    class="relative flex flex-col overflow-hidden text-white transition-transform duration-300 transform bg-gray-800 border border-gray-700 rounded-lg shadow-xl hover:scale-105">

    <div class="flex items-center justify-center p-4 bg-gray-700 aspect-square">
        <img src="{{ $sticker->img ? Storage::url($sticker->img) : asset('img/logo.webp') }}" alt="{{ $sticker->nombre }}"
            class="object-contain w-full h-full">
    </div>

    <div class="flex flex-col flex-grow p-5">
        <h3 class="text-xl font-bold tracking-tight">{{ $sticker->id }} - {{ $sticker->nombre }}</h3>

        <div class="flex items-center mt-2 text-gray-400">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 1v4m0 0h-4m4 0l-5-5"></path>
            </svg>
            <span>{{ $sticker->largo }}cm x {{ $sticker->alto }}cm</span>
        </div>

        <div class="my-4">
            <div class="flex items-center">
                <p class="text-2xl font-bold text-indigo-400">
                    $ {{ number_format($sticker->precio_unitario, 2) }}
                    <span class="text-base font-normal text-gray-400">MXN</span>
                </p>
            </div>
            @if ($sticker->precio_malloreo)
                <div class="mt-1">
                    <p class="text-sm text-gray-400">
                        Mayoreo: <span class="font-semibold text-gray-300">$
                            {{ number_format($sticker->precio_malloreo, 2) }}</span>
                    </p>
                </div>
            @endif
        </div>
        @if (!$sticker->colores)
            <div class="mt-auto">
                <button @click="modalOpen = true"
                    class="w-full px-4 py-2 text-sm font-semibold text-center text-white transition-colors duration-200 bg-indigo-600 rounded-md hover:bg-indigo-700">
                    Ver Colores
                </button>
            </div>
        @endif
    </div>

    <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-75"
        @keydown.escape.window="modalOpen = false" style="display: none;">

        <div @click.away="modalOpen = false"
            class="w-full max-w-sm p-6 mx-auto bg-gray-800 border border-gray-700 rounded-lg shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-bold text-white">Colores Disponibles</h4>
                <button @click="modalOpen = false" class="text-gray-400 hover:text-white">&times;</button>
            </div>

            <div class="grid grid-cols-3 gap-4">

                @forelse ($sticker->colores as $color)
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 border-2 border-gray-600 rounded-full"
                            style="background-color: {{ $color->hex ?? '#FFFFFF' }}"></div>
                        <span class="mt-2 text-sm text-gray-300 capitalize">{{ $color->nombre }}</span>
                    </div>
                @empty
                    <div class="col-span-3 text-center text-gray-400">
                        <p>No hay colores específicos para este sticker.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</div>
