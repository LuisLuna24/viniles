<div class="p-6 md:p-8 rounded-lg shadow-lg max-w-3xl mx-auto">
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

                            <div class="flex flex-col gap-1 md:col-span-2">
                                <label for="precio">Precio:</label>
                                <x-input type="number" wire:model="precio" id="precio" />
                                <x-input-error for="precio" />
                            </div>
                        </div>
                    </div>
                @break

                @case(2)
                    <div class="text-center mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">
                            {{ $titles[$currentStep] }}
                        </h2>
                    </div>

                    <fieldset class="space-y-2 mb-3" x-data="{ descripcion: @entangle('descripcion').live }">
                        @include('Modules.Share.Configuracion.config-form')
                        <div class="flex justify-end">
                            <x-button type="button" wire:click="addConfig">{{ $isEdit == 0 ? 'Agregar' : 'Editar' }}</x-button>
                        </div>
                    </fieldset>

                    <x-table.table>
                        <x-slot name="titles">
                            <x-table.th>No.</x-table.th>
                            <x-table.th>Descripcion</x-table.th>
                            <x-table.th>Unidad</x-table.th>
                            <x-table.th>Valores</x-table.th>
                            <x-table.th class="text-center">Acciones</x-table.th>
                        </x-slot>
                        <x-slot name="rows">
                            @forelse ($listConfig as $index => $item)
                                <x-table.tr>
                                    <x-table.td>{{ intval($index) + 1 }}</x-table.td>
                                    <x-table.td>{{ $item['descripcion'] == 'Otro' ? $item['otro'] : $item['descripcion'] }}</x-table.td>
                                    <x-table.td>{{ $item['unidad'] }}</x-table.td>
                                    <x-table.td>{{ $item['valores'] }}</x-table.td>
                                    <x-table.td-buttons>
                                        <x-table.button-table tipo="edit" wire:click="editConfig({{ intval($index) }})" />
                                        <x-table.button-table tipo="delete" wire:click="deleteConfig({{ intval($index) }})" />
                                    </x-table.td-buttons>
                                </x-table.tr>
                            @empty
                                <x-table.empty-state cols="6" message="No hay configuraciones registradas" />
                            @endforelse
                        </x-slot>
                    </x-table.table>
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
</div>
