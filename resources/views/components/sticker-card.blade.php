@props(['sticker'])

<article
    class="group flex rounded-md max-w-sm flex-col overflow-hidden border border-gray-300 bg-gray-50 text-gray-600 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
    <div class=" overflow-hidden">
        <img src="{{ $sticker->url_imagen_principal ? Storage::url($sticker->url_imagen_principal) : asset('img/logo.webp') }}"
            class="object-cover transition duration-700 ease-out group-hover:scale-105"
            alt="view of a coastal Mediterranean village on a hillside, with small boats in the water." />
    </div>
    <div class="flex flex-col gap-4 p-6">
        <div class="flex items-center gap-1 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 1v4m0 0h-4m4 0l-5-5">
                </path>
            </svg>
            <span>Largo: {{ $sticker->largo_cm }}cm</span>
        </div>
        <h3 class="text-balance text-xl lg:text-2xl font-bold text-gray-900 dark:text-white"
            aria-describedby="tripDescription">{{ $sticker->id }} - {{ $sticker->nombre }}</h3>
        @if ($sticker->descripcion)
            <p id="tripDescription" class="text-pretty text-sm mb-2">
                {{ $sticker->descripcion }}
            </p>
        @endif
        <a href="{{ route('stickers.read', ['slug' => $sticker->slug]) }}"
            class="whitespace-nowrap rounded-md bg-amber-500 px-4 py-2 text-center text-sm font-medium tracking-wide text-white shadow-sm transition-colors duration-150 ease-in-out hover:bg-amber-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-2 active:bg-amber-700 dark:bg-amber-600 dark:text-white dark:hover:bg-amber-500 dark:focus-visible:ring-amber-400 dark:focus-visible:ring-offset-gray-900 dark:active:bg-amber-700">
            Ver más</a>
    </div>
</article>
