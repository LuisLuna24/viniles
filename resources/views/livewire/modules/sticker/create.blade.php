<div class="max-w-2xl p-8 mx-auto bg-gray-900 rounded-lg shadow-xl text-gray-200">

    {{-- Título del formulario --}}
    <h2 class="text-3xl font-bold text-center text-white mb-2">Agregar Nuevo Sticker</h2>
    <p class="mb-6 text-center text-gray-400">Completa los datos para añadir un sticker al catálogo.</p>

    {{-- Mensaje de éxito --}}
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-green-200 bg-green-800 border border-green-700 rounded-md">
            {{ session('message') }}
        </div>
    @endif

    {{-- El Alpine.js se encarga de la previsualización de la imagen --}}
    <div x-data="{ imagePreview: null }"
        class="p-6 mb-6 border-2 border-dashed rounded-lg border-gray-600 hover:border-indigo-500 transition-colors bg-gray-800">
        <input type="file" wire:model="img" id="img" class="hidden" accept="image/*" x-ref="imageInput"
            @change="
                const reader = new FileReader();
                reader.onload = (e) => {
                    imagePreview = e.target.result;
                };
                reader.readAsDataURL($refs.imageInput.files[0]);
            ">

        <label for="img" class="cursor-pointer">
            <template x-if="!imagePreview">
                <div class="flex flex-col items-center justify-center text-gray-400">
                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <p class="font-semibold">Sube una imagen</p>
                    <p class="text-sm">PNG, JPG, GIF hasta 2MB</p>
                </div>
            </template>
            <template x-if="imagePreview">
                <div class="flex flex-col items-center justify-center">
                    <img :src="imagePreview" alt="Previsualización del Sticker"
                        class="object-contain h-48 max-w-full rounded-md shadow-md">
                    <span class="mt-2 text-sm font-semibold text-indigo-400">Haz clic para cambiar la imagen</span>
                </div>
            </template>
        </label>
        @error('img')
            <span class="mt-2 text-sm text-red-400">{{ $message }}</span>
        @enderror
    </div>


    {{-- Formulario principal --}}
    <form wire:submit.prevent="save">

        <div class="mb-4">
            <label for="nombre" class="block mb-2 text-sm font-medium text-gray-300">Nombre del Sticker</label>
            <input type="text" id="nombre" wire:model.live="nombre"
                class="block w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-800 text-white @error('nombre') border-red-500 @else border-gray-700 @enderror"
                placeholder="Ej. Logo de Laravel">
            @error('nombre')
                <span class="mt-2 text-sm text-red-400">{{ $message }}</span>
            @enderror
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="mb-4">
                <label for="largo" class="block mb-2 text-sm font-medium text-gray-300">Ancho (cm)</label>
                <input type="number" id="largo" step="0.01" wire:model.live="largo"
                    class="block w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-800 text-white @error('largo') border-red-500 @else border-gray-700 @enderror"
                    placeholder="Ej. 10.5">
                @error('largo')
                    <span class="mt-2 text-sm text-red-400">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="alto" class="block mb-2 text-sm font-medium text-gray-300">Alto (cm)</label>
                <input type="number" id="alto" step="0.01" wire:model.live="alto"
                    class="block w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-800 text-white @error('alto') border-red-500 @else border-gray-700 @enderror"
                    placeholder="Ej. 8.0">
                @error('alto')
                    <span class="mt-2 text-sm text-red-400">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mt-6">
            <button type="submit"
                class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50"
                wire:loading.attr="disabled" wire:target="save,img">
                {{-- Icono de carga que se muestra mientras se guarda --}}
                <svg wire:loading wire:target="save,img" class="w-5 h-5 mr-2 -ml-1 text-white animate-spin"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span wire:loading.remove wire:target="save,img">Guardar Sticker</span>
                <span wire:loading wire:target="save,img">Guardando...</span>
            </button>
        </div>
    </form>
</div>
