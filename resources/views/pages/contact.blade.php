@extends('layouts.app')

@section('title', 'Contáctanos - Aelia Boutique')

@section('content')
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-12 space-y-12">

    <div class="text-center space-y-2 max-w-2xl mx-auto">
        <span class="text-xs uppercase tracking-[0.25em] text-antique-gold font-semibold">Atención Personalizada</span>
        <h1 class="font-serif text-4xl text-primary font-normal">Contáctanos</h1>
        <p class="text-xs text-on-surface-variant">Estamos aquí para asesorarte en la elección de tu prenda ideal.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
        
        <!-- Contact Info Box -->
        <div class="bg-blush-silk p-8 rounded-2xl border border-outline-variant/30 space-y-6">
            <h3 class="font-serif text-2xl text-primary">Atención en Boutique</h3>
            
            <div class="space-y-4 text-xs text-on-surface-variant">
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-primary">location_on</span>
                    <div>
                        <strong class="block text-on-surface">Dirección:</strong>
                        <p>{{ optional($company)->direccion ?? 'San Isidro, Lima - Perú' }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-primary">call</span>
                    <div>
                        <strong class="block text-on-surface">Teléfono / WhatsApp:</strong>
                        <p>{{ optional($company)->telefono ?? '+51 987 654 321' }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-primary">mail</span>
                    <div>
                        <strong class="block text-on-surface">Correo Electrónico:</strong>
                        <p>{{ optional($company)->correo ?? 'contacto@aeliaboutique.pe' }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-primary">schedule</span>
                    <div>
                        <strong class="block text-on-surface">Horario de Atención:</strong>
                        <p>{{ optional($company)->horario ?? 'Lunes a Sábado: 10:00 AM - 8:00 PM' }}</p>
                    </div>
                </div>
            </div>

            @if(optional($company)->ubicacion)
                <div class="pt-4 border-t border-outline-variant/20 rounded-xl overflow-hidden shadow-xs">
                    {!! $company->ubicacion !!}
                </div>
            @endif
        </div>

        <!-- Contact Message Form -->
        <div class="bg-white p-8 rounded-2xl border border-outline-variant/30 space-y-6 shadow-xs">
            <h3 class="font-serif text-2xl text-primary">Envíanos un Mensaje</h3>
            
            <form action="{{ route('pages.contact.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="space-y-1">
                    <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Nombre Completo *</label>
                    <input type="text" name="name" required placeholder="Tu nombre..." class="w-full text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary py-2.5 px-3">
                </div>
                <div class="space-y-1">
                    <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Correo Electrónico *</label>
                    <input type="email" name="email" required placeholder="tu@email.com" class="w-full text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary py-2.5 px-3">
                </div>
                <div class="space-y-1">
                    <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Teléfono / WhatsApp</label>
                    <input type="text" name="phone" placeholder="Ej: 987 654 321" class="w-full text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary py-2.5 px-3">
                </div>
                <div class="space-y-1">
                    <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Asunto</label>
                    <input type="text" name="subject" placeholder="Ej: Consulta sobre prendas en stock" class="w-full text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary py-2.5 px-3">
                </div>
                <div class="space-y-1">
                    <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Mensaje o Consulta *</label>
                    <textarea name="message" rows="4" required placeholder="Escribe tu consulta aquí..." class="w-full text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary py-2.5 px-3"></textarea>
                </div>
                <button type="submit" class="w-full bg-ink-black text-white py-3.5 rounded-lg text-xs uppercase tracking-widest font-semibold hover:bg-primary transition-colors">Enviar Consulta &rarr;</button>
            </form>
        </div>

    </div>

</div>
@endsection
