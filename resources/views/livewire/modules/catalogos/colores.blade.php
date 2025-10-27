<div>
    <section class="grid grid-cols-2 md:flex md:items-end gap-4 mb-6">
        <!-- Selector de elementos por página - Estilo mejorado -->
        <div class="flex flex-col space-y-1">
            <label for="perPage" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mostrar:</label>
            <x-select wire:model.change="perPage" id="perPage"
                class="w-full md:w-24 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
            </x-select>
        </div>

        <!-- Filtro por estatus - Estilo mejorado -->
        <div class="flex flex-col space-y-1">
            <label for="perEstatus" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estatus:</label>
            <x-select wire:model.change="perEstatus" id="perEstatus"
                class="w-full md:w-32 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                <option value="">Todos</option>
                <option value="1">Activo</option>
                <option value="2">Inactivo</option>
            </x-select>
        </div>

        <!-- Barra de búsqueda - Estilo mejorado -->
        <div class="col-span-2 md:flex-1 flex flex-col space-y-1 relative">
            <label for="search" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Buscar:</label>
            <div class="relative">
                <x-input wire:model.live.debounce.500ms="search" id="search" placeholder="Buscar por nombre..."
                    class="w-full pl-10 pr-8 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    {!! file_get_contents(public_path('svg/search.svg')) !!}
                </div>
                <button type="button"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 p-1 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors"
                    wire:click="$set('search', '')" aria-label="Limpiar búsqueda">
                    {!! file_get_contents(public_path('svg/x.svg')) !!}
                </button>
            </div>
        </div>

        <!-- Botón de nuevo registro - Estilo mejorado -->
        <div class="flex flex-col justify-end">
            <x-button wire:click="create">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                        clip-rule="evenodd" />
                </svg>
                <span>Nuevo</span>
            </x-button>
        </div>
    </section>
    <x-table.table>
        <x-slot name="titles">
            <x-table.th>No.</x-table.th>
            <x-table.th>Nombre</x-table.th>
            <x-table.th>Estatus</x-table.th>
            <x-table.th class="text-center">Acciones</x-table.th>
        </x-slot>
        <x-slot name="rows">
            @forelse ($collection as $index => $item)
                <x-table.tr>
                    <x-table.td>{{ ($collection->currentPage() - 1) * $collection->perPage() + $loop->iteration }}</x-table.td>
                    <x-table.td>{{ $item->nombre }}</x-table.td>
                    <x-table.td>
                        <x-toggle-switch :id="$item->id" :checked="$item->estatus" :disabled="true"
                            wireClick="statusRegister({{ $item->id }})" />
                    </x-table.td>
                    <x-table.td-buttons>
                        <x-table.button-table tipo="edit" wire:click="edit({{ $item->id }})" />
                        <x-table.button-table tipo="delete" wire:click="delete({{ $item->id }})" />
                    </x-table.td-buttons>
                </x-table.tr>
            @empty
                <x-table.empty-state cols="6" message="No hay registros disponibles" />
            @endforelse

        </x-slot>
    </x-table.table>
    <div class="mt-3">
        {{ $collection->onEachSide(1)->links() }}
    </div>

    <x-dialog-modal wire:model="modal">
        <x-slot name="title">
            <div class="text-center">
                <div class="flex items-center justify-center space-x-3 mb-2">
                    <div class="w-2 h-8 bg-amber-500 rounded-full"></div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $typeForm == 1 ? 'Nuevo' : 'Editar' }} Color
                    </h2>
                    <div class="w-2 h-8 bg-amber-500 rounded-full"></div>
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    {{ $typeForm == 1 ? 'Agregar un nuevo color al sistema' : 'Modificar los datos del color seleccionado' }}
                </p>
            </div>
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="submitForm" class="space-y-6">
                <!-- Nombre del Color -->
                <div class="space-y-2">
                    <label for="nombre"
                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center space-x-2">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <span>Nombre del Color</span>
                    </label>
                    <div class="relative">
                        <x-input wire:model.defer="nombre" id="nombre"
                            class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:border-amber-500 focus:ring-amber-500 transition-all duration-300"
                            placeholder="Ingresa el nombre del color" />
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                    <x-input-error for="nombre" class="mt-1" />
                </div>

                <!-- Switch Gradiente -->
                <div
                    class="bg-amber-50 dark:bg-amber-900/20 p-4 rounded-2xl border border-amber-100 dark:border-amber-800/30 transition-all duration-300">
                    <label class="flex items-center cursor-pointer space-x-3 group">
                        <div class="relative">
                            <input type="checkbox" wire:model.live="esGradiante" class="sr-only peer">
                            <div
                                class="w-12 h-6 bg-gray-300 peer-focus:ring-amber-500 peer-focus:ring-2 rounded-full peer
                                    peer-checked:after:translate-x-6 peer-checked:after:border-white after:content-['']
                                    after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300
                                    after:border after:rounded-full after:h-5 after:w-5 after:transition-all
                                    peer-checked:bg-amber-500 shadow-inner">
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 group-hover:scale-110 transition-transform duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                            </svg>
                            <span
                                class="text-lg font-semibold text-gray-700 dark:text-gray-300 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors duration-200">
                                ¿Es un gradiente?
                            </span>
                        </div>
                    </label>
                    <x-input-error for="esGradiante" class="mt-2" />
                </div>

                <!-- Contenido Condicional -->
                @if ($esGradiante == true)
                    <!-- Gradiente -->
                    <div class="space-y-4">
                        <label
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center space-x-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span>Colores del Gradiente</span>
                        </label>

                        <div class="space-y-3 max-h-60 overflow-y-auto p-2">
                            @foreach ($hex_codes_array as $index => $hex)
                                <div
                                    class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-amber-300 dark:hover:border-amber-600 transition-all duration-300 group">
                                    <div class="relative">
                                        <input type="color" wire:model.defer="hex_codes_array.{{ $index }}"
                                            class="w-12 h-12 p-0 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer transition-all duration-300 hover:scale-110 hover:border-amber-500 shadow-md">
                                    </div>

                                    <x-input wire:model.defer="hex_codes_array.{{ $index }}"
                                        class="flex-1 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:border-amber-500 transition-all duration-300"
                                        placeholder="#FFFFFF" />

                                    <button type="button" wire:click="removeColor({{ $index }})"
                                        class="p-2 bg-red-500 hover:bg-red-600 text-white rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg group/delete">
                                        <svg class="w-5 h-5 group-hover/delete:scale-110 transition-transform duration-200"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                                <x-input-error for="hex_codes_array.{{ $index }}" class="mt-1 ml-14" />
                            @endforeach
                        </div>

                        <button type="button" wire:click="addColor"
                            class="w-full py-3 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg flex items-center justify-center space-x-2 group">
                            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span>Añadir Color al Gradiente</span>
                        </button>
                        <x-input-error for="hex_codes_array" class="mt-2" />
                    </div>
                @else
                    <!-- Color Sólido -->
                    <div class="space-y-2">
                        <label for="hex_code"
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center space-x-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                            </svg>
                            <span>Color Sólido</span>
                        </label>

                        <div
                            class="flex items-center gap-3 p-4 bg-white dark:bg-gray-800 rounded-2xl border-2 border-gray-200 dark:border-gray-700 hover:border-amber-300 dark:hover:border-amber-600 transition-all duration-300">
                            <div class="relative">
                                <input type="color" wire:model.defer="hex_code" id="hex_code"
                                    class="w-16 h-16 p-0 border-2 border-gray-200 dark:border-gray-700 rounded-xl cursor-pointer transition-all duration-300 hover:scale-110 hover:border-amber-500 shadow-lg">
                            </div>

                            <x-input wire:model.defer="hex_code"
                                class="flex-1 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:border-amber-500 transition-all duration-300"
                                placeholder="#FFFFFF" />
                        </div>
                        <x-input-error for="hex_code" class="mt-1" />
                    </div>
                @endif

                <!-- Botones de Acción -->
                <div class="flex justify-between space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" wire:click="closeModal"
                        class="flex-1 py-3 px-6 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg flex items-center justify-center space-x-2 group">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-200"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>Cancelar</span>
                    </button>

                    <button type="submit"
                        class="flex-1 py-3 px-6 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg flex items-center justify-center space-x-2 group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-200" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Guardar Color</span>
                    </button>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer"></x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model="deleteModal">
        <x-slot name="title">
            <h2 class="text-center">Elimnar Registro</h2>
        </x-slot>
        <x-slot name="content">
            <p class="text-center">¿Desea eliminar este registro?</p>
            <form wire:submit="deleteSubmit">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="flex flex-col gap-1">
                        <label for="password">Contraseña:</label>
                        <x-input type="password" wire:model="password" id="password" />
                        <x-input-error for="password" class="mt-2 text-sm text-red-600" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="password_confirmation">Confirmar contraseña:</label>
                        <x-input type="password" wire:model="password_confirmation" id="password_confirmation" />
                        <x-input-error for="password_confirmation" class="mt-2 text-sm text-red-600" />
                    </div>
                </div>
                <div class="flex justify-around mt-5">
                    <x-danger-button wire:click="$set('deleteModal',false)">Cancelar</x-danger-button>
                    <x-button>Elimnar</x-button>
                </div>
            </form>
        </x-slot>
        <x-slot name="footer"></x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model="estatusModal">
        <x-slot name="title">
            <h2 class="text-center">Cambiar estatus del registro</h2>
        </x-slot>
        <x-slot name="content">
            <p class="text-center">¿Desea cambiar el estatus de este registro?</p>
            <form wire:submit="estatusSubmit">
                <div class="flex justify-around mt-5">
                    <x-danger-button wire:click="$set('estatusModal',false)">Cancelar</x-danger-button>
                    <x-button>Guardar</x-button>
                </div>
            </form>
        </x-slot>
        <x-slot name="footer"></x-slot>
    </x-dialog-modal>
</div>
