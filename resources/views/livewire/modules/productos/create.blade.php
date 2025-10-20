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
                    @include('Modules.Share.Productos.tabla-productos')
                @break

                @case(3)
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                            {{ $titles[$currentStep] }}
                        </h2>
                    </div>

                    <fieldset class="mb-8">
                        <legend
                            class="w-full text-lg font-semibold text-gray-700 dark:text-gray-200 pb-2 mb-4 border-b border-gray-300 dark:border-gray-600">
                            {{ $titles[1] }}
                        </legend>
                    </fieldset>


                    <fieldset class="mb-8">
                        <legend
                            class="w-full text-lg font-semibold text-gray-700 dark:text-gray-200 pb-2 mb-4 border-b border-gray-300 dark:border-gray-600">
                            {{ $titles[2] }}
                        </legend>
                    </fieldset>
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

    @include('Modules.Share.Productos.modal-productos')
</div>
