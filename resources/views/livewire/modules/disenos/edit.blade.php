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

            <button x-on:click="selectedTab = 'colores'" :aria-selected="selectedTab === 'colores'"
                :tabindex="selectedTab === 'colores' ? '0' : '-1'"
                :class="selectedTab === 'colores' ?
                    'font-bold text-indigo-600 border-b-2 border-indigo-600 dark:border-indigo-400 dark:text-indigo-400' :
                    'text-neutral-600 font-medium dark:text-neutral-300 dark:hover:border-b-neutral-300 dark:hover:text-white hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900'"
                class="h-min px-4 py-2 text-sm" type="button" role="tab">
                Colores y Precios
            </button>
        </div>
    </div>

    <div x-cloak x-show="selectedTab === 'info'" role="tabpanel" aria-label="Información General">

        <form wire:submit="updateDiseno" class="space-y-6 p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">

            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">
                Editar Información del Diseño
            </h2>

            @if (session()->has('messageDiseno'))
                <div class="bg-green-100 border border-green-400 text-green-700 dark:bg-green-900 dark:border-green-700 dark:text-green-300 px-4 py-3 rounded relative"
                    role="alert">
                    {{ session('messageDiseno') }}
                </div>
            @endif

            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                <input type="text" id="nombre" wire:model.live="nombre"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                @error('nombre')
                    <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="tipo_diseno" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de
                    Diseño</label>
                <select id="tipo_diseno" wire:model="tipo_diseno"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Seleccione un tipo</option>
                    <option value="Sticker">Sticker</option>
                    <option value="Serigrafia">Serigrafía</option>
                    <option value="Sublimacion">Sublimación</option>
                    <option value="Polarizado">Polarizado</option>
                    <option value="Otro">Otro</option>
                </select>
                @error('tipo_diseno')
                    <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="descripcion"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                <textarea id="descripcion" wire:model="descripcion" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:placeholder-gray-400"></textarea>
                @error('descripcion')
                    <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="largo_cm" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Largo
                    (cm)</label>
                <div class="relative mt-1 rounded-md shadow-sm">
                    <input type="number" id="largo_cm" wire:model="largo_cm" step="0.01"
                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white pr-12 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:placeholder-gray-400"
                        placeholder="0.00">
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                        <span class="text-gray-500 dark:text-gray-400 sm:text-sm" id="price-currency">cm</span>
                    </div>
                </div>
                @error('largo_cm')
                    <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div x-data="{ newPreview: null }" class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagen Principal</label>

                @if ($diseno->url_imagen_principal && !$nueva_imagen_principal)
                    <div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Imagen actual:</span>
                        <img src="{{ asset('storage/' . $diseno->url_imagen_principal) }}"
                            class="w-48 h-48 object-cover rounded-md border dark:border-gray-600">
                    </div>
                @endif

                <input type="file" id="nueva_imagen_principal" wire:model="nueva_imagen_principal"
                    @change="newPreview = URL.createObjectURL($event.target.files[0])" class="hidden"
                    x-ref="newFileInput">

                <button type="button" @click="$refs.newFileInput.click()"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-500">
                    Cambiar Imagen
                </button>

                <template x-if="newPreview">
                    <img :src="newPreview" class="w-48 h-48 object-cover rounded-md border dark:border-gray-600">
                </template>
                @error('nueva_imagen_principal')
                    <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end pt-4 border-t dark:border-gray-700">
                <button type="submit" wire:loading.attr="disabled"
                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 dark:bg-indigo-500 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 dark:hover:bg-indigo-600">
                    Actualizar Información
                </button>
            </div>
        </form>
    </div>

    <div x-cloak x-show="selectedTab === 'colores'" role="tabpanel" aria-label="Colores y Precios">
        <div class="p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">
                    Colores y Precios
                </h2>
                <button type="button" @click="showColorModal = true"
                    class="inline-flex justify-center rounded-md border border-transparent bg-green-600 dark:bg-green-500 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-green-700 dark:hover:bg-green-600">
                    + Agregar Variación
                </button>
            </div>

            <div class="flow-root">
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($variaciones as $variacion)
                        <li class="py-3 sm:py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    @if ($variacion->url_imagen_ejemplo)
                                        <img class="w-12 h-12 rounded-full object-cover"
                                            src="{{ asset('storage/' . $variacion->url_imagen_ejemplo) }}"
                                            alt="Ejemplo">
                                    @else
                                        <div
                                            class="w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l-1.586-1.586a2 2 0 00-2.828 0L6 14m6-6l.01.01">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        Color: {{ $variacion->nombre_color }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                        ID: {{ $variacion->id }}
                                    </p>
                                </div>
                                <div
                                    class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    + ${{ $variacion->precio_adicional }}
                                </div>
                                <div
                                    class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    <x-table.button-table wire:click="delete({{ $variacion->id }})" tipo="delete" />
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                            Aún no hay variaciones de color para este diseño.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>


    <div x-cloak x-show="showColorModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">

        <div x-show="showColorModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0"
            @click="showColorModal = false" aria-hidden="true">
        </div>

        <div x-show="showColorModal" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative w-full max-w-lg mx-4" @click.stop>

            <form wire:submit="saveColor" class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 space-y-4">

                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white" id="modal-title">
                    Agregar Variación de Color y Precio
                </h3>

                @if (session()->has('messageColor'))
                    <div class="bg-green-100 border border-green-400 text-green-700 dark:bg-green-900 dark:border-green-700 dark:text-green-300 px-4 py-3 rounded relative"
                        role="alert">
                        {{ session('messageColor') }}
                    </div>
                @endif

                <div>
                    <label for="nombre_color"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del color</label>
                    <input type="text" id="nombre_color" wire:model="nombre_color"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                    @error('nombre_color')
                        <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="color_primario_id"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color Primario *</label>
                    <select id="color_primario_id" wire:model="color_primario_id"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                        <option value="">Seleccione un color</option>
                        @foreach ($colores as $color)
                            <option value="{{ $color->id }}">{{ $color->nombre }}</option>
                        @endforeach
                    </select>
                    @error('color_primario_id')
                        <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="color_secundario_id"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color Secundario</label>
                    <select id="color_secundario_id" wire:model="color_secundario_id"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                        <option value="">Opcional</option>
                        @foreach ($colores as $color)
                            <option value="{{ $color->id }}">{{ $color->nombre }}</option>
                        @endforeach
                    </select>
                    @error('color_secundario_id')
                        <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="color_terciario_id"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color Terciario</label>
                    <select id="color_terciario_id" wire:model="color_terciario_id"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                        <option value="">Opcional</option>
                        @foreach ($colores as $color)
                            <option value="{{ $color->id }}">{{ $color->nombre }}</option>
                        @endforeach
                    </select>
                    @error('color_terciario_id')
                        <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="precio_adicional"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio Adicional *</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" id="precio_adicional" wire:model="precio_adicional" min="0"
                            class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white pl-7 pr-12 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="0">
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <span class="text-gray-500 sm:text-sm" id="price-currency">MXN</span>
                        </div>
                    </div>
                    @error('precio_adicional')
                        <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagen de Ejemplo</label>
                    <input type="file" wire:model="nueva_imagen_ejemplo"
                        class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-indigo-50 dark:file:bg-indigo-900
                        file:text-indigo-700 dark:file:text-indigo-300
                        hover:file:bg-indigo-100 dark:hover:file:bg-indigo-800
                    " />
                    @error('nueva_imagen_ejemplo')
                        <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t dark:border-gray-700">
                    <button type="button" @click="showColorModal = false"
                        class="rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-2 px-4 text-sm font-medium text-gray-700 dark:text-gray-200 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancelar
                    </button>
                    <button type="submit" wire:loading.attr="disabled"
                        class="rounded-md border border-transparent bg-green-600 dark:bg-green-500 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-green-700 dark:hover:bg-green-600">
                        Guardar Variación
                    </button>
                </div>
            </form>
        </div>
    </div>


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
