<div x-data="{ selectedTab: 'info', showColorModal: false }" x-on:color-saved.window="showColorModal = false" class="max-w-4xl mx-auto space-y-4">

    <div class="w-full">
        <div x-on:keydown.right.prevent="$focus.wrap().next()" x-on:keydown.left.prevent="$focus.wrap().previous()"
            class="flex gap-2 overflow-x-auto border-b border-neutral-300 dark:border-neutral-700" role="tablist"
            aria-label="Opciones de Diseño">

            <button x-on:click="selectedTab = 'info'" :aria-selected="selectedTab === 'info'"
                :tabindex="selectedTab === 'info' ? '0' : '-1'"
                :class="selectedTab === 'info' ?
                    'font-bold text-indigo-600 border-b-2 border-indigo-600 dark:border-indigo-400 dark:text-indigo-400' :
                    'text-neutral-600 font-medium dark:text-neutral-300 dark:hover:border-b-neutral-300 dark:hover:text-white hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900'"
                class="h-min px-4 py-2 text-sm" type="button" role="tab">
                Información General
            </button>

            <button x-on:click="selectedTab = 'imagenes'" :aria-selected="selectedTab === 'imagenes'"
                :tabindex="selectedTab === 'imagenes' ? '0' : '-1'"
                :class="selectedTab === 'imagenes' ?
                    'font-bold text-indigo-600 border-b-2 border-indigo-600 dark:border-indigo-400 dark:text-indigo-400' :
                    'text-neutral-600 font-medium dark:text-neutral-300 dark:hover:border-b-neutral-300 dark:hover:text-white hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900'"
                class="h-min px-4 py-2 text-sm" type="button" role="tab">
                Imagenes
            </button>

            <button x-on:click="selectedTab = 'descripciones'" :aria-selected="selectedTab === 'descripciones'"
                :tabindex="selectedTab === 'descripciones' ? '0' : '-1'"
                :class="selectedTab === 'descripciones' ?
                    'font-bold text-indigo-600 border-b-2 border-indigo-600 dark:border-indigo-400 dark:text-indigo-400' :
                    'text-neutral-600 font-medium dark:text-neutral-300 dark:hover:border-b-neutral-300 dark:hover:text-white hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900'"
                class="h-min px-4 py-2 text-sm" type="button" role="tab">
                Descripciones
            </button>
        </div>
    </div>

    <div x-cloak x-show="selectedTab === 'info'" role="tabpanel" aria-label="Información General">
        <form wire:submit="save"
            class="space-y-6 max-w-2xl mx-auto p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg dark:shadow-xl dark:shadow-gray-900">

            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">
                Crear Nuevo Producto
            </h2>
            <hr class="dark:border-gray-700">

            <div class="flex flex-col gap-1">
                <label for="nombre">Nombre del producto:</label>
                <x-input type="text" id="nombre" wire:model="nombre" placeholder="Tarro de 15 oz" />
                <x-input-error for="nombre" />
            </div>

            <div class="flex flex-col gap-1">
                <label for="descripcion">Descripción</label>
                <x-textarea id="descripcion" wire:model="descripcion" rows="3"></x-textarea>
                <x-input-error for="descripcion" />
            </div>

            <div class="flex flex-col gap-1">
                <label for="categoria">Categoria:</label>
                <x-select id="categoria" wire:model.change="categoria">
                    <option value="" disabled>Seleccione una categoria</option>
                    @forelse ($categorias as $item)
                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                    @empty
                        <option value="0" disabled>No hay registros</option>
                    @endforelse
                </x-select>
                <x-input-error for="categoria" />
            </div>

            <div class="flex flex-col gap-1">
                <label for="subcategoria">Subcategoria:</label>
                <x-select id="subcategoria" wire:model="subcategoria">
                    <option value="" disabled>Seleccione una subcategoria</option>
                    @forelse ($subcategorias as $item)
                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                    @empty
                        <option value="0" disabled>No hay registros</option>
                    @endforelse
                </x-select>
                <x-input-error for="subcategoria" />
            </div>

            <div class="grid grid-col1 md:grid-cols-2 gap-3">
                <div class="flex flex-col gap-1">
                    <label for="unidad">Unidad:</label>
                    <x-select id="unidad" wire:model="unidad">
                        <option value="" disabled>Seleccione un unidad</option>
                        @forelse ($unidades as $item)
                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                        @empty
                            <option value="0" disabled>No hay registros</option>
                        @endforelse
                    </x-select>
                    <x-input-error for="unidad" />
                </div>
                <div class="flex flex-col gap-1">
                    <label for="stock">Stock:</label>
                    <x-input type="number" wire:model="stock" placeholder="Eje. 15" />
                    <x-input-error for="stock" />
                </div>
            </div>

            <div class="grid grid-col1 md:grid-cols-2 gap-3">
                <div class="flex flex-col gap-1">
                    <label for="precio_costo">Precio costo(MXN)</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <x-input type="number" wire:model="precio_costo" placeholder="0.00" class="w-full" />
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <span class="text-gray-500 dark:text-gray-400 sm:text-sm" id="price-currency">MXN</span>
                        </div>
                    </div>
                    <x-input-error for="precio_costo" />
                </div>

                <div class="flex flex-col gap-1">
                    <label for="precio_venta">Precio venta(MXN)</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <x-input type="number" wire:model="precio_venta" placeholder="0.00" class="w-full" />
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <span class="text-gray-500 dark:text-gray-400 sm:text-sm" id="price-currency">MXN</span>
                        </div>
                    </div>
                    <x-input-error for="precio_venta" />
                </div>
            </div>
            <div x-data="{ toggled: @entangle('vendible_sin_personalizar') }" class="flex items-center space-x-4">

                <label id="toggle-label" @click="$refs.toggleButton.click(); $refs.toggleButton.focus()">
                    ¿Vendible sin personalizar?
                </label>

                <button type="button" x-ref="toggleButton" @click="toggled = !toggled"
                    :class="toggled ? 'bg-indigo-600' : 'bg-gray-200'"
                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    role="switch" :aria-checked="toggled.toString()" aria-labelledby="toggle-label">

                    <span class="sr-only">Activar/Desactivar</span>

                    <span :class="toggled ? 'translate-x-5' : 'translate-x-0'"
                        class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out">
                    </span>
                </button>
                <span class="text-sm text-gray-600" x-text="toggled ? 'Sí' : 'No'"></span>
            </div>

            <div class="flex justify-end pt-4 border-t dark:border-gray-700">
                <button type="submit" wire:loading.attr="disabled" wire:target="save"
                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 dark:bg-indigo-500 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50">

                    <span wire:loading.remove wire:target="save">
                        Guardar Producto
                    </span>
                    <span wire:loading wire:target="save">
                        Guardando...
                    </span>
                </button>
            </div>
        </form>
    </div>

    <div x-cloak x-show="selectedTab === 'imagenes'" role="tabpanel" aria-label="Imagenes">
        <div class="w-full flex justify-end mb-3">
            <x-button type="button" wire:click="newImage">Nuevo</x-button>
        </div>
        <x-table.table>
            <x-slot name="titles">
                <x-table.th>Imagen</x-table.th>
                <x-table.th class="text-center">Acciones</x-table.th>
            </x-slot>
            <x-slot name="rows">
                @forelse ($imagenes as $index => $item)
                    <x-table.tr>
                        <x-table.td>
                            <img class="w-12 h-12 rounded-full object-cover"
                                src="{{ asset('storage/' . $item->url_imagen) }}" alt="Ejemplo">
                        </x-table.td>
                        <x-table.td-buttons>
                            <x-table.button-table tipo="edit" wire:click="editImage({{ $item->id }})" />
                            <x-table.button-table tipo="delete" wire:click="deleteImage({{ $item->id }})" />
                        </x-table.td-buttons>
                    </x-table.tr>
                @empty
                    <x-table.empty-state cols="6" message="No hay imagenes disponibles" />
                @endforelse
            </x-slot>
        </x-table.table>
        <div class="mt-3">
            {{ $imagenes->onEachSide(1)->links() }}
        </div>
    </div>

    <div x-cloak x-show="selectedTab === 'descripciones'" role="tabpanel" aria-label="Descripciones">
        <div class="w-full flex justify-end mb-3">
            <x-button type="button" wire:click="newDescrip">Nuevo</x-button>
        </div>
        <x-table.table>
            <x-slot name="titles">
                <x-table.th>Tipo produc</x-table.th>
                <x-table.th>Descripcion</x-table.th>
                <x-table.th>Precios</x-table.th>
                <x-table.th>Cantidad mayoreo</x-table.th>
                <x-table.th>Orden</x-table.th>
                <x-table.th class="text-center">Acciones</x-table.th>
            </x-slot>
            <x-slot name="rows">
                @forelse ($descripciones as $index => $item)
                    <x-table.tr>
                        <x-table.td>{{ $item->tecnicaProduc->nombre ?? 'Sin especificar' }}</x-table.td>
                        <x-table.td>{{ $item->descripcion }}</x-table.td>
                        <x-table.td>
                            <div class="flex flex-col">
                                <span>Unitario: ${{ $item->precio_unitario ?? 0.00 }} MXN</span>
                                <span>Mayoreo: ${{ $item->precio_mayoreo ?? 0.00 }} MXN</span>
                            </div>
                        </x-table.td>
                        <x-table.td>{{ $item->cantidad_mayoreo ?? '' }}</x-table.td>
                        <x-table.td>{{ $item->orden }}</x-table.td>
                        <x-table.td-buttons>
                            <x-table.button-table tipo="edit" wire:click="editDescrip({{ $item->id }})" />
                            <x-table.button-table tipo="delete" wire:click="deleteDescrip({{ $item->id }})" />
                        </x-table.td-buttons>
                    </x-table.tr>
                @empty
                    <x-table.empty-state cols="6" message="No hay descripciones disponibles" />
                @endforelse
            </x-slot>
        </x-table.table>
        <div class="mt-3">
            {{ $descripciones->onEachSide(1)->links() }}
        </div>
    </div>

    <x-dialog-modal wire:model="modalImage">
        <x-slot name="title">
            <h2 class="text-center">Imagen</h2>
        </x-slot>
        <x-slot name="content">
            <form wire:submit="saveImage">
                <div class="mb-6">
                    @if ($image)
                        <!-- Vista previa de nueva imagen -->
                        <div class="flex flex-col items-center">
                            <span class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Vista
                                Previa de Nueva Imagen</span>
                            <div class="relative group">
                                <img src="{{ $image->temporaryUrl() }}" alt="Vista previa de la nueva imagen"
                                    class="max-h-80 w-auto object-contain rounded-xl shadow-md border border-gray-200 dark:border-gray-600 p-2 bg-white dark:bg-gray-800 transition-all duration-300 group-hover:shadow-lg group-hover:scale-105">

                                <!-- Badge de nueva imagen -->
                                <div class="absolute -top-2 -right-2">
                                    <span
                                        class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full font-medium shadow-md flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Nueva
                                    </span>
                                </div>
                            </div>

                            <!-- Botón para cambiar imagen -->
                            <label
                                class="mt-4 px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 dark:bg-blue-900/20 dark:hover:bg-blue-900/30 dark:text-blue-400 rounded-lg font-medium text-sm transition-colors duration-200 flex items-center gap-2 border border-blue-200 dark:border-blue-800 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                Cambiar imagen
                                <input type="file" class="hidden" wire:model="image"
                                    accept="image/png, image/jpeg, image/webp, image/gif">
                            </label>
                        </div>
                    @elseif($existingImagePath)
                        <!-- Imagen existente -->
                        <div class="flex flex-col items-center">
                            <span class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Imagen
                                Actual</span>
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $existingImagePath) }}"
                                    alt="Imagen actual del producto"
                                    class="max-h-80 w-auto object-contain rounded-xl shadow-md border border-gray-200 dark:border-gray-600 p-2 bg-white dark:bg-gray-800 transition-all duration-300 group-hover:shadow-lg group-hover:scale-105">

                                <!-- Badge de imagen existente -->
                                <div class="absolute -top-2 -right-2">
                                    <span
                                        class="bg-gray-500 text-white text-xs px-2 py-1 rounded-full font-medium shadow-md flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Actual
                                    </span>
                                </div>

                                <!-- Overlay de acciones en hover -->
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-xl transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                    <div class="flex gap-2">
                                        <span
                                            class="bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-xs px-3 py-2 rounded-lg font-medium shadow-lg">
                                            Imagen existente
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Botón para reemplazar imagen -->
                            <label
                                class="mt-4 px-4 py-2 bg-orange-50 hover:bg-orange-100 text-orange-600 dark:bg-orange-900/20 dark:hover:bg-orange-900/30 dark:text-orange-400 rounded-lg font-medium text-sm transition-colors duration-200 flex items-center gap-2 border border-orange-200 dark:border-orange-800 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Reemplazar imagen
                                <input type="file" class="hidden" wire:model="image"
                                    accept="image/png, image/jpeg, image/webp, image/gif">
                            </label>

                            <!-- Información de la imagen existente -->
                            <div class="mt-3 text-center">
                                <p
                                    class="text-xs text-gray-500 dark:text-gray-400 flex items-center justify-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Esta es la imagen actualmente publicada
                                </p>
                            </div>
                        </div>
                    @else
                        <!-- Área de subida vacía (sin imagen existente) -->
                        <div class="flex items-center justify-center w-full">
                            <label
                                class="flex flex-col items-center justify-center w-full h-72 border-2 border-dashed rounded-2xl cursor-pointer transition-all duration-300 bg-gradient-to-br from-gray-50 to-gray-100 hover:from-blue-50 hover:to-purple-50 dark:from-gray-800 dark:to-gray-900 dark:hover:from-blue-900/20 dark:hover:to-purple-900/20 border-gray-300 dark:border-gray-600 hover:border-blue-400 dark:hover:border-blue-600 hover:shadow-lg group">

                                <div class="flex flex-col items-center justify-center pt-5 pb-6 px-4 text-center">
                                    <!-- Icono animado -->
                                    <div
                                        class="mb-4 p-3 bg-blue-100 dark:bg-blue-900/30 rounded-full group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-8 h-8 text-blue-500 dark:text-blue-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                    </div>

                                    <!-- Texto principal -->
                                    <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                                        <span
                                            class="font-semibold text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">Haz
                                            clic para subir</span>
                                        <span class="text-gray-500 dark:text-gray-500">o arrastra y suelta</span>
                                    </p>

                                    <!-- Información de formatos -->
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">
                                        PNG, JPG, WEBP, GIF (MAX. 2MB)
                                    </p>

                                    <!-- Indicador de carga visual -->
                                    <div class="w-24 h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                        <div
                                            class="h-full bg-blue-500 rounded-full w-0 group-hover:w-full transition-all duration-1000 ease-out">
                                        </div>
                                    </div>
                                </div>

                                <!-- Input de archivo -->
                                <input type="file" class="hidden" wire:model="image"
                                    accept="image/png, image/jpeg, image/webp, image/gif">
                            </label>
                        </div>

                        <!-- Información adicional -->
                        <div class="mt-3 text-center">
                            <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center justify-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                La imagen se optimizará automáticamente
                            </p>
                        </div>
                    @endif

                    <!-- Mensajes de error -->
                    @error('image')
                        <div
                            class="mt-3 flex items-center gap-2 text-red-600 dark:text-red-400 text-sm bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-lg border border-red-200 dark:border-red-800">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="flex justify-around mt-5">
                    <x-danger-button wire:click="$set('deleteModal',false)">Cancelar</x-danger-button>
                    <x-button><span wire:loading.remove wire:target="saveImage">
                            Guardar
                        </span>
                        <span wire:loading wire:target="saveImage">
                            Guardando...
                        </span>
                    </x-button>
                </div>
            </form>
        </x-slot>
        <x-slot name="footer"></x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model="modalDescrip">
        <x-slot name="title">
            <h2 class="text-center">Descripcion</h2>
        </x-slot>
        <x-slot name="content">
            <form wire:submit.prevent="saveDescrip">
                <div class="flex flex-col gap-1">
                    <label for="tecnica_produccion">Tecnica de produccion:</label>
                    <x-select id="tecnica_produccion" wire:model="tecnica_produccion">
                        <option value="" disabled>Seleccione una tecnica produccion</option>
                        @forelse ($tipos_produccion as $item)
                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                        @empty
                            <option value="0" disabled>No hay registros</option>
                        @endforelse
                    </x-select>
                    <x-input-error for="tecnica_produccion" />
                </div>
                <div class="flex flex-col gap-1">
                    <label for="descripcion_producto">Descripcion:</label>
                    <x-input wire:model="descripcion_producto" />
                    <x-input-error for="descripcion_producto" />
                </div>
                <div class="flex flex-col gap-1">
                    <label for="precio_unitario">Precio unitario:</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <x-input type="number" wire:model="precio_unitario" placeholder="0.00" class="w-full" />
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <span class="text-gray-500 dark:text-gray-400 sm:text-sm" id="price-currency">MXN</span>
                        </div>
                    </div>
                    <x-input-error for="precio_unitario" />
                </div>
                <div class="flex flex-col gap-1">
                    <label for="precio_mayoreo">Precio mayoreo:</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <x-input type="number" wire:model="precio_mayoreo" placeholder="0.00" class="w-full" />
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <span class="text-gray-500 dark:text-gray-400 sm:text-sm" id="price-currency">MXN</span>
                        </div>
                    </div>
                    <x-input-error for="precio_mayoreo" />
                </div>
                <div class="flex flex-col gap-1">
                    <label for="cantidad_mayoreo">Cantidad mayoreo:</label>
                    <x-input type="number" wire:model="cantidad_mayoreo" placeholder="Ejm. 1" class="w-full" />
                    <x-input-error for="cantidad_mayoreo" />
                </div>

                <div class="flex flex-col gap-1">
                    <label for="orden">Orden:</label>
                    <x-input type="number" wire:model="orden" placeholder="Ejm. 1" class="w-full" />
                    <x-input-error for="orden" />
                </div>

                <div class="flex justify-around mt-5">
                    <x-danger-button wire:click="$set('deleteModal',false)">Cancelar</x-danger-button>
                    <x-button>
                        <span wire:loading.remove wire:target="saveDescrip">
                            Guardar
                        </span>
                        <span wire:loading wire:target="saveDescrip">
                            Guardando...
                        </span>
                    </x-button>
                </div>
            </form>
        </x-slot>
        <x-slot name="footer"></x-slot>
    </x-dialog-modal>
</div>
