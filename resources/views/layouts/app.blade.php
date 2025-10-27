<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TESCH') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased dark:text-gray-50">
    <x-notification />

    <div x-data="{ sidebarIsOpen: false }" class="relative flex w-full flex-col md:flex-row">
        <!-- This allows screen readers to skip the sidebar and go directly to the main content. -->
        <a class="sr-only" href="#main-content">skip to the main content</a>

        <!-- dark overlay for when the sidebar is open on smaller screens  -->
        <div x-cloak x-show="sidebarIsOpen" class="fixed inset-0 z-20 bg-gray-800 backdrop-blur-xs md:hidden"
            aria-hidden="true" x-on:click="sidebarIsOpen = false" x-transition.opacity></div>

        <nav x-cloak
            class="fixed left-0 z-30 flex h-svh w-60 shrink-0 flex-col border-r border-gray-300 bg-gray-50 p-4 transition-transform duration-300 md:w-64 md:translate-x-0 md:relative dark:border-gray-900 dark:bg-gray-800"
            x-bind:class="sidebarIsOpen ? 'translate-x-0' : '-translate-x-60'" aria-label="sidebar navigation">
            <!-- logo  -->
            <a href="#" class="ml-2 w-fit text-2xl font-bold text-gray-900 dark:text-white">
                <img src="{{ asset('img/logo.webp') }}" alt="logo two broters" class="hidden dark:block">
            </a>

            <!-- sidebar links  -->
            <div class="flex flex-col gap-2 overflow-y-auto pb-6 mt-8">
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" @class([
                            'flex items-center rounded-sm gap-2 px-2 py-1.5 text-sm font-medium text-gray-600 underline-offset-2 hover:bg-gray-900/5 hover:text-gray-900 focus-visible:underline focus:outline-hidden dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white',
                            'bg-gray-100 dark:bg-white/10 font-bold' => request()->routeIs('admin.dashboard'),
                        ])>
                            {!! file_get_contents(public_path('svg/home.svg')) !!}
                            <span>Panel</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.disenos.index') }}" @class([
                            'flex items-center rounded-sm gap-2 px-2 py-1.5 text-sm font-medium text-gray-600 underline-offset-2 hover:bg-gray-900/5 hover:text-gray-900 focus-visible:underline focus:outline-hidden dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white',
                            'bg-gray-100 dark:bg-white/10 font-bold' => request()->routeIs('admin.disenos.*'),
                        ])>
                            {!! file_get_contents(public_path('svg/masks-theater.svg')) !!}
                            <span>Diseños</span>
                        </a>
                    </li>
                    @php
                        $catalogos = [
                            [
                                'nombre' => 'Categoria',
                                'route' => 'admin.catalogos.categorias',
                            ],
                            [
                                'nombre' => 'Subcategoria',
                                'route' => 'admin.catalogos.subcategorias',
                            ],
                            [
                                'nombre' => 'Marcas',
                                'route' => 'admin.catalogos.marcas',
                            ],
                            [
                                'nombre' => 'Modelos',
                                'route' => 'admin.catalogos.modelos',
                            ],
                            [
                                'nombre' => 'Unidades',
                                'route' => 'admin.catalogos.unidades',
                            ],
                            [
                                'nombre' => 'Colores',
                                'route' => 'admin.catalogos.colores',
                            ],
                            [
                                'nombre' => 'Maquinas',
                                'route' => 'admin.catalogos.maquinas',
                            ],
                        ];
                    @endphp
                    @if (count($catalogos) != 0)
                        <li>
                            <div x-data="{ isExpanded: false }" class="flex flex-col">
                                <button type="button" x-on:click="isExpanded = ! isExpanded" id="user-management-btn"
                                    aria-controls="user-management" x-bind:aria-expanded="isExpanded ? 'true' : 'false'"
                                    @class([
                                        'flex items-center justify-between rounded-sm gap-2 px-2 py-1.5 text-sm font-medium underline-offset-2 focus:outline-hidden focus-visible:underline',
                                        'bg-gray-100 dark:bg-white/10 font-bold' => request()->routeIs(
                                            'admin.catalogos.*'),
                                    ])
                                    x-bind:class="isExpanded ? 'text-neutral-900 bg-gray-900/10 dark:text-white dark:bg-white/10' :
                                        'text-neutral-600 hover:bg-gray-900/5 hover:text-neutral-900 dark:text-neutral-300 dark:hover:text-white dark:hover:bg-white/5'">
                                    {!! file_get_contents(public_path('svg/library.svg')) !!}
                                    <span class="mr-auto text-left">Catálogos</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="size-5 transition-transform rotate-0 shrink-0"
                                        x-bind:class="isExpanded ? 'rotate-180' : 'rotate-0'" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <ul x-cloak x-collapse x-show="isExpanded" aria-labelledby="user-management-btn"
                                    id="user-management">
                                    @foreach ($catalogos as $item)
                                        <li class="px-1 py-0.5 first:mt-2">
                                            <a href="{{ route($item['route']) }}" @class([
                                                'flex items-center rounded-sm gap-2 px-2 py-1.5 text-sm font-medium text-gray-600 underline-offset-2 hover:bg-gray-900/5 hover:text-gray-900 focus-visible:underline focus:outline-hidden dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white',
                                                'bg-gray-100 dark:bg-white/10 font-bold' => request()->routeIs(
                                                    $item['route']),
                                            ])>
                                                {!! file_get_contents(public_path('svg/chevron-right.svg')) !!}
                                                <span>{{ $item['nombre'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endif
                    @php
                        $usuarios = [];
                    @endphp
                    @if (count($usuarios) != 0)
                    <li>
                        <div x-data="{ isExpanded: false }" class="flex flex-col">
                            <button type="button" x-on:click="isExpanded = ! isExpanded" id="user-management-btn"
                                aria-controls="user-management" x-bind:aria-expanded="isExpanded ? 'true' : 'false'"
                                @class([
                                    'flex items-center justify-between rounded-sm gap-2 px-2 py-1.5 text-sm font-medium underline-offset-2 focus:outline-hidden focus-visible:underline',
                                    'bg-gray-100 dark:bg-white/10 font-bold' => request()->routeIs(
                                        'admin.usuarios.*'),
                                ])
                                x-bind:class="isExpanded ? 'text-neutral-900 bg-gray-900/10 dark:text-white dark:bg-white/10' :
                                    'text-neutral-600 hover:bg-gray-900/5 hover:text-neutral-900 dark:text-neutral-300 dark:hover:text-white dark:hover:bg-white/5'">
                                {!! file_get_contents(public_path('svg/users.svg')) !!}
                                <span class="mr-auto text-left">Usuarios</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="size-5 transition-transform rotate-0 shrink-0"
                                    x-bind:class="isExpanded ? 'rotate-180' : 'rotate-0'" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <ul x-cloak x-collapse x-show="isExpanded" aria-labelledby="user-management-btn"
                                id="user-management">

                                <li class="px-1 py-0.5 first:mt-2">
                                    <a href="{{ route('admin.dashboard') }}" @class([
                                        'flex items-center rounded-sm gap-2 px-2 py-1.5 text-sm font-medium text-gray-600 underline-offset-2 hover:bg-gray-900/5 hover:text-gray-900 focus-visible:underline focus:outline-hidden dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white',
                                        'bg-gray-100 dark:bg-white/10 font-bold' => request()->routeIs('admin.dashboard'),
                                    ])>
                                        {!! file_get_contents(public_path('svg/chevron-right.svg')) !!}
                                        <span>Usuarios del sistema</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </nav>

        <!-- top navbar & main content  -->
        <div class="h-svh w-full overflow-y-auto bg-white dark:bg-gray-900">
            <!-- top navbar  -->
            <nav class="sticky top-0 z-10 flex items-center justify-between border-b border-gray-300 bg-gray-50 px-4 py-2 dark:border-gray-900 dark:bg-gray-800"
                aria-label="top navibation bar">

                <!-- sidebar toggle button for small screens  -->
                <button type="button" class="md:hidden inline-block text-gray-600 dark:text-gray-300"
                    x-on:click="sidebarIsOpen = true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5"
                        aria-hidden="true">
                        <path
                            d="M0 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5-1v12h9a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM4 2H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h2z" />
                    </svg>
                    <span class="sr-only">sidebar toggle</span>
                </button>

                <!-- breadcrumbs  -->
                <div class="hidden md:inline-block text-sm font-medium text-gray-600 dark:text-gray-300"
                    aria-label="breadcrumb">
                    <h2 class="text-xl">@yield('title')</h2>
                </div>


                <!-- Profile Menu  -->
                <div x-data="{ userDropdownIsOpen: false }" class="relative" x-on:keydown.esc.window="userDropdownIsOpen = false">
                    <button type="button"
                        class="flex w-full items-center rounded-sm gap-2 p-2 text-left text-gray-600 hover:bg-gray-900/5 hover:text-gray-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white dark:focus-visible:outline-white"
                        x-bind:class="userDropdownIsOpen ? 'bg-gray-900/10 dark:bg-white/10' : ''" aria-haspopup="true"
                        x-on:click="userDropdownIsOpen = ! userDropdownIsOpen"
                        x-bind:aria-expanded="userDropdownIsOpen">
                        {!! file_get_contents(public_path('svg/user-circle.svg')) !!}
                        <div class="hidden md:flex flex-col">
                            <span
                                class="text-sm font-bold text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                            <span class="text-xs" aria-hidden="true">{{ Auth::user()->email }}</span>
                            <span class="sr-only">profile settings</span>
                        </div>
                    </button>

                    <!-- menu -->
                    <div x-cloak x-show="userDropdownIsOpen"
                        class="absolute top-14 right-0 z-20 h-fit w-48 border divide-y divide-gray-300 border-gray-300 bg-white dark:divide-gray-700 dark:border-gray-700 dark:bg-gray-950 rounded-sm"
                        role="menu" x-on:click.outside="userDropdownIsOpen = false"
                        x-on:keydown.down.prevent="$focus.wrap().next()"
                        x-on:keydown.up.prevent="$focus.wrap().previous()" x-transition=""
                        x-trap="userDropdownIsOpen">

                        <div class="flex flex-col py-1.5">
                            <a href="{{ route('profile.show') }}"
                                class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium text-gray-600 underline-offset-2 hover:bg-gray-900/5 hover:text-gray-900 focus-visible:underline focus:outline-hidden dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white"
                                role="menuitem">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="size-5 shrink-0" aria-hidden="true">
                                    <path
                                        d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 0 0-13.074.003Z" />
                                </svg>
                                <span>Perfil</span>
                            </a>
                        </div>

                        <div class="flex flex-col py-1.5">
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <a href="{{ route('logout') }}" @click.prevent="$root.submit();"
                                    class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium text-gray-600 underline-offset-2 hover:bg-gray-900/5 hover:text-gray-900 focus-visible:underline focus:outline-hidden dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white"
                                    role="menuitem">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="size-5 shrink-0" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-2a.75.75 0 0 1 1.5 0v2A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25Z"
                                            clip-rule="evenodd" />
                                        <path fill-rule="evenodd"
                                            d="M6 10a.75.75 0 0 1 .75-.75h9.546l-1.048-.943a.75.75 0 1 1 1.004-1.114l2.5 2.25a.75.75 0 0 1 0 1.114l-2.5 2.25a.75.75 0 1 1-1.004-1.114l1.048-.943H6.75A.75.75 0 0 1 6 10Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Cerrar seción</span>
                                </a>
                            </form>

                        </div>
                    </div>
                </div>
            </nav>
            <!-- main content  -->
            <main id="main-content" class="p-5">
                <div class="overflow-y-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('modals')

    @livewireScripts
</body>

</html>
