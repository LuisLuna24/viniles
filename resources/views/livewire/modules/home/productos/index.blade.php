<div class="min-h-screen">
    <div class="container px-4 py-16 mx-auto md:py-20">

        {{-- Título de la sección --}}
        <div class="max-w-3xl mx-auto mb-12 text-center">
            <p class="mb-3 text-sm font-mono tracking-widest text-amber-400 uppercase title-subtitle">
                // Catálogo de
            </p>
            <h1 class="text-4xl font-extrabold leading-tight md:text-5xl title-main">
                Productos
            </h1>
        </div>

        {{-- Filtros y Buscador --}}
        <div class="max-w-6xl mx-auto mb-12">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">

                {{-- Buscador --}}
                <div class="flex-1 max-w-lg">
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Buscar productos..."
                            class="w-full px-5 py-3 pl-12 pr-10 text-gray-900 dark:text-white bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-full shadow-lg focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all duration-200">

                        <!-- Ícono de búsqueda -->
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>

                        <!-- Indicador de carga -->
                        <div wire:loading.class.remove="hidden" wire:loading.class.add="flex"
                            class="hidden absolute inset-y-0 right-0 items-center pr-4">
                            <svg class="w-5 h-5 text-amber-500 animate-spin" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Filtros --}}
                <div class="flex flex-wrap gap-4">

                    {{-- Filtro por Categoría --}}
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open"
                            class="flex items-center gap-2 px-4 py-3 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl shadow-lg hover:border-amber-500 hover:ring-2 hover:ring-amber-500/20 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                </path>
                            </svg>
                            <span>{{ $selectedCategory ? $categories->find($selectedCategory)?->nombre : 'Categorías' }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            class="absolute top-full left-0 mt-2 w-64 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl shadow-lg z-10 max-h-60 overflow-y-auto">
                            <div class="p-2">
                                <button wire:click="$set('selectedCategory', null)"
                                    class="w-full px-3 py-2 text-left text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 {{ !$selectedCategory ? 'text-amber-600 bg-amber-50 dark:bg-amber-900/20' : 'text-gray-700 dark:text-gray-200' }}">
                                    Todas las categorías
                                </button>
                                @foreach ($categories as $category)
                                    <button wire:click="$set('selectedCategory', {{ $category->id }})"
                                        class="w-full px-3 py-2 text-left text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 {{ $selectedCategory == $category->id ? 'text-amber-600 bg-amber-50 dark:bg-amber-900/20' : 'text-gray-700 dark:text-gray-200' }}">
                                        {{ $category->nombre }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Filtro por Subcategoría --}}
                    @if ($selectedCategory && $subcategories->isNotEmpty())
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open"
                                class="flex items-center gap-2 px-4 py-3 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl shadow-lg hover:border-amber-500 hover:ring-2 hover:ring-amber-500/20 transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                                <span>{{ $selectedSubcategory ? $subcategories->find($selectedSubcategory)?->nombre : 'Subcategorías' }}</span>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform -translate-y-2"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                class="absolute top-full left-0 mt-2 w-64 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl shadow-lg z-10 max-h-60 overflow-y-auto">
                                <div class="p-2">
                                    <button wire:click="$set('selectedSubcategory', null)"
                                        class="w-full px-3 py-2 text-left text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 {{ !$selectedSubcategory ? 'text-amber-600 bg-amber-50 dark:bg-amber-900/20' : 'text-gray-700 dark:text-gray-200' }}">
                                        Todas las subcategorías
                                    </button>
                                    @foreach ($subcategories as $subcategory)
                                        <button wire:click="$set('selectedSubcategory', {{ $subcategory->id }})"
                                            class="w-full px-3 py-2 text-left text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 {{ $selectedSubcategory == $subcategory->id ? 'text-amber-600 bg-amber-50 dark:bg-amber-900/20' : 'text-gray-700 dark:text-gray-200' }}">
                                            {{ $subcategory->nombre }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Botón limpiar filtros --}}
                    @if ($selectedCategory || $selectedSubcategory || $search)
                        <button wire:click="clearFilters"
                            class="flex items-center gap-2 px-4 py-3 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl shadow-lg hover:border-red-500 hover:text-red-600 hover:ring-2 hover:ring-red-500/20 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                            Limpiar
                        </button>
                    @endif
                </div>
            </div>

            {{-- Etiquetas de filtros activos --}}
            @if ($selectedCategory || $selectedSubcategory)
                <div class="flex flex-wrap gap-2 mt-4">
                    @if ($selectedCategory)
                        <span
                            class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium text-amber-700 bg-amber-100 dark:bg-amber-900/30 dark:text-amber-300 rounded-full">
                            {{ $categories->find($selectedCategory)?->nombre }}
                            <button wire:click="$set('selectedCategory', null)" class="hover:text-amber-900">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </span>
                    @endif

                    @if ($selectedSubcategory)
                        <span
                            class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium text-blue-700 bg-blue-100 dark:bg-blue-900/30 dark:text-blue-300 rounded-full">
                            {{ $subcategories->find($selectedSubcategory)?->nombre }}
                            <button wire:click="$set('selectedSubcategory', null)" class="hover:text-blue-900">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </span>
                    @endif
                </div>
            @endif
        </div>

        {{-- Contador de resultados --}}
        @if ($products->isNotEmpty())
            <div class="max-w-6xl mx-auto mb-6">
                <p class="text-sm text-gray-400">
                    Mostrando <span class="font-semibold text-amber-400">{{ $products->count() }}</span>
                    de <span class="font-semibold text-amber-400">{{ $products->total() }}</span> productos
                    @if ($selectedCategory || $selectedSubcategory || $search)
                        <span class="text-gray-500">(filtrados)</span>
                    @endif
                </p>
            </div>
        @endif

        {{-- Grid responsive para las tarjetas --}}
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <!-- Loading spinner para búsquedas y filtros -->
            <x-loading-spinner :colspan="4" wire:target="search,selectedCategory,selectedSubcategory" />

            @forelse ($products as $item)
                <x-product-card :slug="$item->slug" :id="$item->id" :name="$item->nombre" :description="$item->descripcion"
                    :salePrice="$item->precio_venta_base" :unit="$item->unidad->nombre" :category="$item->categoria->nombre" :image="$item->imagenes->first()?->url_imagen ?? asset('img/logo.webp')" show-category="true"
                    show-badge="true" :perso="$item->vendible_sin_personalizar" />
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
                            @if ($search || $selectedCategory || $selectedSubcategory)
                                Sin resultados
                            @else
                                Vacío
                            @endif
                        </h4>

                        @if ($search)
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">
                                Ningún producto coincide con "<span
                                    class="font-medium text-amber-600 dark:text-amber-400">{{ $search }}</span>"
                            </p>
                        @elseif($selectedCategory || $selectedSubcategory)
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">
                                No hay productos en los filtros seleccionados
                            </p>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">
                                No hay productos en el catálogo
                            </p>
                        @endif

                        @if ($search || $selectedCategory || $selectedSubcategory)
                            <button wire:click="clearFilters"
                                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg hover:bg-amber-100 dark:hover:bg-amber-900/30 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                                Limpiar filtros
                            </button>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Paginación --}}
        @if ($products->hasPages())
            <div class="mt-12">
                {{ $products->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
</div>
