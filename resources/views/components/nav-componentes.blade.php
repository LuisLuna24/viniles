<nav class="flex gap-3 max-md:hidden">
    <x-nav-link href="{{ route('componentes.ensambles') }}" :active="request()->routeIs('componentes.ensambles')" wire:navigate.hover>
        {{ __('Ensambles') }}
    </x-nav-link>
    <x-nav-link href="{{ route('componentes.procesador') }}" :active="request()->routeIs('componentes.procesador')" wire:navigate.hover>
        {{ __('Procesadores') }}
    </x-nav-link>
    <x-nav-link href="{{ route('componentes.targeta_madre') }}" :active="request()->routeIs('componentes.targeta_madre')" wire:navigate.hover>
        {{ __('Targetas Madre') }}
    </x-nav-link>
    <x-nav-link href="{{ route('componentes.targeta_video') }}" :active="request()->routeIs('componentes.targeta_video')" wire:navigate.hover>
        {{ __('Targetas video') }}
    </x-nav-link>
    <x-nav-link href="{{ route('componentes.ram') }}" :active="request()->routeIs('componentes.ram')" wire:navigate.hover>
        {{ __('Ram') }}
    </x-nav-link>
    <x-nav-link href="{{ route('componentes.ssd') }}" :active="request()->routeIs('componentes.ssd')" wire:navigate.hover>
        {{ __('SSD') }}
    </x-nav-link>
    <x-nav-link href="{{ route('componentes.hdd') }}" :active="request()->routeIs('componentes.hdd')" wire:navigate.hover>
        {{ __('HDD') }}
    </x-nav-link>
    <x-nav-link href="{{ route('componentes.fuente_poder') }}" :active="request()->routeIs('componentes.fuente_poder')" wire:navigate.hover>
        {{ __('Fuentes Poder') }}
    </x-nav-link>
    <x-nav-link href="{{ route('componentes.gabinete') }}" :active="request()->routeIs('componentes.gabinete')" wire:navigate.hover>
        {{ __('Gabinetes') }}
    </x-nav-link>
</nav>
<nav class="hidden gap-3 max-md:block">
    <x-button-routing href="{{ route('componentes.index') }}" :active="request()->routeIs('componentes.index')" wire:navigate.hover>
        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-corner-down-left-double"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 5v6a3 3 0 0 1 -3 3h-7" /><path d="M13 10l-4 4l4 4m-5 -8l-4 4l4 4" /></svg>{{ __('Regresar') }} 
    </x-button-routing>
</nav>

