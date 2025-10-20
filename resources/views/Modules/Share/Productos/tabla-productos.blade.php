<div class="space-y-3">
    <div class="flex justify-between">
        <div>
            <x-input-error for="listProducts" />
        </div>
        <x-button type="button" wire:click="openModal">
            Agregar
        </x-button>
    </div>
    <x-table.table>
        <x-slot name="titles">
            <x-table.th>No.</x-table.th>
            <x-table.th>Nombre</x-table.th>
            <x-table.th>Precio</x-table.th>
            <x-table.th>Stock</x-table.th>
            <x-table.th class="text-center">Acciones</x-table.th>
        </x-slot>
        <x-slot name="rows">
            @forelse ($listProducts as $index => $item)
                <x-table.tr>
                    <x-table.td>{{ intval($index) + 1 }}</x-table.td>
                    <x-table.td>{{ $item['nombre'] }}</x-table.td>
                    <x-table.td>{{ $item['precio_venta'] }}</x-table.td>
                    <x-table.td>{{ $item['stock'] }}</x-table.td>
                    <x-table.td-buttons>
                        <x-table.button-table tipo="edit" wire:click="editConfig({{ intval($index) }})" />
                        <x-table.button-table tipo="delete" wire:click="deleteConfig({{ intval($index) }})" />
                    </x-table.td-buttons>
                </x-table.tr>
            @empty
                <x-table.empty-state cols="6" message="No hay productos registrados" />
            @endforelse
        </x-slot>
    </x-table.table>
</div>
