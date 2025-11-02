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
