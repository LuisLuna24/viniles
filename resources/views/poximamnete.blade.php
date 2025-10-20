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

<body class="bg-neutral-50 dark:bg-neutral-900 dark:text-neutral-50 text-neutral-900">
    <x-home.nav />

    <div
        class="max-w-4xl w-full mx-auto p-8 md:p-16 rounded-xl shadow-2xl
                text-center
                bg-white/90 dark:bg-neutral-900/95
                backdrop-blur-sm
                ring-1 ring-gray-200 dark:ring-neutral-800 md:mt-10">

        <div class="mb-8 flex justify-center">
            <img src="{{ asset('img/logo.webp') }}" alt="logo two brothers">
        </div>

        <h2
            class="text-5xl md:text-6xl font-black mb-6 leading-tight
                   text-gray-900 dark:text-neutral-50">
            Estamos Construyendo Algo <span class="text-orange-600 dark:text-orange-400">Grande</span>.
        </h2>
        <p class="text-xl max-w-2xl mx-auto mb-10
                  text-gray-600 dark:text-neutral-300">
            Estamos diseñando nuestra presencia en línea para reflejar la calidad y la solidez de nuestros productos.
            Nuestro sitio web completo estará listo **Próximamente**.
        </p>

        <hr class="my-10 border-gray-200 dark:border-neutral-700">

        <div
            class="flex flex-col md:flex-row justify-between items-center
                    text-gray-700 dark:text-neutral-300">

            <div class="mb-6 md:mb-0 flex justify-start flex-col">
                <p class="font-bold text-lg md:text-start">¿Quieres una cotización?</p>
                <p class="text-lg md:text-start">
                    Cel. <a href="https://wa.me/525632220120" target="_blank"
                        class="text-orange-600 hover:text-orange-700 dark:text-orange-400 dark:hover:text-orange-500 font-medium">(+52)
                        56 3222 0120</a>
                </p>
                <p class="text-lg md:text-start">
                    Correo. <a href="mailto:twobroters37@gmail.com"
                        class="text-orange-600 hover:text-orange-700 dark:text-orange-400 dark:hover:text-orange-500 font-medium">twobroters37@gmail.com</a>
                </p>
            </div>

            <div class="flex space-x-4">
                <a href="https://www.tiktok.com/@two.brothers1440?_t=ZS-903lKdlJKJp&_r=1"
                    class="text-gray-500 hover:text-orange-600 dark:text-neutral-500 dark:hover:text-orange-400 transition duration-300"
                    aria-label="LinkedIn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-brand-tiktok w-6 h-6">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M21 7.917v4.034a9.948 9.948 0 0 1 -5 -1.951v4.5a6.5 6.5 0 1 1 -8 -6.326v4.326a2.5 2.5 0 1 0 4 2v-11.5h4.083a6.005 6.005 0 0 0 4.917 4.917z" />
                    </svg>
                </a>
                <a href="https://www.facebook.com/profile.php?id=61581596961267"
                    class="text-gray-500 hover:text-orange-600 dark:text-neutral-500 dark:hover:text-orange-400 transition duration-300"
                    aria-label="LinkedIn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-brand-facebook w-6 h-6">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                    </svg>
                </a>
                <a href="https://www.instagram.com/twobroters1440"
                    class="text-gray-500 hover:text-orange-600 dark:text-neutral-500 dark:hover:text-orange-400 transition duration-300"
                    aria-label="Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-brand-instagram w-6 h-6">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 8a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4z" />
                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                        <path d="M16.5 7.5v.01" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    @stack('modals')
    @livewireScripts
</body>

</html>
