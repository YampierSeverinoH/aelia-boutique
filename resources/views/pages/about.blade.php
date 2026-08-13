@extends('layouts.app')

@section('title', 'Nosotros - Aelia Boutique')

@section('content')
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-12 space-y-16">

    <!-- Header Hero -->
    <div class="text-center space-y-3 max-w-2xl mx-auto">
        <span class="text-xs uppercase tracking-[0.25em] text-antique-gold font-semibold">Nuestra Historia</span>
        <h1 class="font-serif text-4xl md:text-5xl text-primary font-normal">Aelia Boutique</h1>
        <p class="text-sm text-on-surface-variant leading-relaxed font-light">
            Donde la elegancia contemporánea se une a la confección artesanal peruana.
        </p>
    </div>

    <!-- Metrics Bar -->
    @if($about)
        <div class="bg-blush-silk rounded-2xl p-8 border border-outline-variant/30 grid grid-cols-3 gap-6 text-center">
            <div>
                <span class="font-serif text-3xl md:text-4xl text-primary font-bold block">{{ $about->anios }}</span>
                <span class="text-xs text-on-surface-variant uppercase tracking-wider">Años de Trayectoria</span>
            </div>
            <div>
                <span class="font-serif text-3xl md:text-4xl text-primary font-bold block">{{ $about->patentes }}</span>
                <span class="text-xs text-on-surface-variant uppercase tracking-wider">Diseños Exclusivos</span>
            </div>
            <div>
                <span class="font-serif text-3xl md:text-4xl text-primary font-bold block">{{ $about->paises }}</span>
                <span class="text-xs text-on-surface-variant uppercase tracking-wider">Presencia Internacional</span>
            </div>
        </div>
    @endif

    <!-- Trayectoria Content & Mission/Vision -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div class="space-y-6">
            <h2 class="font-serif text-3xl text-primary font-normal">Pasión por la Moda Boutique</h2>
            <div class="text-sm text-on-surface-variant leading-relaxed space-y-4 font-light">
                {!! optional($about)->trayectoria ?? '<p>Aelia Boutique fue concebida para ofrecer prendas únicas con caídas fluidas y materiales nobles.</p>' !!}
            </div>
        </div>
        <div class="space-y-6 bg-white p-8 rounded-2xl border border-outline-variant/30 shadow-xs">
            <div class="space-y-2 border-b border-outline-variant/20 pb-4">
                <h3 class="font-serif text-xl text-primary">Nuestra Misión</h3>
                <p class="text-xs text-on-surface-variant leading-relaxed">{{ optional($about)->mision }}</p>
            </div>
            <div class="space-y-2 border-b border-outline-variant/20 pb-4">
                <h3 class="font-serif text-xl text-primary">Nuestra Visión</h3>
                <p class="text-xs text-on-surface-variant leading-relaxed">{{ optional($about)->vision }}</p>
            </div>
            <div class="space-y-2">
                <h3 class="font-serif text-xl text-primary">Valores</h3>
                <p class="text-xs text-on-surface-variant leading-relaxed">{{ optional($about)->valores }}</p>
            </div>
        </div>
    </div>

</div>
@endsection
