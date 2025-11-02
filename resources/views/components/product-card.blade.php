@props([
    'slug' => null,
    'id' => null,
    'name' => 'Producto',
    'description' => null,
    'salePrice' => 0, // Precio de oferta
    'price' => 0, // Precio base/regular
    'unit' => 'unidad',
    'category' => null,
    'image' => null,
    'urlImagenPrincipal' => null,
    'code' => null,
    'showCategory' => true,
    'showBadge' => true,
    'class' => '',
    'perso' => null,
])

@php
    // --- 1. Lógica de Precios Mejorada ---
    $basePrice = $price ?: 0;
    $displayPrice = $salePrice > 0 ? $salePrice : $basePrice;
    $isOnSale = $salePrice > 0 && $salePrice < $basePrice;

    // --- 2. Cálculo de Mayoreo (15% desc. sobre el precio final) ---
    $wholesalePrice = $displayPrice * 0.9;

    // --- 3. Formateo ---
    $formattedDisplayPrice = '$' . number_format($displayPrice, 2);
    $formattedBasePrice = '$' . number_format($basePrice, 2);
    $formattedWholesalePrice = '$' . number_format($wholesalePrice, 2);

    // --- 4. Lógica de Imagen ---
    $finalImage = $urlImagenPrincipal ?: $image;
    $imageUrl = $finalImage
        ? (str_starts_with($finalImage, 'http')
            ? $finalImage
            : Storage::url($finalImage))
        : asset('img/placeholder-product.jpg');

    // --- 5. Lógica de ID ---
    $productId = $id ?: $code;
@endphp

<article
    {{ $attributes->merge(['class' => "group flex flex-col overflow-hidden rounded-2xl bg-white text-gray-700 shadow-sm ring-1 ring-gray-200/50 transition-all duration-300 hover:shadow-lg dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700 dark:hover:ring-gray-600 {$class}"]) }}>

    <div class="relative overflow-hidden">
        <img src="{{ $imageUrl }}" class="h-80 w-full object-cover transition-all duration-300 group-hover:scale-105"
            alt="{{ $name }} - Producto" />

        @if ($isOnSale && $showBadge)
            <div class="absolute top-4 right-4">
                <span
                    class="inline-flex items-center rounded-full bg-gradient-to-r from-red-500 to-red-600 px-3 py-1.5 text-xs font-semibold text-white shadow-lg">
                    <svg class="w-3 h-3 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z" />
                    </svg>
                    ¡Oferta!
                </span>
            </div>
        @endif

        <div class="absolute top-4 left-4">
            <span
                class="inline-flex items-center rounded-full bg-gradient-to-r from-blue-500 to-blue-600 px-3 py-1.5 text-xs font-semibold text-white shadow-lg">
                <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                </svg>
                {{ $unit }}
            </span>
        </div>
    </div>

    <div class="flex flex-1 flex-col gap-2 p-6">

        <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider text-amber-500 dark:text-amber-400">
                Clave: #{{ $productId ?: '001' }}
            </span>
            @if ($showCategory && $category)
                <span
                    class="text-xs font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded-full">
                    {{ $category }}
                </span>
            @endif
        </div>

        <h3 class="text-2xl font-semibold text-gray-900 line-clamp-2 dark:text-white leading-tight">
            {{ $name }}
        </h3>

        <div class="mt-auto h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent dark:via-gray-700"></div>

        <div class="pt-4">
            <a href="{{ route('productos.read', ['slug' => $slug]) }}"
                class="group/btn inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:from-amber-600 hover:to-amber-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                {{ $attributes->whereStartsWith('x-') }}>
                <span>Explorar producto</span>
                <svg class="w-4 h-4 transition-transform duration-200 group-hover/btn:translate-x-0.5" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                    </path>
                </svg>
            </a>
        </div>
    </div>
</article>
