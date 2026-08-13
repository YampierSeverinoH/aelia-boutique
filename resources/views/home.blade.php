@extends('layouts.app')

@section('title', 'Aelia Boutique - Tienda Virtual')

@section('content')
<div class="space-y-16 py-6">

    <!-- Hero Banner Slider / Feature -->
    @if($banners->isNotEmpty())
        @php $heroBanner = $banners->first(); @endphp
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
            <div class="relative rounded-2xl overflow-hidden bg-ink-black min-h-[420px] flex items-center shadow-xl">
                @if($heroBanner->imagen)
                    <img src="{{ asset('storage/' . $heroBanner->imagen) }}" alt="{{ $heroBanner->nombre }}" class="absolute inset-0 w-full h-full object-cover opacity-60">
                @endif
                <div class="relative z-10 p-8 md:p-16 max-w-xl text-white space-y-4">
                    @if($heroBanner->titulo)
                        <span class="inline-block px-3 py-1 bg-antique-gold/80 text-xs font-semibold uppercase tracking-widest rounded-full">{{ $heroBanner->titulo }}</span>
                    @endif
                    <h1 class="font-serif text-4xl md:text-5xl font-normal leading-tight">{{ $heroBanner->nombre }}</h1>
                    @if($heroBanner->descripcion)
                        <p class="text-sm md:text-base text-white/90 leading-relaxed font-light">{{ $heroBanner->descripcion }}</p>
                    @endif
                    <div class="pt-4">
                        <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-2 bg-white text-ink-black px-8 py-3.5 rounded-lg text-xs uppercase tracking-widest font-semibold hover:bg-primary hover:text-white transition-all shadow-lg">
                            Descubrir Colección &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Categories Cards Grid -->
    <section class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop space-y-6">
        <div class="text-center space-y-2">
            <span class="text-xs uppercase tracking-[0.2em] text-antique-gold font-semibold">Explora por Estilo</span>
            <h2 class="font-serif text-3xl text-primary font-normal">Categorías Principales</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            @foreach($categories as $cat)
                <a href="{{ route('catalog.category', $cat->slug) }}" class="group relative rounded-xl overflow-hidden bg-blush-silk p-6 flex flex-col items-center justify-center text-center border border-outline-variant/30 hover:border-primary/50 hover:shadow-md transition-all">
                    @if($cat->image)
                        <img src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}" class="w-20 h-20 object-cover rounded-full mb-3 group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-3 text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined text-2xl">apparel</span>
                        </div>
                    @endif
                    <span class="font-serif text-base text-on-surface group-hover:text-primary transition-colors font-medium">{{ $cat->name }}</span>
                    <span class="text-[10px] uppercase tracking-widest text-on-surface-variant/70 mt-1">Ver Prendas &rarr;</span>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Nuevos Lanzamientos Section -->
    <section class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop space-y-8">
        <div class="flex justify-between items-end border-b border-outline-variant/30 pb-4">
            <div>
                <span class="text-xs uppercase tracking-[0.2em] text-antique-gold font-semibold">Recién Llegados</span>
                <h2 class="font-serif text-3xl text-primary font-normal">Nuevos Lanzamientos</h2>
            </div>
            <a href="{{ route('catalog.index', ['new' => 1]) }}" class="text-xs uppercase tracking-widest font-semibold text-primary hover:text-ink-black transition-colors">Ver Todo &rarr;</a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($newReleases as $product)
                @include('catalog.partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>

    <!-- Promotional Section / Dynamic Offers -->
    @if(isset($offers) && $offers->isNotEmpty())
        @foreach($offers as $offer)
            <section class="bg-blush-silk py-16 border-y border-outline-variant/30">
                <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <div class="space-y-6">
                        <span class="inline-block px-3 py-1 bg-primary text-white text-[10px] font-semibold uppercase tracking-widest rounded-full">Oferta Especial</span>
                        <h2 class="font-serif text-4xl text-primary font-normal leading-snug">{{ $offer->titulo }}</h2>
                        @if($offer->descripcion_corta)
                            <p class="text-sm text-on-surface-variant leading-relaxed font-light">
                                {{ $offer->descripcion_corta }}
                            </p>
                        @endif
                        <div>
                            <a href="{{ $offer->target_url }}" class="inline-block bg-ink-black text-white px-8 py-3.5 rounded-lg text-xs uppercase tracking-widest font-semibold hover:bg-primary transition-colors shadow-md">
                                Explorar Ofertas Especiales &rarr;
                            </a>
                        </div>
                    </div>
                    <div class="rounded-2xl overflow-hidden max-h-96 shadow-xl border border-outline-variant/30">
                        @if($offer->imagen)
                            <img src="{{ asset('storage/' . $offer->imagen) }}" alt="{{ $offer->titulo }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=600" alt="Editorial Aelia" class="w-full h-full object-cover">
                        @endif
                    </div>
                </div>
            </section>
        @endforeach
    @else
        <!-- Fallback Promotional Section -->
        <section class="bg-blush-silk py-16 border-y border-outline-variant/30">
            <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <span class="inline-block px-3 py-1 bg-primary text-white text-[10px] font-semibold uppercase tracking-widest rounded-full">Edición Limitada</span>
                    <h2 class="font-serif text-4xl text-primary font-normal leading-snug">Elegancia & Sofisticación en Cada Detalle</h2>
                    <p class="text-sm text-on-surface-variant leading-relaxed font-light">
                        Nuestra filosofía combina siluetas clásicas con cortes contemporáneos y telas finas de algodón pima y seda. Diseñado en Perú para la mujer exigente.
                    </p>
                    <div>
                        <a href="{{ route('catalog.index', ['on_sale' => 1]) }}" class="inline-block bg-ink-black text-white px-8 py-3.5 rounded-lg text-xs uppercase tracking-widest font-semibold hover:bg-primary transition-colors">
                            Explorar Ofertas Especiales &rarr;
                        </a>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="rounded-xl overflow-hidden h-64 bg-surface-container-high shadow-md">
                        <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=600" alt="Editorial Aelia" class="w-full h-full object-cover">
                    </div>
                    <div class="rounded-xl overflow-hidden h-64 bg-surface-container-high shadow-md mt-6">
                        <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=600" alt="Editorial Aelia 2" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Productos Destacados Grid -->
    <section class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop space-y-8">
        <div class="text-center space-y-2">
            <span class="text-xs uppercase tracking-[0.2em] text-antique-gold font-semibold">Selección Exclusiva</span>
            <h2 class="font-serif text-3xl text-primary font-normal">Productos Destacados</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                @include('catalog.partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>

</div>
@endsection
