<div class="min-h-screen ">
    <div class="container px-4 py-16 mx-auto md:py-20">

        {{-- Título de la sección con clases para la animación --}}
        <div class="max-w-3xl mx-auto mb-12 text-center">
            <p class="mb-3 text-sm font-mono tracking-widest text-amber-400 uppercase title-subtitle">
                // Catálogo de
            </p>
            <h1 class="text-4xl font-extrabold leading-tight md:text-5xl title-main">
                Stickers
            </h1>
        </div>

        {{-- Buscador (sin clases de animación) --}}
        <div class="relative max-w-lg mx-auto mb-12">
            <input type="text" wire:model.live.debounce.500ms="search" placeholder="Buscar stickers..."
                class="w-full px-5 py-3 pl-12 pr-10 text-gray-900 dark:text-white bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-full shadow-lg focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all duration-200">

            <!-- Ícono de búsqueda -->
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <!-- Indicador de carga CORREGIDO -->
            <div wire:loading.class.remove="hidden" wire:loading.class.add="flex"
                class="hidden absolute inset-y-0 right-0  items-center pr-4">
                <svg class="w-5 h-5 text-amber-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </div>
        </div>

        {{-- Grid responsive para las tarjetas --}}
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <!-- Loading spinner para búsquedas -->
            <x-loading-spinner :colspan="4" wire:target="search" />
            @forelse ($disenos as $sticker)
                <div>
                    <x-sticker-card :sticker="$sticker" />
                </div>
            @empty
                <div
                    class="col-span-full p-12 text-center bg-white rounded-xl border border-gray-200 dark:bg-gray-800/40 dark:border-gray-700/30">
                    <div class="max-w-xs mx-auto">

                        <div class="text-amber-500 dark:text-amber-400/60 mb-4">
                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                </path>
                            </svg>
                        </div>

                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            @if ($search)
                                Sin resultados
                            @else
                                Vacío
                            @endif
                        </h4>

                        @if ($search)
                            <p class="text-gray-500 dark:text-gray-400 text-sm">
                                Ningún sticker coincide con "<span
                                    class="font-medium text-amber-600 dark:text-amber-400">{{ $search }}</span>"
                            </p>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-sm">
                                No hay stickers en el catálogo
                            </p>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Paginación --}}
        <div class="mt-12">
            {{ $disenos->onEachSide(1)->links() }}
        </div>
    </div>
</div>
