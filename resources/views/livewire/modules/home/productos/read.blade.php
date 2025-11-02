@php
    // --- 1. Lógica de Precios para la vista principal ---
    // ¡IMPORTANTE! Asumo que tienes un campo `precio_base` además de `precio_venta_base`.
    // Si tu campo de precio regular se llama diferente, ajústalo aquí.
    $basePrice = $product->precio_base ?? 0;
    $displayPrice = $product->precio_venta_base ?? 0;
    $isOnSale = $basePrice > 0 && $displayPrice < $basePrice;

    // Calculamos mayoreo (15% desc. sobre el precio final)
    $wholesalePrice = $displayPrice * 0.85;

    $formattedDisplayPrice = '$' . number_format($displayPrice, 2);
    $formattedBasePrice = '$' . number_format($basePrice, 2);
    $formattedWholesalePrice = '$' . number_format($wholesalePrice, 2);

    // --- 2. BUG FIX: Imagen inicial para Alpine.js ---
    // Necesita `Storage::url()` para la carga inicial.
    $firstImageUrl = $product->imagenes->first()
        ? Storage::url($product->imagenes->first()->url_imagen)
        : asset('img/placeholder-product.jpg');
@endphp
<div class="container mx-auto px-4 py-8" x-data="{
    selectedImage: '{{ $firstImageUrl }}',
    activeThumbnail: 0,
    imageZoom: false,
    zoomPosition: { x: 0, y: 0 },
    isLoaded: false, // Para animación de carga

    changeImage(imageUrl, index) {
        this.selectedImage = imageUrl;
        this.activeThumbnail = index;
        this.imageZoom = false;
    },

    handleZoom(event) {
        if (!this.imageZoom) return;
        const { left, top, width, height } = event.currentTarget.getBoundingClientRect();
        const x = ((event.clientX - left) / width) * 100;
        const y = ((event.clientY - top) / height) * 100;
        this.zoomPosition = { x, y };
    }
}" x-init="setTimeout(() => { isLoaded = true }, 150)"> {{-- Activa la animación --}}

    <nav class="mb-6 text-sm text-gray-500 dark:text-gray-400">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ route('home') }}" class="hover:text-amber-500 transition-colors">Inicio</a></li>

            <li class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <a href="{{ route('productos.index') }}" class="hover:text-amber-500 transition-colors">Productos</a>
            </li>

            <li class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-amber-500 font-medium">{{ $product->nombre }}</span>
            </li>
        </ol>
    </nav>

    <div class="flex flex-col lg:flex-row gap-8 bg-white rounded-2xl shadow-xl overflow-hidden dark:bg-gray-900 p-6">

        <div class="lg:w-1f/2">
            <div class="flex flex-col-reverse lg:flex-row gap-4">

                <div class="flex lg:flex-col gap-2 overflow-x-auto lg:overflow-x-visible lg:overflow-y-auto max-h-96">
                    @foreach ($product->imagenes as $index => $imagen)
                        <button @click="changeImage('{{ Storage::url($imagen->url_imagen) }}', {{ $index }})"
                            class="flex-shrink-0 w-16 h-16 lg:w-20 lg:h-20 rounded-xl border-2 transition-all duration-300 transform hover:scale-105 hover:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2"
                            :class="{
                                'border-amber-500 scale-105 shadow-lg shadow-amber-500/25': activeThumbnail ===
                                    {{ $index }},
                                'border-gray-200 dark:border-gray-700': activeThumbnail !== {{ $index }}
                            }">
                            <img src="{{ Storage::url($imagen->url_imagen) }}"
                                alt="{{ $product->nombre }} - Vista {{ $index + 1 }}"
                                class="w-full h-full object-cover rounded-lg">
                        </button>
                    @endforeach
                </div>

                <div class="flex-1">
                    <div class="relative overflow-hidden rounded-2xl bg-gray-100 dark:bg-gray-800 aspect-square cursor-zoom-in"
                        @mouseenter="imageZoom = true" @mouseleave="imageZoom = false" @mousemove="handleZoom">

                        <img :src="selectedImage" alt="{{ $product->nombre }}"
                            class="w-full h-full object-cover transition-transform duration-300"
                            :class="{ 'scale-150': imageZoom }"
                            :style="imageZoom ? `transform-origin: ${zoomPosition.x}% ${zoomPosition.y}%` : ''"
                            x-bind:key="selectedImage" x-transition:opacity.300ms>

                        <div class="absolute top-4 left-4">
                            <span
                                class="bg-amber-500 text-white px-3 py-1 rounded-full text-sm font-semibold shadow-lg">
                                Destacado
                            </span>
                        </div>

                        <div class="absolute bottom-4 right-4">
                            <button @click="imageZoom = !imageZoom"
                                class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-full p-2 shadow-lg transition-all duration-300 hover:bg-amber-500 hover:text-white"
                                :class="{ 'bg-amber-500 text-white': imageZoom }">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        :d="imageZoom ? 'M6 18L18 6M6 6l12 12' :
                                            'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z M10 10l-4 4m0 0l4 4m-4-4h12'">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="mt-3 text-center">
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            Imagen <span x-text="activeThumbnail + 1" class="font-semibold text-amber-500"></span>
                            de {{ $product->imagenes->count() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:w-1/2 lg:pl-8" x-show="isLoaded" x-transition:enter="transition ease-out duration-500 delay-200"
            x-transition:enter-start="opacity-0 translate-y-4 lg:translate-y-0 lg:translate-x-4"
            x-transition:enter-end="opacity-100 translate-y-0 lg:translate-x-0">
            <div class="space-y-6">

                <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-mono tracking-widest text-amber-400 uppercase">
                            Clave: #{{ $product->id }}
                        </span>
                        <span
                            class="text-sm font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-full">
                            {{ $product->categoria }}
                        </span>
                    </div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-4 dark:text-white tracking-tight leading-tight">
                        {{ $product->nombre }}
                    </h1>
                    <p class="text-gray-600 text-lg leading-relaxed dark:text-gray-300">
                        {{ $product->descripcion }}
                    </p>
                </div>

                <div class="space-y-4 pt-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-8 bg-amber-500 rounded-full"></div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Especificaciones
                        </h3>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Unidad</span>
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        {{ $product->unidad }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Categoría</span>
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        {{ $product->categoria }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-4 border-t border-gray-200 pt-6 mt-6 dark:border-gray-700">
                    @if (
                        $product->vendible_sin_personalizar == 0 &&
                            (isset($product->descripciones[$tecnica_id]) && $product->descripciones[$tecnica_id]->precio_unitario != 0.0))
                        <div class="space-y-2">
                            <div class="flex items-baseline gap-2">
                                <span class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{ '$' . number_format($product->descripciones[$tecnica_id]->precio_unitario, 2) }}
                                </span>
                                <span class="text-lg font-semibold text-gray-500 dark:text-gray-400">MXN</span>
                            </div>

                            <div class="flex flex-col">
                                <span class="text-base font-medium text-gray-700 dark:text-gray-300">
                                    Precio Mayoreo:
                                    <strong class="text-green-600 dark:text-green-500">
                                        {{ '$' . number_format($product->descripciones[$tecnica_id]->precio_mayoreo, 2) . ' MXN' }}
                                    </strong>
                                </span>
                                <span class="text-base font-medium text-gray-700 dark:text-gray-300">
                                    A partir de:
                                    <strong class="text-green-600 dark:text-green-500">
                                        {{ $product->descripciones[$tecnica_id]->catidad_mayoreo . ' ' . $product->unidad }}
                                    </strong>
                                </span>
                            </div>
                        </div>
                    @else
                        <div>
                            <a href="https://wa.me/5632220120" target="_blank"
                                class="flex w-full items-center justify-center gap-2.5 rounded-lg bg-green-600 px-8 py-3 text-center text-base font-semibold text-white shadow-sm transition-all duration-300 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-offset-gray-900">

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-brand-whatsapp h-5 w-5">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
                                    <path
                                        d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" />
                                </svg>

                                Cotizar por WhatsApp
                            </a>
                        </div>
                    @endif
                </div>

                @if ($product->descripciones)
                    <div
                        class="space-y-4 rounded-xl border border-gray-200 bg-gray-50 p-4 pt-4 dark:border-gray-700 dark:bg-gray-800/50">
                        <div class="flex items-center space-x-3">
                            <div class="h-8 w-2 rounded-full bg-amber-500"></div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                ¿En qué puede ir el diseño?
                            </h3>
                        </div>

                        <div class="w-full grid grid-cols-1 gap-4 md:grid-cols-2" x-data="{ tecnica_id: @entangle('tecnica_id').live }">
                            @foreach ($product->descripciones as $item)
                                <div class="w-full">
                                    <input type="radio" x-model="tecnica_id" value="{{ $item->id }}"
                                        id="tecnica-{{ $item->id }}" name="tecnica_seleccion"
                                        class="sr-only peer">

                                    <label for="tecnica-{{ $item->id }}"
                                        class="flex w-full cursor-pointer items-center justify-between rounded-xl border border-gray-300 bg-white p-4 shadow-sm transition-all duration-300 dark:border-gray-700 dark:bg-gray-800
                               hover:border-amber-400 hover:shadow-md
                               dark:hover:border-amber-600
                               peer-checked:border-amber-500 peer-checked:bg-amber-50
                               peer-checked:ring-2 peer-checked:ring-amber-500 peer-checked:ring-offset-2 dark:peer-checked:bg-amber-900/30 dark:ring-offset-gray-800"
                                        title="{{ $item->tecnica }}">

                                        <div class="flex-1">
                                            <span class="block text-base font-bold text-amber-600 dark:text-amber-400">
                                                {{ $item->tecnica }}
                                            </span>
                                            <span class="mt-1 block text-sm text-gray-600 dark:text-gray-400">
                                                {{ $item->descripcion }}
                                            </span>
                                        </div>

                                        <div
                                            class="ml-4 flex-shrink-0 text-amber-600 opacity-0 transition-opacity duration-300 peer-checked:opacity-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="h-6 w-6">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if ($relatedProducts->isNotEmpty())
        <div class="mt-16">
            <div class="flex items-center space-x-3 mb-8">
                <div class="w-2 h-8 bg-amber-500 rounded-full"></div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Productos Relacionados</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($relatedProducts as $relatedProduct)
                    @php
                        $relatedImageUrl = $relatedProduct->imagenes->first()?->url_imagen ?? asset('img/logo.webp');
                    @endphp
                    <x-product-card :slug="$relatedProduct->slug" :id="$relatedProduct->id" :name="$relatedProduct->nombre" :description="$relatedProduct->descripcion"
                        :price="$relatedProduct->precio_base ?? 0" :salePrice="$relatedProduct->precio_venta_base" :unit="$relatedProduct->unidad->nombre" :category="$relatedProduct->categoria->nombre" :image="$relatedImageUrl"
                        show-category="true" show-badge="true" />
                @endforeach
            </div>
        </div>
    @endif
</div>
