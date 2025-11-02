@props(['sticker'])

<article
    class="group flex flex-col overflow-hidden rounded-2xl bg-white text-gray-700 shadow-sm ring-1 ring-gray-200/50 transition-all duration-300 hover:shadow-xl hover:ring-gray-300 dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700/50 dark:hover:ring-gray-600">

    <!-- Imagen Container con Overlay -->
    <div class="relative overflow-hidden">
        <img
            src="{{ $sticker->url_imagen_principal ? Storage::url($sticker->url_imagen_principal) : asset('img/logo.webp') }}"
            class="h-52 w-full object-cover transition-all duration-300 group-hover:scale-105"
            alt="{{ $sticker->nombre }} - Sticker personalizado"
        />
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

        <!-- Badge flotante moderno -->
        <div class="absolute top-4 right-4">
            <span class="inline-flex items-center rounded-full bg-gradient-to-r from-amber-500 to-amber-600 px-3 py-1.5 text-xs font-semibold text-white shadow-lg">
                <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 1v4m0 0h-4m4 0l-5-5">
                    </path>
                </svg>
                {{ $sticker->largo_cm }}cm
            </span>
        </div>
    </div>

    <!-- Contenido -->
    <div class="flex flex-1 flex-col gap-4 p-6">

        <!-- Header con ID y Categoría -->
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider text-amber-500 dark:text-amber-400">
                Clave: #{{ $sticker->id }}
            </span>
            <div class="h-1 w-6 rounded-full bg-gradient-to-r from-amber-400 to-amber-500"></div>
        </div>

        <!-- Nombre del Sticker -->
        <h3 class="text-xl font-bold text-gray-900 line-clamp-2 dark:text-white leading-tight">
            {{ $sticker->nombre }}
        </h3>

        <!-- Descripción -->
        @if ($sticker->descripcion)
            <p class="text-sm text-gray-600 line-clamp-3 dark:text-gray-400 leading-relaxed">
                {{ $sticker->descripcion }}
            </p>
        @endif

        <!-- Separador decorativo -->
        <div class="my-2 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent dark:via-gray-700"></div>

        <!-- Footer con botón -->
        <div class="mt-auto pt-2">
            <a href="{{ route('stickers.read', ['slug' => $sticker->slug]) }}"
                class="group/btn inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:from-amber-600 hover:to-amber-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                <span>Explorar diseño</span>
                <svg class="w-4 h-4 transition-transform duration-200 group-hover/btn:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
        </div>
    </div>
</article>
