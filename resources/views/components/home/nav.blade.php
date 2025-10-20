@php
    $routes = [
        ['name' => 'Inicio', 'route' => 'home'],
        ['name' => 'Nosotros', 'route' => 'nosotros'],
        ['name' => 'Productos', 'route' => 'productos'],
        ['name' => 'Stickers', 'route' => 'stickers'],
        ['name' => 'Contacto', 'route' => 'contacto'],
    ];
@endphp
<nav x-data="{ mobileMenuIsOpen: false }" x-on:click.away="mobileMenuIsOpen = false"
    class="w-full flex items-center justify-between border-b border-neutral-300 px-6 py-4 dark:border-neutral-700 sticky top-0 z-50 bg-neutral-50 dark:bg-neutral-900"
    aria-label="penguin ui menu">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="text-3xl font-extrabold text-neutral-900 dark:text-white">
        <img src="{{ asset('img/logo.webp') }}" alt="logo two brothers" class=" h-12">
    </a>
    <!-- Desktop Menu -->
    <ul class="hidden items-center gap-6 sm:flex">
        @foreach ($routes as $item)
            <li>
                <a href="{{ route($item['route']) }}" @class([
                    // --- Estilos Base (Aplicados a TODOS los enlaces) ---
                    'relative font-semibold transition-all duration-300 ease-in-out group', // El 'group' es clave para el hover
                    'focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-orange-500 rounded-sm',

                    // --- Estilos de Indicador (La línea inferior) ---
                    'after:absolute after:bottom-[-8px] after:left-0 after:h-[3px] after:w-full after:rounded-full after:bg-orange-600 after:transition-transform after:duration-300 dark:after:bg-orange-400',

                    // --- ESTADO INACTIVO (Por defecto + Hover) ---
                    'text-neutral-500 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-white',
                    'after:scale-x-0 group-hover:after:scale-x-75', // La línea se muestra al 75% en hover (inactivo)

                    // --- ESTADO ACTIVO (Si la ruta coincide) ---
                    'text-orange-600 dark:text-orange-400' => request()->routeIs(
                        $item['route']),
                    'after:scale-x-100' => request()->routeIs($item['route']), // La línea se muestra completa (activo)
                ])
                    aria-current="{{ request()->routeIs($item['route']) ? 'page' : 'false' }}">
                    {{ $item['name'] }}
                </a>
            </li>
        @endforeach
    </ul>
    <!-- Mobile Menu Button -->
    <button x-on:click="mobileMenuIsOpen = !mobileMenuIsOpen" x-bind:aria-expanded="mobileMenuIsOpen"
        x-bind:class="mobileMenuIsOpen ? 'fixed top-6 right-6 z-20' : null" type="button"
        class="flex text-neutral-600 dark:text-neutral-300 md:hidden" aria-label="mobile menu"
        aria-controls="mobileMenu">
        <svg x-show="!mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-menu-2">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M4 6l16 0" />
            <path d="M4 12l16 0" />
            <path d="M4 18l16 0" />
        </svg>
        <svg x-cloak x-show="mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true"
            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
    <ul x-cloak x-show="mobileMenuIsOpen"
        x-transition:enter="transition motion-reduce:transition-none ease-out duration-300"
        x-transition:enter-start="-translate-y-full" x-transition:enter-end="translate-y-0"
        x-transition:leave="transition motion-reduce:transition-none ease-out duration-300"
        x-transition:leave-start="translate-y-0" x-transition:leave-end="-translate-y-full" id="mobileMenu"
        {{-- CLASES DEL UL CONTENEDOR --}}
        class="fixed max-h-svh overflow-y-auto inset-x-0 top-0 z-10 flex flex-col
           divide-y divide-neutral-200 rounded-b-lg border-b border-neutral-300
           bg-white px-4 pb-6 pt-20 shadow-xl
           dark:divide-neutral-800 dark:border-neutral-800 dark:bg-neutral-900
           sm:hidden">
        {{-- Cambiado md:hidden a sm:hidden para mayor compatibilidad --}}

        @foreach ($routes as $item)
            {{-- EL LI YA NO NECESITA PADDING VERTICAL, se lo damos al enlace --}}
            <li>
                <a href="{{ route($item['route']) }}" @class([
                    // --- Estilos Base ---
                    'block w-full text-left py-3 px-2 text-xl transition-all duration-200 rounded-md', // block, tamaño de fuente (xl) y padding

                    // --- ESTADO INACTIVO (Por defecto + Hover/Focus) ---
                    'font-medium text-neutral-700 hover:bg-neutral-100 hover:text-orange-600',
                    'dark:text-neutral-300 dark:hover:bg-neutral-800 dark:hover:text-orange-400',

                    // --- ESTADO ACTIVO (Si la ruta coincide) ---
                    'font-extrabold text-orange-600 bg-orange-50 dark:text-orange-400 dark:bg-neutral-800' => request()->routeIs(
                        $item['route']),
                ])
                    aria-current="{{ request()->routeIs($item['route']) ? 'page' : 'false' }}">
                    {{ $item['name'] }}
                </a>
            </li>
        @endforeach
    </ul>
</nav>
