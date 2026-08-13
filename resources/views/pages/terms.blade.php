@extends('layouts.app')

@section('title', 'Términos y Condiciones - Aelia Boutique')

@section('content')
<div class="max-w-4xl mx-auto px-margin-mobile md:px-margin-desktop py-12 space-y-8">

    <div class="border-b border-outline-variant/30 pb-6 text-center space-y-2">
        <span class="text-xs uppercase tracking-[0.2em] text-antique-gold font-semibold">Marco Legal</span>
        <h1 class="font-serif text-3xl md:text-4xl text-primary font-normal">Términos y Políticas de Privacidad</h1>
    </div>

    <div class="bg-white p-8 rounded-2xl border border-outline-variant/30 shadow-xs space-y-8 text-xs text-on-surface-variant leading-relaxed">
        <div>
            <h3 class="font-serif text-xl text-primary mb-3">Términos y Condiciones de Uso</h3>
            <div class="space-y-3 font-light">
                {!! optional($company)->terminos_condiciones ?? '<p>Bienvenido a Aelia Boutique. El uso de nuestra tienda virtual implica la aceptación incondicional de los presentes términos comerciales...</p>' !!}
            </div>
        </div>

        <div class="border-t border-outline-variant/20 pt-6">
            <h3 class="font-serif text-xl text-primary mb-3">Políticas de Privacidad de Datos</h3>
            <div class="space-y-3 font-light">
                {!! optional($company)->politicas_privacidad ?? '<p>En Aelia Boutique garantizamos el tratamiento confidencial de sus datos conforme a la Ley N° 29733 de Protección de Datos Personales en el Perú...</p>' !!}
            </div>
        </div>
    </div>

</div>
@endsection
