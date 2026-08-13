<div
    class="group bg-white rounded-xl overflow-hidden border border-outline-variant/30 hover:border-primary/40 hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
    <div class="relative aspect-[3/4] bg-surface-container-low overflow-hidden">
        <!-- Image -->
        @if ($product->primaryImage)
            <img src="{{ asset('storage/' . $product->primaryImage->path) }}" alt="{{ $product->name }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @elseif($product->images->isNotEmpty())
            <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
            <div class="w-full h-full flex items-center justify-center text-on-surface-variant/40">
                <span class="material-symbols-outlined text-4xl">apparel</span>
            </div>
        @endif

        <!-- Badges -->
        <div class="absolute top-3 left-3 flex flex-col gap-1.5 z-10">
            @if ($product->is_on_sale)
                <span
                    class="bg-primary text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider shadow">🔥
                    -{{ $product->discount_percentage }}%</span>
            @endif
            @if ($product->is_new)
                <span
                    class="bg-ink-black text-white text-[10px] font-semibold px-2 py-0.5 rounded uppercase tracking-wider shadow">🆕
                    Nuevo</span>
            @endif
        </div>

        <!-- Quick View Overlay Action -->
        <div
            class="absolute inset-x-0 bottom-0 p-3 bg-gradient-to-t from-ink-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
            <a href="{{ route('catalog.detail', $product->slug) }}"
                class="w-full bg-white text-ink-black py-2 rounded text-xs font-semibold text-center hover:bg-primary hover:text-white transition-colors uppercase tracking-wider shadow">
                Ver Detalle &rarr;
            </a>
        </div>
    </div>

    <div class="p-4 space-y-2 flex-grow flex flex-col justify-between">
        <div>
            @if ($product->categories->isNotEmpty())
                <span
                    class="text-[10px] font-semibold uppercase tracking-widest text-antique-gold">{{ $product->categories->first()->name }}</span>
            @endif
            <h3
                class="font-serif text-base text-on-surface group-hover:text-primary transition-colors font-normal leading-snug line-clamp-1">
                <a href="{{ route('catalog.detail', $product->slug) }}">{{ $product->name }}</a>
            </h3>
        </div>

        <div class="flex items-baseline justify-between pt-2 border-t border-outline-variant/20">
            <div class="flex items-baseline gap-2">
                <span class="font-serif text-base font-semibold text-primary">S/
                    {{ number_format($product->effective_price, 2) }}</span>
                @if ($product->is_on_sale && $product->sale_price)
                    <span class="text-xs text-on-surface-variant/60 line-through">S/
                        {{ number_format($product->base_price, 2) }}</span>
                @endif
            </div>

            <button
                @click="$dispatch('add-to-cart', { productId: {{ $product->id }}, variantId: {{ $product->has_variants && $product->variants->isNotEmpty() ? $product->variants->first()->id : 'null' }}, quantity: 1 })"
                title="Agregar al Carrito" class="text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-lg">add_shopping_cart</span>
            </button>
        </div>
    </div>
</div>
