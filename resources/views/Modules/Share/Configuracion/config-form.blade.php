<div class="flex flex-col gap-1 md:col-span-2">
    <label for="descripcion">Descripción:</label>
    <x-select wire:model.live="descripcion" id="descripcion">
        <option value="" disabled>Seleccione una opción</option>
        <option value="Temperatura">Temperatura</option>
        <option value="Precion">Preción</option>
        <option value="Velocidad">Velocidad</option>
        <option value="Solvente">Solvente</option>
        <option value="Otro">Otro</option>
    </x-select>
    <x-input-error for="descripcion" />
</div>

<div class="flex flex-col gap-1 md:col-span-2" x-show="descripcion === 'Otro'">
    <label for="otra_descripcion">Otra descripcion:</label>
    <x-input wire:model="otra_descripcion" id="otra_descripcion" />
    <x-input-error for="otra_descripcion" />
</div>

<div class="flex flex-col gap-1 md:col-span-2">
    <label for="unidad">Unidad:</label>
    <x-input wire:model="unidad" id="unidad" />
    <x-input-error for="unidad" />
</div>

<div class="flex flex-col gap-1 md:col-span-2">
    <label for="valores">Valores:</label>
    <x-input wire:model="valores" id="valores" />
    <x-input-error for="valores" />
</div>
