<form wire:submit="save"
    class="space-y-6 max-w-2xl mx-auto p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg dark:shadow-xl dark:shadow-gray-900">

    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">
        Crear Nuevo Diseño
    </h2>
    <hr class="dark:border-gray-700">
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 dark:bg-green-900 dark:border-green-700 dark:text-green-300 px-4 py-3 rounded relative"
            role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div>
        <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del Diseño</label>
        <input type="text" id="nombre" wire:model="nombre"
            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:placeholder-gray-400"
            placeholder="Sticker para Tanque NS200">
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
        <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
        <textarea id="descripcion" wire:model="descripcion" rows="3"
            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:placeholder-gray-400"></textarea>
        @error('descripcion')
            <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="largo_cm" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Largo(cm)</label>
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

    <div>
        <label for="url_archivo_diseno" class="block text-sm font-medium text-gray-700 dark:text-gray-300">URL Archivo
            (Ej. Mercado Libre)</label>
        <input type="url" id="url_archivo_diseno" wire:model="url_archivo_diseno"
            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:placeholder-gray-400"
            placeholder="https://...">
        @error('url_archivo_diseno')
            <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
        @enderror
    </div>

    <div x-data="{ preview: null }" class="space-y-2">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagen Principal</label>

        <input type="file" id="url_imagen_principal" wire:model="url_imagen_principal"
            @change="preview = URL.createObjectURL($event.target.files[0])" class="hidden" x-ref="fileInput">

        <button type="button" @click="$refs.fileInput.click()"
            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
            Seleccionar Imagen
        </button>

        <div wire:loading wire:target="url_imagen_principal" class="text-sm text-gray-500 dark:text-gray-400">
            Cargando imagen...
        </div>

        <div class="mt-2">
            <template x-if="preview">
                <img :src="preview" class="w-48 h-48 object-cover rounded-md border dark:border-gray-600">
            </template>
            @if ($url_imagen_principal && !$errors->has('url_imagen_principal'))
                <template x-if="!preview">
                    <img src="{{ $url_imagen_principal->temporaryUrl() }}"
                        class="w-48 h-48 object-cover rounded-md border dark:border-gray-600">
                </template>
            @endif
        </div>

        @error('url_imagen_principal')
            <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
        @enderror
    </div>

    <div class="flex justify-end pt-4 border-t dark:border-gray-700">
        <button type="submit" wire:loading.attr="disabled" wire:target="save"
            class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 dark:bg-indigo-500 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50">

            <span wire:loading.remove wire:target="save">
                Guardar Diseño
            </span>
            <span wire:loading wire:target="save">
                Guardando...
            </span>
        </button>
    </div>
</form>
