@extends('layouts.app')

@section('title', $product->name . ' - Aelia Boutique')

@section('content')
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-8 space-y-16" x-data="productDetail({{ json_encode($product->variants) }})">

    <!-- Breadcrumb -->
    <nav class="text-xs text-on-surface-variant/70 uppercase tracking-widest flex gap-2 items-center">
        <a href="{{ route('home') }}" class="hover:text-primary">Inicio</a>
        <span>/</span>
        <a href="{{ route('catalog.index') }}" class="hover:text-primary">Catálogo</a>
        @if($product->categories->isNotEmpty())
            <span>/</span>
            <a href="{{ route('catalog.category', $product->categories->first()->slug) }}" class="hover:text-primary">{{ $product->categories->first()->name }}</a>
        @endif
        <span>/</span>
        <span class="text-primary font-bold line-clamp-1">{{ $product->name }}</span>
    </nav>

    <!-- Product Grid: Gallery Left + Details Right -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
        
        <!-- Left: Image Gallery with Hover/Click Thumbnails -->
        <div class="space-y-4">
            <!-- Main Active Image -->
            <div class="aspect-[3/4] bg-surface-container-low rounded-2xl overflow-hidden shadow-lg border border-outline-variant/30 relative">
                <img :src="activeImage" alt="{{ $product->name }}" class="w-full h-full object-cover transition-all duration-300">
                
                @if($product->is_on_sale)
                    <span class="absolute top-4 left-4 bg-primary text-white text-xs font-bold px-3 py-1 rounded shadow-md uppercase tracking-wider">🔥 Oferta -{{ $product->discount_percentage }}%</span>
                @endif
            </div>

            <!-- Thumbnail Carousel -->
            <div class="flex gap-3 overflow-x-auto pb-2">
                @foreach($product->images as $img)
                    <button @click="activeImage = '{{ asset('storage/' . $img->path) }}'" :class="activeImage === '{{ asset('storage/' . $img->path) }}' ? 'border-primary ring-2 ring-primary/20' : 'border-outline-variant/30'" class="w-20 h-24 rounded-lg overflow-hidden border-2 flex-shrink-0 bg-surface-container-low transition-all">
                        <img src="{{ asset('storage/' . $img->path) }}" alt="{{ $img->alt }}" class="w-full h-full object-cover">
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Right: Product Info & Variant Selectors -->
        <div class="space-y-6">
            <div>
                @if($product->categories->isNotEmpty())
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-antique-gold">{{ $product->categories->first()->name }}</span>
                @endif
                <h1 class="font-serif text-3xl md:text-4xl text-on-surface font-normal mt-1 leading-tight">{{ $product->name }}</h1>
                <p class="text-xs text-on-surface-variant/70 mt-1">SKU: <span x-text="activeSku || '{{ $product->sku }}'"></span></p>
            </div>

            <!-- Price Display -->
            <div class="flex items-baseline gap-4 border-y border-outline-variant/30 py-4">
                <span class="font-serif text-3xl font-semibold text-primary" x-text="'S/ ' + activePrice.toFixed(2)">S/ {{ number_format($product->effective_price, 2) }}</span>
                @if($product->is_on_sale && $product->sale_price)
                    <span class="text-sm text-on-surface-variant/60 line-through">S/ {{ number_format($product->base_price, 2) }}</span>
                @endif
            </div>

            <!-- Short Description -->
            @if($product->short_description)
                <p class="text-xs md:text-sm text-on-surface-variant leading-relaxed font-light">
                    {{ $product->short_description }}
                </p>
            @endif

            <!-- Variants Selection (If Has Variants) -->
            @if($product->has_variants && $product->variants->isNotEmpty())
                <div class="space-y-4 pt-2">
                    <h4 class="text-xs uppercase tracking-widest font-semibold text-primary">Selecciona tu Variante</h4>
                    
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($product->variants as $variant)
                            <button type="button" @click="selectVariant({{ $variant->id }}, {{ $variant->effective_price }}, '{{ $variant->sku }}', {{ $variant->stock }})" :class="selectedVariantId === {{ $variant->id }} ? 'border-primary bg-blush-silk text-primary font-bold shadow-sm' : 'border-outline-variant/40 bg-white text-on-surface hover:border-primary/50'" class="p-3 rounded-lg border text-xs text-left flex justify-between items-center transition-all">
                                <div>
                                    <span class="block font-medium">{{ $variant->name }}</span>
                                    <span class="text-[10px] text-on-surface-variant/70">Stock: {{ $variant->stock }}</span>
                                </div>
                                <span class="font-serif font-semibold">S/ {{ number_format($variant->effective_price, 2) }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Quantity & Add To Cart Button -->
            <div class="space-y-4 pt-4">
                <div class="flex items-center gap-4">
                    <!-- Quantity Controls -->
                    <div class="flex items-center border border-outline-variant/40 rounded-lg bg-surface">
                        <button type="button" @click="quantity = Math.max(1, quantity - 1)" class="px-4 py-3 text-sm font-semibold text-on-surface-variant hover:text-primary">-</button>
                        <span x-text="quantity" class="px-4 py-3 text-sm font-bold text-on-surface min-w-[40px] text-center">1</span>
                        <button type="button" @click="quantity = quantity + 1" class="px-4 py-3 text-sm font-semibold text-on-surface-variant hover:text-primary">+</button>
                    </div>

                    <!-- Add to Cart CTA -->
                    <button type="button" @click="submitToCart({{ $product->id }})" class="flex-grow bg-ink-black text-white py-3.5 rounded-lg text-xs uppercase tracking-widest font-semibold hover:bg-primary transition-all shadow-lg flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-sm">shopping_bag</span>
                        <span>Agregar a la Bolsa</span>
                    </button>
                </div>
            </div>

            <!-- Accordion Details (Description, Care, Shipping) -->
            <div class="border-t border-outline-variant/30 pt-6 space-y-4">
                <details class="group border-b border-outline-variant/20 pb-4" open>
                    <summary class="flex justify-between items-center cursor-pointer text-xs uppercase tracking-widest font-semibold text-primary">
                        <span>Descripción & Detalles</span>
                        <span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
                    </summary>
                    <div class="mt-3 text-xs text-on-surface-variant leading-relaxed space-y-2 font-light">
                        {!! $product->description ?? '<p>Confeccionado con la más fina selección de tejidos y acabados de boutique.</p>' !!}
                    </div>
                </details>

                <details class="group border-b border-outline-variant/20 pb-4">
                    <summary class="flex justify-between items-center cursor-pointer text-xs uppercase tracking-widest font-semibold text-primary">
                        <span>Envíos y Entregas</span>
                        <span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
                    </summary>
                    <div class="mt-3 text-xs text-on-surface-variant leading-relaxed space-y-2">
                        <p>📦 <strong>Lima Metropolitana:</strong> Entrega Express en 24 a 48 horas.</p>
                        <p>🚚 <strong>Provincias:</strong> Envíos asegurados vía Olva Courier o Shalom (2 a 4 días hábiles).</p>
                    </div>
                </details>
            </div>

        </div>

    </div>

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
        <div class="border-t border-outline-variant/30 pt-12 space-y-6">
            <div class="text-center space-y-1">
                <span class="text-xs uppercase tracking-[0.2em] text-antique-gold font-semibold">Completa tu look</span>
                <h3 class="font-serif text-2xl text-primary font-normal">Prendas Relacionadas</h3>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relProduct)
                    @include('catalog.partials.product-card', ['product' => $relProduct])
                @endforeach
            </div>
        </div>
    @endif

</div>

<script>
    function productDetail(variantsData) {
        return {
            variants: variantsData || [],
            selectedVariantId: variantsData && variantsData.length > 0 ? variantsData[0].id : null,
            activePrice: variantsData && variantsData.length > 0 ? parseFloat(variantsData[0].effective_price) : {{ $product->effective_price }},
            activeSku: variantsData && variantsData.length > 0 ? variantsData[0].sku : '{{ $product->sku }}',
            activeImage: '{{ $product->primaryImage ? asset("storage/" . $product->primaryImage->path) : ($product->images->isNotEmpty() ? asset("storage/" . $product->images->first()->path) : "") }}',
            quantity: 1,
            selectVariant(id, price, sku, stock) {
                this.selectedVariantId = id;
                this.activePrice = parseFloat(price);
                this.activeSku = sku;
            },
            submitToCart(productId) {
                window.dispatchEvent(new CustomEvent('add-to-cart', {
                    detail: {
                        productId: productId,
                        variantId: this.selectedVariantId,
                        quantity: this.quantity
                    }
                }));
            }
        }
    }
</script>
@endsection
