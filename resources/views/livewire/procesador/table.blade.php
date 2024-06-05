<div>
    <div class="flex text-black dark:text-white gap-5 w-full mb-4">
        <div class="flex flex-col">
            <label for="Datos">Datos:</label>
            <x-select wire:model.live="datos">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
            </x-select>
        </div>
        <div class="flex flex-col w-full">
            <label for="Datos">Bucar:</label>
            <x-input class="w-full" wire:model.live="search" placeholder="(Nombre, familia o chipset)"/>
        </div>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center">
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Familia
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Chipset
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Precio
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        <span class="sr-only">Editar</span>
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        <span class="sr-only text-red-600">Eliminar</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($procesadores as $procesador)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class=" text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" wire:key="prosesador-{{ $procesador->id }}">
                            {{$procesador->name}}
                        </th>
                        <td class="px-6 py-4 text-center">
                            {{$procesador->family->name}}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{$procesador->chipset->name}}
                        </td>
                        <td class="px-6 py-4 text-center">
                            ${{$procesador->price}}
                        </td>
                        <td class="px-6 py-4 text-center ">
                            <x-button>Editar</x-button>
                        </td>
                        <td class="px-6 py-4 text-center ">
                            <x-danger-button>Eliminar</x-danger-button>
                        </td>
                    </tr>  
                @endforeach
            </tbody>
        </table>
    </div>
</div>
