<div class="min-h-screen ">
    <div class="container px-4 py-16 mx-auto md:py-20">

        {{-- Título de la sección con clases para la animación --}}
        <div class="max-w-3xl mx-auto mb-12 text-center">
            <p class="mb-3 text-sm font-mono tracking-widest text-amber-400 uppercase title-subtitle">
                // Catálogo de
            </p>
            <h1 class="text-4xl font-extrabold leading-tight md:text-5xl text-white title-main">
                Stickers
            </h1>
        </div>

        {{-- Buscador (sin clases de animación) --}}
        <div class="relative max-w-lg mx-auto mb-12">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Buscar por nombre..."
                class="w-full px-5 py-3 pl-12 text-white bg-gray-800 border-2 border-transparent rounded-full shadow-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >
            <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <div wire:loading class="absolute inset-y-0 right-0 flex items-center pr-4">
                <svg class="w-5 h-5 text-indigo-400 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>

        {{-- Grid responsive para las tarjetas --}}
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse ($disenos as $sticker)
                {{-- Tarjeta (sin clases de animación) --}}
                <div>
                    <x-sticker-card :sticker="$sticker" />
                </div>
            @empty
                <div class="col-span-full p-12 text-center bg-gray-800 rounded-lg">
                    <p class="text-xl font-semibold text-white">No se encontraron resultados</p>
                    @if($search)
                        <p class="mt-2 text-gray-400">Intenta con otra palabra clave para "{{ $search }}"</p>
                    @else
                         <p class="mt-2 text-gray-400">Aún no hay stickers en el catálogo.</p>
                    @endif
                </div>
            @endforelse
        </div>

        {{-- Paginación --}}
        <div class="mt-12">
            {{ $disenos->onEachSide(1)->links() }}
        </div>
    </div>
</div>
