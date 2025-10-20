{{-- resources/views/livewire/edit-sticker-form.blade.php --}}
<div class="max-w-2xl p-8 mx-auto bg-gray-900 rounded-lg shadow-xl text-gray-200">
    {{-- Título --}}
    <h2 class="text-3xl font-bold text-center text-white mb-2">Editar Sticker</h2>
    <p class="mb-6 text-center text-gray-400">Modifica los datos del sticker seleccionado.</p>

    {{-- Mensaje de éxito --}}
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-green-200 bg-green-800 border border-green-700 rounded-md">
            {{ session('message') }}
        </div>
    @endif
    <div x-data="{ selectedTab: 'groups' }" class="w-full">
        <div x-on:keydown.right.prevent="$focus.wrap().next()" x-on:keydown.left.prevent="$focus.wrap().previous()"
            class="flex gap-2 overflow-x-auto border-b border-neutral-300 dark:border-neutral-700" role="tablist"
            aria-label="tab options">
            <button x-on:click="selectedTab = 'groups'" x-bind:aria-selected="selectedTab === 'groups'"
                x-bind:tabindex="selectedTab === 'groups' ? '0' : '-1'"
                x-bind:class="selectedTab === 'groups' ?
                    'font-bold text-black border-b-2 border-black dark:border-white dark:text-white' :
                    'text-neutral-600 font-medium dark:text-neutral-300 dark:hover:border-b-neutral-300 dark:hover:text-white hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900'"
                class="h-min px-4 py-2 text-sm" type="button" role="tab" aria-controls="tabpanelGroups">Datos del
                sticker</button>
            <button x-on:click="selectedTab = 'likes'" x-bind:aria-selected="selectedTab === 'likes'"
                x-bind:tabindex="selectedTab === 'likes' ? '0' : '-1'"
                x-bind:class="selectedTab === 'likes' ?
                    'font-bold text-black border-b-2 border-black dark:border-white dark:text-white' :
                    'text-neutral-600 font-medium dark:text-neutral-300 dark:hover:border-b-neutral-300 dark:hover:text-white hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900'"
                class="h-min px-4 py-2 text-sm" type="button" role="tab"
                aria-controls="tabpanelLikes">Colores</button>
        </div>
        <div class="px-2 py-4 text-neutral-600 dark:text-neutral-300">
            <div x-cloak x-show="selectedTab === 'groups'" id="tabpanelGroups" role="tabpanel" aria-label="groups">
                {{-- Previsualización --}}
                @if ($sticker)
                    <div x-data="{ imagePreview: null, existingImageUrl: '{{ Storage::url($sticker->img) }}' }"
                        class="p-6 mb-6 border-2 border-dashed rounded-lg border-gray-600 hover:border-indigo-500 transition-colors bg-gray-800">
                        <input type="file" wire:model="newImage" id="newImage" class="hidden" accept="image/*"
                            x-ref="imageInput"
                            @change=" const reader = new FileReader(); reader.onload = (e) => { imagePreview = e.target.result; }; reader.readAsDataURL($refs.imageInput.files[0]); ">
                        <label for="newImage" class="cursor-pointer">
                            <div class="flex flex-col items-center justify-center">
                                <img :src="imagePreview || existingImageUrl" alt="Previsualización del Sticker"
                                    class="object-contain h-48 max-w-full rounded-md shadow-md">
                                <span class="mt-2 text-sm font-semibold text-indigo-400">Haz clic para cambiar la
                                    imagen</span>
                            </div>
                        </label>
                        @error('newImage')
                            <span class="mt-2 text-sm text-red-400">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                {{-- Formulario --}}
                <form wire:submit.prevent="update">
                    {{-- ... todos los campos del formulario (nombre, largo, alto) ... --}}
                    {{-- Estos no cambian, por brevedad no los repito. Son idénticos al paso anterior. --}}

                    <div class="mb-4">
                        <label for="nombre" class="block mb-2 text-sm font-medium text-gray-300">Nombre del
                            Sticker</label>
                        <input type="text" id="nombre" wire:model="nombre"
                            class="block w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-800 text-white @error('nombre') border-red-500 @else border-gray-700 @enderror">
                        @error('nombre')
                            <span class="mt-2 text-sm text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="mb-4">
                            <label for="largo" class="block mb-2 text-sm font-medium text-gray-300">Ancho
                                (cm)</label>
                            <input type="number" id="largo" step="0.01" wire:model="largo"
                                class="block w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-800 text-white @error('largo') border-red-500 @else border-gray-700 @enderror">
                            @error('largo')
                                <span class="mt-2 text-sm text-red-400">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="alto" class="block mb-2 text-sm font-medium text-gray-300">Alto (cm)</label>
                            <input type="number" id="alto" step="0.01" wire:model="alto"
                                class="block w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-800 text-white @error('alto') border-red-500 @else border-gray-700 @enderror">
                            @error('alto')
                                <span class="mt-2 text-sm text-red-400">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50"
                            wire:loading.attr="disabled" wire:target="update,newImage">
                            <svg wire:loading wire:target="update,newImage"
                                class="w-5 h-5 mr-2 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span wire:loading.remove wire:target="update,newImage">Guardar Cambios</span>
                            <span wire:loading wire:target="update,newImage">Guardando...</span>
                        </button>
                    </div>
                </form>
            </div>
            <div x-cloak x-show="selectedTab === 'likes'" id="tabpanelLikes" role="tabpanel" aria-label="likes">
                <div class="mb-3 flex justify-end">
                    <x-button type="button" wire:click="newColor">Nuevo color</x-button>
                </div>
                <x-table.table>
                    <x-slot name="titles">
                        <x-table.th>Color</x-table.th>
                        <x-table.th>Precio unitario</x-table.th>
                        <x-table.th>Precio Mayoreo</x-table.th>
                        <x-table.th>Estatus</x-table.th>
                        <x-table.th class="text-center">Acciones</x-table.th>
                    </x-slot>
                    <x-slot name="rows">
                        @forelse ($coloresStiker as $index => $item)
                            <x-table.tr>
                                <x-table.td>{{ $item->color->nombre }}</x-table.td>
                                <x-table.td>{{ $item->precio_untario }}</x-table.td>
                                <x-table.td>{{ $item->precio_mayoreo }}</x-table.td>
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
                    {{ $coloresStiker->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-dialog-modal wire:model="modalColor">
        <x-slot name="title">
            <h2 class="text-2xl font-bold text-center text-gray-100">
                {{-- Título dinámico para saber si se está creando o editando --}}
                {{ $typeFormColor == 1 ? 'Nuevo Color' : 'Editar Color' }}
            </h2>
        </x-slot>

        <x-slot name="content">
            {{--
            El formulario envuelve todo el contenido del modal.
            `wire:submit.prevent` se encarga de llamar al método `submitColors` en el componente Livewire.
        --}}
            <form wire:submit.prevent="submitColors">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-300">

                    {{-- Selector de Color --}}
                    <div class="md:col-span-2">
                        <label for="color_id" class="block text-sm font-medium mb-1">Color:</label>
                        <x-select wire:model="color_id" id="color_id" class="w-full">
                            <option value="" disabled>Seleccione un color</option>
                            @forelse ($colores as $item)
                                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                            @empty
                                <option value="" disabled>No hay colores registrados</option>
                            @endforelse
                        </x-select>
                        <x-input-error for="color_id" />
                    </div>

                    {{-- Campo: Precio Unitario --}}
                    <div>
                        <label for="precio_unitario_color" class="block text-sm font-medium mb-1">Precio unitario
                            (MXN):</label>
                        <x-input type="number" step="0.01" wire:model="precio_unitario_color"
                            id="precio_unitario_color" class="w-full" placeholder="Ej. 12.50" />
                        <x-input-error for="precio_unitario_color" />
                    </div>

                    {{-- Campo: Precio Mayoreo --}}
                    <div>
                        <label for="precio_mayoreo_color" class="block text-sm font-medium mb-1">Precio mayoreo
                            (MXN):</label>
                        <x-input type="number" step="0.01" wire:model="precio_mayoreo_color"
                            id="precio_mayoreo_color" class="w-full" placeholder="Ej. 9.00" />
                        <x-input-error for="precio_mayoreo_color" />
                    </div>

                    {{-- Previsualización y Carga de Imagen --}}
                    <div class="md:col-span-2" x-data="{ imagePreview: null, existingImageUrl: '{{ $img_color_url ?? '' }}' }">
                        <label class="block text-sm font-medium mb-1">Imagen del color:</label>
                        <div
                            class="p-4 border-2 border-dashed rounded-lg border-gray-600 hover:border-indigo-500 transition-colors bg-gray-800 text-center">
                            {{-- Input de archivo oculto --}}
                            <input type="file" wire:model="img_color" id="img_color" class="hidden"
                                accept="image/*" x-ref="imageInput"
                                @change="
                                const reader = new FileReader();
                                reader.onload = (e) => { imagePreview = e.target.result; };
                                reader.readAsDataURL($refs.imageInput.files[0]);
                               ">

                            <label for="img_color" class="cursor-pointer">
                                {{-- Estado: Muestra la imagen (nueva o existente) --}}
                                <template x-if="imagePreview || existingImageUrl">
                                    <div class="flex flex-col items-center justify-center">
                                        <img :src="imagePreview || existingImageUrl" alt="Previsualización del Sticker"
                                            class="object-contain h-40 max-w-full rounded-md shadow-md">
                                        <span class="mt-2 text-sm font-semibold text-indigo-400">Haz clic para cambiar
                                            la imagen</span>
                                    </div>
                                </template>

                                {{-- Estado Inicial: Muestra el placeholder para subir imagen --}}
                                <template x-if="!imagePreview && !existingImageUrl">
                                    <div class="flex flex-col items-center justify-center text-gray-400 py-4">
                                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <p class="font-semibold">Sube una imagen</p>
                                        <p class="text-xs">PNG, JPG, GIF hasta 2MB</p>
                                    </div>
                                </template>
                            </label>
                        </div>
                        <x-input-error for="img_color" />
                    </div>
                </div>

                {{-- Botones de acción del formulario --}}
                <div class="flex justify-end gap-4 mt-8">
                    <x-secondary-button type="button" wire:click="$set('modalColor', false)"
                        wire:loading.attr="disabled">
                        Cancelar
                    </x-secondary-button>

                    <x-button type="submit" wire:loading.attr="disabled" wire:target="submitColors, img_color">
                        <span wire:loading.remove wire:target="submitColors, img_color">
                            {{ $typeFormColor == 1 ? 'Guardar Color' : 'Guardar Cambios' }}
                        </span>
                        <span wire:loading wire:target="submitColors, img_color">
                            Guardando...
                        </span>
                    </x-button>
                </div>
            </form>
        </x-slot>
        <x-slot name="footer"></x-slot>
    </x-dialog-modal>
</div>
