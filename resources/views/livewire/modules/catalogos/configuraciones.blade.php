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
            <x-table.th>Marca</x-table.th>
            <x-table.th>Estatus</x-table.th>
            <x-table.th class="text-center">Acciones</x-table.th>
        </x-slot>
        <x-slot name="rows">
            @forelse ($collection as $index => $item)
                <x-table.tr>
                    <x-table.td>{{ ($collection->currentPage() - 1) * $collection->perPage() + $loop->iteration }}</x-table.td>
                    <x-table.td>{{ $item->nombre }}</x-table.td>
                    <x-table.td>{{ $item->marca->nombre }}</x-table.td>
                    <x-table.td>
                        <x-toggle-switch :id="$item->id" :checked="$item->estatus" :disabled="true"
                            wireClick="statusRegister({{ $item->id }})" />
                    </x-table.td>
                    <x-table.td-buttons>
                        <x-table.button-table tipo="view" wire:click="view({{ $item->id }})" />
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
            <h2 class="text-center">{{ $typeForm == 1 ? 'Nuevo' : 'Editar' }} Registro</h2>
        </x-slot>
        <x-slot name="content">
            <form wire:submit="submitForm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="flex flex-col gap-1 md:col-span-2">
                        <label for="nombre">Nombre:</label>
                        <x-input wire:model="nombre" id="nombre" />
                        <x-input-error for="nombre" />
                    </div>
                    <div class="flex flex-col gap-1 md:col-span-2">
                        <label for="marca">Marca:</label>
                        <x-select wire:model="marca" id="marca">
                            <option value="" disabled>Seleccione una opción</option>
                            @forelse ($marcas as $item)
                                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                            @empty
                                <option value="0" disabled>Sin registros</option>
                            @endforelse
                        </x-select>
                        <x-input-error for="marca" />
                    </div>
                    <div x-data="{ producto: @entangle('producto').live }" class="md:col-span-2 space-y-3">

                        {{-- Este es tu código para el select --}}
                        <div class="flex flex-col gap-1 md:col-span-2">
                            <label for="producto">Producto:</label>
                            {{-- Usamos .live para que la actualización sea instantánea --}}
                            <x-select wire:model.live="producto" id="producto">
                                <option value="" disabled>Seleccione una opción</option>
                                <option value="DTF">DTF</option>
                                <option value="Sublimacion">Sublimación</option>
                                <option value="Viniles">Viniles</option>
                                <option value="Otro">Otro</option>
                            </x-select>
                            <x-input-error for="producto" />
                        </div>

                        {{-- El div condicional ahora funcionará --}}
                        <div class="flex flex-col gap-1 md:col-span-2" x-show="producto === 'Otro'">
                            <label for="otro">Otro producto:</label>
                            <x-input wire:model="otro" id="otro" />
                            <x-input-error for="otro" />
                        </div>
                    </div>
                </div>
                <div class="flex justify-around mt-5">
                    <x-danger-button wire:click="closeModal">Cancelar</x-danger-button>
                    <x-button>Guardar</x-button>
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
