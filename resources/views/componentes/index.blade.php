<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Componentes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-10">
                <div class="flex flex-wrap justify-center items-center gap-5">
                    <x-card>
                        <x-slot name="title">
                            Ensambles
                        </x-slot>
                        <x-slot name="body">
                            <br>
                            <x-button-routing href="{{ route('componentes.index') }}" wire:navigate.hover>Entrar</x-button-routing>
                        </x-slot>
                    </x-card>
                    <x-card>
                        <x-slot name="title">
                            Procesadores
                        </x-slot>
                        <x-slot name="body">
                            <br>
                            <x-button-routing href="{{ route('componentes.index') }}" wire:navigate.hover>Entrar</x-button-routing>
                        </x-slot> 
                    </x-card>
                    <x-card >
                        <x-slot name="title">
                            Targetas Madre
                        </x-slot>
                        <x-slot name="body">
                            <br>
                            <x-button-routing href="{{ route('componentes.index') }}" wire:navigate.hover>Entrar</x-button-routing>
                        </x-slot>
                    </x-card>
                    <x-card>
                        <x-slot name="title">
                            Targetas de video
                        </x-slot>
                        <x-slot name="body">
                            <br>
                            <x-button-routing href="{{ route('componentes.index') }}" wire:navigate.hover>Entrar</x-button-routing>
                        </x-slot>
                    </x-card>
                    <x-card>
                        <x-slot name="title">
                            Memoria Ram
                        </x-slot>
                        <x-slot name="body">
                            <br>
                            <x-button-routing href="{{ route('componentes.index') }}" wire:navigate.hover>Entrar</x-button-routing>
                        </x-slot>
                    </x-card>
                    <x-card>
                        <x-slot name="title">
                            Discoduro SSD
                        </x-slot>
                        <x-slot name="body">
                            <br>
                            <x-button-routing href="{{ route('componentes.index') }}" wire:navigate.hover>Entrar</x-button-routing>
                        </x-slot>
                    </x-card>
                    <x-card>
                        <x-slot name="title">
                            Discoduro hdd
                        </x-slot>
                        <x-slot name="body">
                            <br>
                            <x-button-routing href="{{ route('componentes.index') }}" wire:navigate.hover>Entrar</x-button-routing>
                        </x-slot>
                    </x-card>
                    <x-card>
                        <x-slot name="title">
                            Fuente de poder
                        </x-slot>
                        <x-slot name="body">
                            <br>
                            <x-button-routing href="{{ route('componentes.index') }}" wire:navigate.hover>Entrar</x-button-routing>
                        </x-slot>
                    </x-card>
                    <x-card>
                        <x-slot name="title">
                            Gabinete
                        </x-slot>
                        <x-slot name="body">
                            <br>
                            <x-button-routing href="{{ route('componentes.index') }}" wire:navigate.hover>Entrar</x-button-routing>
                        </x-slot>
                    </x-card>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
