<div class="space-y-3">
    <div class="flex flex-col gap-1">
        <label for="categoria">Categoría:</label>
        <x-select wire:model.change="categoria">
            <option value="" disabled>Seleccione un opción</option>
            @forelse ($categorias as $item)
                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
            @empty
                <option value="0" disabled>No hay registros</option>
            @endforelse
        </x-select>
        <x-input-error for="categoria" />
    </div>
    <div class="flex flex-col gap-1">
        <label for="subcategoria">Subcategoría:</label>
        <x-select wire:model.change="subcategoria">
            <option value="" disabled>Seleccione un opción</option>
            @forelse ($subcategorias as $item)
                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
            @empty
                <option value="0" disabled>Seleccione una categoría</option>
            @endforelse
        </x-select>
        <x-input-error for="subcategoria" />
    </div>
</div>
