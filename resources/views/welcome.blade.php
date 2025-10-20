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
    <header id="hero-header"
        class="min-h-screen flex flex-col lg:flex-row overflow-hidden text-white relative
            bg-cover bg-center
            bg-black hero-mobile-bg"
        style="background-position: 70% center;">

        <div class="absolute inset-0 bg-black/70 lg:hidden z-0"></div>

        <div class="w-full lg:w-3/5 p-8 md:p-20 flex flex-col justify-center relative z-10" x-data="{ animated: false }">

            <p id="headline-kicker"
                class="text-sm tracking-widest uppercase mb-4 text-amber-400 text-initial-hidden transform translate-y-4 opacity-0 font-mono">
                // BIENVENIDOS
            </p>

            <h1 id="headline-title"
                class="text-6xl md:text-8xl lg:text-9xl font-black leading-tight mb-6 text-initial-hidden transform translate-y-8 opacity-0 font-marker tracking-tight">
                TWO <br> <span class="text-amber-400">BROTHERS</span>
            </h1>

            <p id="headline-subtitle"
                class="text-xl md:text-2xl max-w-xl mb-12 text-gray-300 text-initial-hidden transform translate-y-4 opacity-0 font-light">
                STICKERS & DESIGN - Dale un toque único a tu máquina.
            </p>

            <a id="get-started-btn" href="{{ route('productos') }}"
                class="w-max px-10 py-4 text-lg bg-amber-400 text-gray-900 font-bold transition duration-300
                   hover:shadow-[0_0_15px_rgba(163,230,53,0.7)] hover:scale-[1.03] transform scale-90 opacity-0 relative overflow-hidden group">
                VER PRODUCTOS
                <span
                    class="absolute top-0 left-0 w-full h-full bg-white opacity-0 group-hover:opacity-10 transition duration-300"></span>
            </a>
        </div>

        <div class="hidden lg:flex w-2/5 relative">
            <img id="motorcycle-img" src="{{ asset('img/duck.webp') }}" alt="Moto deportiva negra personalizada"
                class="object-cover w-full h-full relative opacity-80 transition duration-500 ease-out"
                style="object-position: 70% center; filter: brightness(0.8);">

            <div class="absolute inset-0 bg-gradient-to-l from-black/20 to-black lg:to-transparent"></div>
        </div>
    </header>

    <section id="promise-section" class="py-16 md:py-24">
        <div class="text-center max-w-3xl mx-auto mb-12 px-4">
            <p id="promise-kicker"
                class="text-sm tracking-widest uppercase mb-3 text-amber-400 font-mono opacity-0 transform translate-y-5">
                // Nuestra Promesa
            </p>
            <h2 id="promise-title"
                class="text-4xl md:text-5xl font-extrabold leading-tight opacity-0 transform translate-y-5">
                Diseñamos el arte que te hace único.
            </h2>
        </div>
        @php
            $caracters = [
                [
                    'name' => 'Diseño de Impacto',
                    'description' => 'Transformamos ideas audaces en piezas únicas que te hacen destacar.',
                    'svg' => 'svg/bolt.svg', // Asume que tienes un SVG de un rayo o destello
                ],
                [
                    'name' => 'Alta Resistencia',
                    'description' => 'Vinilos de grado profesional que soportan las condiciones más extremas.',
                    'svg' => 'svg/shield.svg', // Asume que tienes un SVG de un escudo
                ],
                [
                    'name' => 'Personalización Total',
                    'description' => 'Tu visión, nuestro arte. Diseños 100% a medida para tu estilo.',
                    'svg' => 'svg/wand.svg', // Asume que tienes un SVG de una varita mágica
                ],
            ];
        @endphp

        <div id="promise-grid" class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto px-4">
            @foreach ($caracters as $item)
                <article
                    class="promise-card p-8 border-2 border-gray-700 rounded-xl flex flex-col items-center text-center transition duration-300 hover:border-amber-400 hover:shadow-amber-400/30 hover:shadow-2xl opacity-0 transform translate-y-10">

                    <div class="w-16 h-16 mb-6 text-amber-400">
                        {!! file_get_contents(public_path($item['svg'])) !!}
                    </div>

                    <h3 class="text-2xl font-bold mb-3 text-white">
                        {{ $item['name'] }}
                    </h3>
                    <p class="text-gray-400 text-lg">
                        {{ $item['description'] }}
                    </p>
                </article>
            @endforeach
        </div>
    </section>

    <section id="cta-section" class="relative bg-gray-900 py-20 sm:py-28 bg-cover bg-center bg-fixed"
        style="background-image: url('{{ asset('img/r3.webp') }}')">

        <div class="absolute inset-0 bg-black/70"></div>

        <div class="relative max-w-4xl mx-auto text-center px-6">

            <p id="cta-kicker"
                class="text-sm tracking-widest uppercase mb-4 text-amber-400 font-mono opacity-0 transform translate-y-5">
                // ¿QUÉ SIGUE?
            </p>

            <h2 id="cta-title"
                class="text-4xl md:text-6xl font-black leading-tight mb-6 text-white opacity-0 transform translate-y-5">
                Transforma tu Máquina Hoy
            </h2>

            <p id="cta-subtitle"
                class="text-xl text-gray-300 max-w-2xl mx-auto mb-10 opacity-0 transform translate-y-5">
                No esperes más para darle esa personalidad única que te representa. Explora nuestros productos o
                cuéntanos tu idea más audaz.
            </p>

            <div id="cta-buttons"
                class="flex flex-col sm:flex-row justify-center items-center gap-4 sm:gap-6 opacity-0 transform translate-y-5">

                <a href="{{ route('productos') }}"
                    class="w-full sm:w-auto px-10 py-4 text-lg bg-amber-400 text-gray-900 font-bold rounded-md transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-[0_0_15px_rgba(251,191,36,0.6)]">
                    VER PRODUCTOS
                </a>

                <a href="#"
                    class="w-full sm:w-auto px-10 py-4 text-lg bg-transparent border-2 border-amber-400 text-amber-400 font-bold rounded-md transition duration-300 ease-in-out transform hover:scale-105 hover:bg-amber-400 hover:text-gray-900">
                    DISEÑO PERSONALIZADO
                </a>
            </div>
        </div>
    </section>

    <x-home.footer />

    @stack('modals')
    @livewireScripts
    <script>
        gsap.registerPlugin(ScrollTrigger);
        // Animación para el texto
        gsap.timeline({
                onComplete: () => animated = true
            })
            .to('#headline-kicker', {
                opacity: 1,
                y: 0,
                duration: 0.5,
                ease: 'power2.out'
            })
            .to('#headline-title', {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power2.out'
            }, '-=0.3')
            .to('#headline-subtitle', {
                opacity: 1,
                y: 0,
                duration: 0.6,
                ease: 'power2.out'
            }, '-=0.5')
            .to('#get-started-btn', {
                opacity: 1,
                scale: 1,
                duration: 0.5,
                ease: 'back.out(1.7)'
            }, '-=0.4');

        // La animación de la imagen ya no es necesaria en móvil, pero se mantiene para Desktop
        gsap.fromTo('#motorcycle-img', {
            opacity: 0,
            x: '100%'
        }, {
            opacity: 1,
            x: '0%',
            duration: 1.5,
            ease: 'power3.out'
        });

        gsap.timeline({
                scrollTrigger: {
                    trigger: '#promise-section', // El elemento que dispara la animación
                    start: 'top 80%', // La animación empieza cuando el 80% de la sección es visible
                    once: true // La animación solo se ejecuta una vez
                }
            })
            .to('#promise-kicker', {
                opacity: 1,
                y: 0,
                duration: 0.6,
                ease: 'power2.out'
            })
            .to('#promise-title', {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power2.out'
            }, '-=0.4');

        gsap.to('.promise-card', {
            scrollTrigger: {
                trigger: '#promise-grid', // Usamos el contenedor de las tarjetas como disparador
                start: 'top 85%',
                once: true
            },
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: 'power3.out',
            stagger: 0.2 // Esta es la magia: anima una tarjeta cada 0.2 segundos
        });
        gsap.timeline({
                scrollTrigger: {
                    trigger: '#cta-section', // El elemento que dispara la animación
                    start: 'top 85%', // La animación empieza cuando está un 85% visible
                    once: true // Solo se ejecuta una vez
                }
            })
            .to('#cta-kicker', {
                opacity: 1,
                y: 0,
                duration: 0.6,
                ease: 'power2.out'
            })
            .to('#cta-title', {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power2.out'
            }, '-=0.4')
            .to('#cta-subtitle', {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power2.out'
            }, '-=0.5')
            .to('#cta-buttons', {
                opacity: 1,
                y: 0,
                duration: 1.0,
                ease: 'elastic.out(1, 0.5)'
            }, '-=0.5');
    </script>
</body>

</html>
