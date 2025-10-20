<div class="p-6 md:p-8 rounded-lg shadow-lg max-w-5xl mx-auto">
    <div class="">
        <!-- Porcentaje -->
        <div>
            <div class="mb-2">
                <h2>{{ $currentStep . '/' . $totalSteps . ' - ' . $titles[$currentStep] }}</h2>
            </div>
            <div x-data="{
                currentVal: Math.min(Math.max({{ intval($porcentaje) }}, 0), 100),
                maxVal: 100
            }"
                class="flex h-2.5 w-full overflow-hidden rounded-sm bg-neutral-50 dark:bg-neutral-900" role="progressbar"
                aria-label="progress bar" :aria-valuenow="currentVal" :aria-valuemax="maxVal">
                <div class="h-full rounded-sm bg-lime-500 dark:bg-lime-400 transition-all duration-300 ease-in-out"
                    style="width: {{ $porcentaje }}%">
                </div>
            </div>
        </div>
        <form wire:submit.prevent="submitForm" class="mt-5">
            @switch($currentStep)
                {{-- Gisenae e interesado --}}
                @case(1)
                    <div class="text-center mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">
                            {{ $titles[$currentStep] }}
                        </h2>
                    </div>
                    @include('Modules.Share.Productos.categorias')
                @break

                @case(2)
                    <div class="text-center mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">
                            {{ $titles[$currentStep] }}
                        </h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="flex flex-col gap-1 col-span-2">
                            <label for="nombre">Nombre:</label>
                            <x-input wire:model="nombre" />
                            <x-input-error for="nombre" />
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="precio_venta">Precio venta:</label>
                            <x-input type="number" wire:model="precio_venta" />
                            <x-input-error for="precio_venta" />
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="precio_costo">Costo de producción:</label>
                            <x-input type="number" wire:model="precio_costo" />
                            <x-input-error for="precio_costo" />
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="stock">Stock:</label>
                            <x-input type="number" wire:model="stock" />
                            <x-input-error for="stock" />
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="unidad">Unidad de venta:</label>
                            <x-select wire:model.change="unidad">
                                <option value="" disabled>Seleccione un opción</option>
                                @forelse ($unidades as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @empty
                                    <option value="0" disabled>No hay registros</option>
                                @endforelse
                            </x-select>
                            <x-input-error for="unidad" />
                        </div>
                        <div x-data="{ mostrar_en: @js($mostrar_en) }" class="md:col-span-2 space-y-3">

                            <div class="flex flex-col gap-1 md:col-span-2">
                                <label for="mostrar_en">¿En dónde se mostrará?</label>

                                <x-select wire:model.live="mostrar_en" x-model="mostrar_en" id="mostrar_en">
                                    <option value="" disabled>Seleccione una opción</option>
                                    <option value="tienda">Tienda</option>
                                    <option value="linea">Línea</option>
                                    <option value="ambas">Ambas</option>
                                </x-select>

                                <x-input-error for="mostrar_en" />
                            </div>

                            <div class="flex flex-col gap-1 md:col-span-2"
                                x-show="mostrar_en === 'linea' || mostrar_en === 'ambas'" x-transition>
                                <label for="url_mercado">Url de mercado libre:</label>
                                <x-input wire:model="url_mercado" id="url_mercado" />
                                <x-input-error for="url_mercado" />
                            </div>
                        </div>
                    </div>
                @break

                @case(3)
                    <div class="text-center mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">
                            {{ $titles[$currentStep] }}
                        </h2>
                    </div>
                    <div class="flex justify-end mb-3">
                        <x-button type="button" wire:click="createDescrip">
                            Agregar
                        </x-button>
                    </div>
                    <x-table.table>
                        <x-slot name="titles">
                            <x-table.th>No.</x-table.th>
                            <x-table.th>Descripción</x-table.th>
                            <x-table.th class="text-center">Acciones</x-table.th>
                        </x-slot>
                        <x-slot name="rows">
                            @forelse ($descripciones as $index => $item)
                                <x-table.tr>
                                    <x-table.td>{{ ($descripciones->currentPage() - 1) * $descripciones->perPage() + $loop->iteration }}</x-table.td>
                                    <x-table.td>{{ $item->descripcion }}</x-table.td>
                                    <x-table.td-buttons>
                                        <x-table.button-table tipo="edit" wire:click="editDescrip({{ $item->id }})" />
                                        <x-table.button-table tipo="delete" wire:click="deleteDescrip({{ $item->id }})" />
                                    </x-table.td-buttons>
                                </x-table.tr>
                            @empty
                                <x-table.empty-state cols="7" message="No hay registros disponibles" />
                            @endforelse
                        </x-slot>
                    </x-table.table>
                    <div class="mt-3">
                        {{ $descripciones->onEachSide(1)->links() }}
                    </div>
                @break

                @case(4)
                    <div class="text-center mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">
                            {{ $titles[$currentStep] }}
                        </h2>
                    </div>
                    <div class="flex justify-end mb-3">
                        <x-button type="button" wire:click="createImage">
                            Agregar
                        </x-button>
                    </div>
                    <x-table.table>
                        <x-slot name="titles">
                            <x-table.th>No.</x-table.th>
                            <x-table.th>Imagen</x-table.th>
                            <x-table.th class="text-center">Acciones</x-table.th>
                        </x-slot>
                        <x-slot name="rows">
                            @forelse ($imagenes as $item)
                                <x-table.tr>
                                    <x-table.td>
                                        {{ ($imagenes->currentPage() - 1) * $imagenes->perPage() + $loop->iteration }}
                                    </x-table.td>

                                    <x-table.td>
                                        @if ($item->url_imagen)
                                            <img src="{{ asset('storage/' . $item->url_imagen) }}" alt="Imagen del producto"
                                                class="h-16 w-16 object-cover rounded-md shadow-sm">
                                        @else
                                            <span class="text-gray-400 text-sm">Sin imagen</span>
                                        @endif
                                    </x-table.td>

                                    <x-table.td-buttons>
                                        <x-table.button-table tipo="edit" wire:click="editImge({{ $item->id }})" />
                                        <x-table.button-table tipo="delete" wire:click="deleteImage({{ $item->id }})" />
                                    </x-table.td-buttons>
                                </x-table.tr>
                            @empty
                                <x-table.empty-state cols="4" message="No hay registros disponibles" />
                            @endforelse
                        </x-slot>
                    </x-table.table>
                    <div class="mt-3">
                        {{ $imagenes->onEachSide(1)->links() }}
                    </div>
                @break

            @endswitch
            {{-- Botones --}}
            <div class="flex justify-between mt-10">
                <!-- Espacio en blanco para la primera condición -->
                @if ($currentStep == 1)
                    <div></div>
                @endif
                <!-- Botón "Anterior" visible si no estás en el primer paso -->
                @if ($currentStep > 1 && $currentStep <= $totalSteps)
                    <x-danger-button wire:click="decreaseStep" type="button">Anterior</x-danger-button>
                @endif
                <!-- Botón "Siguiente" visible si no estás en el último paso -->
                @if ($currentStep < $totalSteps)
                    <x-button wire:click="increaseStep" type="button">
                        Siguiente
                    </x-button>
                @endif
                <!-- Botón "Guardar" visible solo en el último paso -->
                @if ($currentStep == $totalSteps)
                    <x-button type="submit">Guardar</x-button>
                @endif
            </div>
        </form>
    </div>

    <x-dialog-modal wire:model="modalDescrip">
        <x-slot name="title">
            <h2 class="text-center">Descripciónes del producto</h2>
        </x-slot>
        <x-slot name="content">
            <form wire:submit="submitDescrip" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div class="flex flex-col gap-1 col-span-2">
                    <label for="descripcion">Descripción:</label>
                    <x-input wire:model="descripcion" />
                    <x-input-error for="descripcion" />
                </div>
                <div class="flex justify-between md:col-span-2">
                    <x-danger-button wire:click="cancelModalProduct">Cancelar</x-danger-button>
                    <x-button type="submit">Agregar</x-button>
                </div>
            </form>
        </x-slot>
        <x-slot name="footer"></x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model="modalImage">
        <x-slot name="title">
            <h2 class="text-center">Imagen del producto</h2>
        </x-slot>
        <x-slot name="content">
            <form wire:submit="submitImge" class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="flex flex-col gap-1 col-span-2">
                    <label for="imagen">Imagen (opcional):</label>
                    <input type="file" wire:model="imagen" id="imagen"
                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" />

                    <div wire:loading wire:target="imagen" class="text-sm text-gray-500 mt-2">
                        <span class="animate-spin mr-2">⏳</span>Cargando imagen...
                    </div>

                    <div class="mt-4">
                        @if ($imagen)
                            <p class="text-sm font-bold mb-2">Previsualización:</p>
                            <img src="{{ $imagen->temporaryUrl() }}" class="w-48 h-auto rounded-md object-cover">
                        @elseif ($existingImageUrl)
                            <p class="text-sm font-bold mb-2">Imagen actual:</p>
                            <img src="{{ asset('storage/' . $existingImageUrl) }}"
                                class="w-48 h-auto rounded-md object-cover">
                        @endif
                    </div>

                    <x-input-error for="imagen" />
                </div>

                <div class="flex justify-between md:col-span-2 mt-4">
                    <x-danger-button type="button" wire:click="closeModalImge">Cancelar</x-danger-button>
                    <x-button type="submit">Guardar</x-button>
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

</div>
