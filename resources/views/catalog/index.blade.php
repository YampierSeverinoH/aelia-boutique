@extends('layouts.app')

@section('title', $selectedCategory ? $selectedCategory->name . ' - Aelia Boutique' : 'Colección Completa - Aelia Boutique')

@section('content')
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-8 space-y-8">

    <!-- Header Breadcrumb & Title -->
    <div class="space-y-2 border-b border-outline-variant/30 pb-6">
        <nav class="text-xs text-on-surface-variant/70 uppercase tracking-widest flex gap-2 items-center">
            <a href="{{ route('home') }}" class="hover:text-primary">Inicio</a>
            <span>/</span>
            <a href="{{ route('catalog.index') }}" class="hover:text-primary">Catálogo</a>
            @if($selectedCategory)
                <span>/</span>
                <span class="text-primary font-bold">{{ $selectedCategory->name }}</span>
            @endif
        </nav>

        <h1 class="font-serif text-3xl md:text-4xl text-primary font-normal">
            {{ $selectedCategory ? $selectedCategory->name : 'Colección Completa' }}
        </h1>
        <p class="text-xs text-on-surface-variant max-w-2xl leading-relaxed">
            {{ $selectedCategory ? ($selectedCategory->description ?? 'Explora nuestra selección exclusiva de ' . strtolower($selectedCategory->name)) : 'Descubre prendas elegantes diseñadas con acabados finos y telas de alta calidad.' }}
        </p>
    </div>

    <!-- Main Catalog Layout with Sidebar -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 items-start">
        
        <!-- Filter Sidebar (Desktop & Mobile) -->
        <form action="{{ route('catalog.index') }}" method="GET" class="space-y-6 bg-blush-silk p-6 rounded-xl border border-outline-variant/30">
            @if($selectedCategory)
                <input type="hidden" name="category" value="{{ $selectedCategory->slug }}">
            @endif

            <!-- Search Field -->
            <div class="space-y-2">
                <label class="text-xs uppercase tracking-widest font-semibold text-primary">Buscar</label>
                <div class="relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Prenda, modelo..." class="w-full text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary pl-3 pr-8 py-2">
                    @if(request('q'))
                        <a href="{{ route('catalog.index') }}" class="absolute right-2 top-2 text-xs text-on-surface-variant/60 hover:text-red-500">&times;</a>
                    @endif
                </div>
            </div>

            <!-- Categories Accordion -->
            <div class="space-y-2 border-t border-outline-variant/30 pt-4">
                <h4 class="text-xs uppercase tracking-widest font-semibold text-primary">Categorías</h4>
                <ul class="space-y-1.5 text-xs text-on-surface-variant">
                    <li>
                        <a href="{{ route('catalog.index') }}" class="hover:text-primary {{ !$selectedCategory ? 'font-bold text-primary' : '' }}">Todas las Categorías</a>
                    </li>
                    @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('catalog.category', $cat->slug) }}" class="hover:text-primary flex justify-between items-center {{ $selectedCategory && $selectedCategory->id === $cat->id ? 'font-bold text-primary' : '' }}">
                                <span>{{ $cat->name }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Special Filters (Toggles) -->
            <div class="space-y-2 border-t border-outline-variant/30 pt-4">
                <h4 class="text-xs uppercase tracking-widest font-semibold text-primary">Colecciones</h4>
                <div class="space-y-2 text-xs text-on-surface-variant">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="on_sale" value="1" {{ request('on_sale') ? 'checked' : '' }} onchange="this.form.submit()" class="rounded border-outline-variant text-primary focus:ring-primary">
                        <span>🔥 En Oferta</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="new" value="1" {{ request('new') ? 'checked' : '' }} onchange="this.form.submit()" class="rounded border-outline-variant text-primary focus:ring-primary">
                        <span>🆕 Nuevos Lanzamientos</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="featured" value="1" {{ request('featured') ? 'checked' : '' }} onchange="this.form.submit()" class="rounded border-outline-variant text-primary focus:ring-primary">
                        <span>⭐ Destacados</span>
                    </label>
                </div>
            </div>

            <!-- Color Filter Swatches -->
            @if($colors->isNotEmpty())
                <div class="space-y-2 border-t border-outline-variant/30 pt-4">
                    <h4 class="text-xs uppercase tracking-widest font-semibold text-primary">Colores</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($colors as $color)
                            <div title="{{ $color->name }}" class="w-6 h-6 rounded-full border border-black/20 shadow-xs cursor-pointer" style="background-color: {{ $color->hex_code }}"></div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Submit Action -->
            <div class="border-t border-outline-variant/30 pt-4 flex gap-2">
                <button type="submit" class="w-full bg-ink-black text-white py-2.5 rounded text-xs uppercase tracking-widest font-semibold hover:bg-primary transition-colors">Filtrar</button>
                <a href="{{ route('catalog.index') }}" class="px-3 py-2.5 border border-outline-variant/40 rounded text-xs text-center text-on-surface-variant hover:border-primary">Limpiar</a>
            </div>
        </form>

        <!-- Product Grid Header & Results -->
        <div class="md:col-span-3 space-y-6">
            <div class="flex justify-between items-center border-b border-outline-variant/20 pb-4">
                <span class="text-xs text-on-surface-variant">Mostrando <strong class="text-primary">{{ $products->total() }}</strong> prendas disponibles</span>
                
                <!-- Sorting Dropdown -->
                <form action="{{ route('catalog.index') }}" method="GET" class="flex items-center gap-2">
                    @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
                    @if($selectedCategory) <input type="hidden" name="category" value="{{ $selectedCategory->slug }}"> @endif

                    <label class="text-xs uppercase tracking-widest text-on-surface-variant font-semibold">Ordenar:</label>
                    <select name="sort" onchange="this.form.submit()" class="text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary py-1.5 px-3">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Últimas Novedades</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Precio: Menor a Mayor</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Precio: Mayor a Menor</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Más Populares</option>
                    </select>
                </form>
            </div>

            <!-- Products Grid -->
            @if($products->isNotEmpty())
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        @include('catalog.partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-16 bg-blush-silk rounded-xl border border-outline-variant/30 space-y-3">
                    <span class="material-symbols-outlined text-5xl text-outline-variant">search_off</span>
                    <h3 class="font-serif text-xl text-primary font-normal">No encontramos prendas con los filtros seleccionados</h3>
                    <p class="text-xs text-on-surface-variant">Intenta ajustar los criterios de búsqueda o explora todo el catálogo.</p>
                    <a href="{{ route('catalog.index') }}" class="inline-block bg-ink-black text-white px-6 py-2.5 rounded text-xs uppercase tracking-widest font-semibold hover:bg-primary transition-colors mt-2">Ver Toda la Colección</a>
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
