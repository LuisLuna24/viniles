<div class="container mx-auto px-4 py-8" x-data="{
    selectedGroupId: {{ !empty($product->color_groups) ? $product->color_groups[0]->id : 'null' }},
    selectedGroupName: '{{ !empty($product->color_groups) ? addslashes($product->color_groups[0]->name) : 'N/A' }}',
    selectedUnitPrice: {{ !empty($product->color_groups) ? $product->color_groups[0]->unit_price : 0 }},
    selectedWholesalePrice: {{ !empty($product->color_groups) ? $product->color_groups[0]->wholesale_price : 0 }},
    selectedImageUrl: '{{ !empty($product->color_groups) ? asset($product->color_groups[0]->image_url) : '' }}'
}">
    <div
        class="flex flex-col lg:flex-row bg-white rounded-2xl shadow-2xl overflow-hidden dark:bg-gray-900 transition-all duration-300 hover:shadow-amber-500/10">
        <!-- Imagen del producto -->
        <div class="lg:w-1/2 relative group">
            <img :src="selectedImageUrl" :alt="selectedGroupName"
                class="w-full h-80 lg:h-full object-cover transition-transform duration-500 group-hover:scale-105">
            <div class="absolute top-4 left-4">
                <span class="bg-amber-500 text-white px-3 py-1 rounded-full text-sm font-semibold shadow-lg">
                    Destacado
                </span>
            </div>
        </div>

        <!-- Contenido informativo -->
        <div class="lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center space-y-6">
            <!-- Header -->
            <div>
                <h1 class="text-4xl font-bold text-gray-900 mb-3 dark:text-white tracking-tight">
                    {{ $product->name }}
                </h1>
                <p class="text-gray-600 text-lg leading-relaxed dark:text-gray-300">
                    {{ $product->description }}
                </p>
            </div>

            <!-- Precios -->
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-amber-50 rounded-xl dark:bg-amber-900/20">
                    <span class="text-lg font-semibold text-amber-800 dark:text-amber-200">Precio Unitario</span>
                    <span class="text-3xl font-bold text-amber-600 dark:text-amber-400">
                        $<span x-text="selectedUnitPrice.toFixed(2)"></span>
                    </span>
                </div>
                <div
                    class="flex items-center justify-between p-4 bg-gradient-to-r from-amber-500 to-amber-600 rounded-xl shadow-lg">
                    <span class="text-lg font-semibold text-white">Precio Mayoreo</span>
                    <span class="text-3xl font-bold text-white">
                        $<span x-text="selectedWholesalePrice.toFixed(2)"></span>
                    </span>
                </div>
            </div>

            <!-- Selector de estilos -->
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="w-2 h-8 bg-amber-500 rounded-full"></div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Estilo:
                        <span x-text="selectedGroupName" class="text-amber-600 dark:text-amber-400"></span>
                    </h3>
                </div>

                <div class="flex flex-wrap gap-3">
                    @foreach ($product->color_groups as $group)
                        <button type="button"
                            class="p-2 rounded-2xl border-3 transition-all duration-300 transform hover:scale-105 hover:shadow-lg"
                            :class="{
                                'border-amber-500 scale-105 shadow-amber-500/25 shadow-xl bg-amber-50 dark:bg-amber-900/20': selectedGroupId ===
                                    {{ $group->id }},
                                'border-gray-200 dark:border-gray-700 hover:border-amber-300 dark:hover:border-amber-600': selectedGroupId !==
                                    {{ $group->id }}
                            }"
                            @click="
                                    selectedGroupId = {{ $group->id }};
                                    selectedGroupName = '{{ addslashes($group->name) }}';
                                    selectedUnitPrice = {{ $group->unit_price }};
                                    selectedWholesalePrice = {{ $group->wholesale_price }};
                                    selectedImageUrl = '{{ asset($group->image_url) }}';
                                "
                            title="{{ $group->name }}">
                            <div class="flex flex-wrap gap-3 p-3 bg-amber-50 rounded-2xl dark:bg-amber-900/10">
                                @foreach ($group->colors as $color)
                                    <div class="flex flex-col items-center space-y-2 group cursor-pointer">
                                        <span
                                            class="w-10 h-10 block rounded-full border-3 border-white shadow-lg transition-all duration-300 transform group-hover:scale-110 group-hover:shadow-amber-500/20"
                                            style="{{ $color->style_attribute }}" title="{{ $color->name }}">
                                        </span>
                                        <span
                                            class="text-xs font-medium text-gray-700 dark:text-gray-300 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors duration-200">
                                            {{ $color->name }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
