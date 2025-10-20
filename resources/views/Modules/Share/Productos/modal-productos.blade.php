<x-dialog-modal wire:model="modalProduct">
    <x-slot name="title">
        <h2 class="text-center">Producto</h2>
    </x-slot>
    <x-slot name="content">
        <form wire:submit="addProduct" class="grid grid-cols-1 md:grid-cols-2 gap-3">
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

                <div class="flex flex-col gap-1 md:col-span-2" x-show="mostrar_en === 'linea' || mostrar_en === 'ambas'"
                    x-transition>
                    <label for="url_mercado">Url de mercado libre:</label>
                    <x-input wire:model="url_mercado" id="url_mercado" />
                    <x-input-error for="url_mercado" />
                </div>
            </div>
            <div class="flex justify-between md:col-span-2">
                <x-danger-button wire:click="cancelModalProduct">Cancelar</x-danger-button>
                <x-button type="submit">Agregar</x-button>
            </div>
        </form>
    </x-slot>
    <x-slot name="footer"></x-slot>
</x-dialog-modal>
