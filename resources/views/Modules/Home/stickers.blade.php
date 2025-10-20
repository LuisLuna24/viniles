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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>




    <!-- Styles -->
    @livewireStyles
    <style>
        /* Estilos base para las animaciones iniciales */
        .text-initial-hidden {
            opacity: 0;
            transform: translateY(20px);
        }

        @media (max-width: 1023px) {
            .hero-mobile-bg {
                background-image: url('{{ asset('img/duck.webp') }}');
                /* Opcional: añade aquí estas propiedades si quieres que SÓLO se apliquen en móvil */
                background-size: cover;
                background-position: 70% center;
            }
        }
    </style>

</head>

<body class="bg-neutral-50 dark:bg-neutral-900 dark:text-neutral-50 text-neutral-900">
    <x-home.nav />


    @livewire('modules.home.sticker')

    <x-home.footer />
    @stack('modals')
    @livewireScripts
</body>

</html>
