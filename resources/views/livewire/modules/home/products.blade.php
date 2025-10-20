<section id="products-index" class="py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-6 md:mb-10">
            Explora Nuestros Productos
        </h1>

        {{-- Contenedor principal de Alpine para la gestión del estado de los filtros --}}
        <div x-data="{ filtersOpen: false }" class="lg:grid lg:grid-cols-4 lg:gap-8">

            {{-- Botón para Abrir Filtros en Móviles --}}
            <div class="lg:hidden mb-6">
                <x-button @click="filtersOpen = true" <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10h18M3 16h18M3 20h18">
                    </path>
                    </svg>
                    Mostrar Filtros
                    </button>
            </div>

            {{-- Columna 1: Barra Lateral de Filtros (Alpine.js para UX móvil) --}}

            {{-- Overlay oscuro para la modal en móviles --}}
            <div x-show="filtersOpen" x-cloak class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
                @click="filtersOpen = false">
            </div>

            {{-- Contenedor de la barra lateral (se convierte en modal en móvil) --}}
            <aside class="lg:col-span-1 mb-8 lg:mb-0">
                <div x-cloak x-show="filtersOpen || window.innerWidth >= 1024"
                    @resize.window="filtersOpen = (window.innerWidth >= 1024) ? true : filtersOpen"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform -translate-x-full"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform translate-x-0"
                    x-transition:leave-end="opacity-0 transform -translate-x-full"
                    class="fixed inset-y-0 left-0 z-50 w-72 lg:w-full p-6 lg:static bg-white dark:bg-gray-800 lg:rounded-xl lg:shadow-lg overflow-y-auto">

                    {{-- Botón de Cerrar (Solo Móvil) --}}
                    <div class="flex justify-end lg:hidden mb-4">
                        <button @click="filtersOpen = false"
                            class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <h2
                        class="text-xl font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                        Filtros
                    </h2>

                    {{-- 1. Buscador Principal (Livewire) --}}
                    <div class="mb-5">
                        <label for="search">Buscar Productos</label>
                        <input type="search" id="search" wire:model.live.debounce.300ms="search"
                            placeholder="Eje. Termo"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150">
                    </div>

                    {{-- 2. Filtro de Categoría (Livewire) --}}
                    <div class="mb-5">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Categoría</h3>
                        <select wire:model.change="category"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <option value='0'>Todas las Categorías</option>
                            @foreach ($categories as $item)
                                <option value="{{ intval($item->id) }}">{{ $item->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-5" x-show="category && category != 0">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Subcategoría</h3>
                        <select wire:model.change="subcategory"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <option value="">Todas las Subcategorías</option>
                            @foreach ($subcategories as $item)
                                <option value="{{ intval($item->id) }}">{{ $item->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 3. Filtro de Marca (Livewire) --}}
                    <div class="mb-5">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Marca</h3>
                        @foreach ($brands as $item)
                            <div class="flex items-center mb-1">
                                <input id="brand-{{ $item->id }}" wire:model.change="selectedBrands" type="checkbox"
                                    value="{{ $item->id }}"
                                    class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-600">
                                <label for="brand-{{ $item->id }}"
                                    class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $item->nombre }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    {{-- 4. Otros Filtros (Modelo/Subcategoría) --}}
                    <div class="mb-5">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Modelo</h3>
                        <select wire:model="model"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <option value="">Cualquier Modelo</option>
                            {{-- ... opciones de modelos ... --}}
                        </select>
                    </div>

                    {{-- Botón para Limpiar Filtros --}}
                    <button wire:click="resetFilters" @click="filtersOpen = false" {{-- Cerrar modal después de limpiar --}}
                        class="w-full text-center bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold py-2 rounded-lg transition duration-150">
                        Limpiar Filtros
                    </button>

                </div>
            </aside>

            {{-- Columna 2: Resultados de Productos y Paginación (Livewire) --}}
            <div class="lg:col-span-3">

                {{-- Cuadrícula de Productos --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($productos as $producto)
                        <x-home.card :nombre="$producto->nombre" :descripcion="$producto->descripcion" :precio="$producto->precio" :url="$producto->url_mercado"
                            :producto="$producto->toArray()" :nuevo="$producto->created_at" />
                    @empty
                        {{-- Mensaje para cuando no hay resultados --}}
                        <div class="lg:col-span-3 text-center py-10 bg-white dark:bg-gray-800 rounded-xl shadow-lg">
                            <p class="text-xl font-semibold text-gray-700 dark:text-gray-300">
                                😥 No se encontraron productos con estos criterios.
                            </p>
                            <button wire:click="resetFilters"
                                class="mt-4 text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 transition duration-150">
                                Restablecer todos los filtros
                            </button>
                        </div>
                    @endforelse
                </div>

                {{-- Paginación --}}
                <div class="mt-8">
                    {{ $productos->links() }}
                </div>

            </div>
        </div>
    </div>
</section>
