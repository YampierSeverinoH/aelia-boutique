@extends('layouts.bio')

@section('content')
<main class="w-full max-w-md mx-auto flex flex-col items-center z-10 relative py-8">
    <!-- Logo Header -->
    <div class="mb-8 flex flex-col items-center text-center">
        <div class="w-40 h-40 md:w-48 md:h-48 rounded-full overflow-hidden mb-4 border-2 border-[#C5A059]/30 shadow-2xl relative bg-black/40 p-2 flex items-center justify-center">
            @if(optional($company)->logo)
                <img src="{{ asset('storage/' . $company->logo) }}" alt="Aelia Boutique Logo" class="w-full h-full object-contain">
            @else
                <div class="flex flex-col items-center justify-center text-center">
                    <span class="font-serif text-3xl font-normal tracking-wider text-[#E5A8B1]">Aelia</span>
                    <span class="text-[10px] uppercase tracking-[0.3em] text-[#C5A059] -mt-1 font-semibold">Boutique</span>
                </div>
            @endif
        </div>
        <h1 class="font-serif text-3xl md:text-4xl text-[#E5A8B1] tracking-wide">
            Aelia Boutique
        </h1>
        <p class="text-xs text-[#C5A059]/90 mt-2 uppercase tracking-[0.25em] font-semibold">
            Elegancia Sin Esfuerzo
        </p>
    </div>

    <!-- Links Container -->
    <div class="w-full flex flex-col gap-3">
        <!-- Primary Action (Store) -->
        <a href="{{ route('home') }}" class="primary-glass-btn rounded-xl p-4 w-full flex items-center justify-between group text-white">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                    <span class="material-symbols-outlined">storefront</span>
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-[10px] text-white/80 uppercase tracking-widest font-semibold">Explorar</span>
                    <span class="text-base font-semibold">Tienda Virtual</span>
                </div>
            </div>
            <span class="material-symbols-outlined text-white/80 group-hover:text-white transition-colors group-hover:translate-x-1 duration-300">arrow_forward</span>
        </a>

        <!-- WhatsApp Direct -->
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', optional($company)->telefono ?? '51987654321') }}" target="_blank" class="glass-btn rounded-xl p-4 w-full flex items-center justify-between group text-white">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-[#25D366]/20 flex items-center justify-center text-[#25D366]">
                    <span class="material-symbols-outlined">chat</span>
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-[10px] text-[#C5A059]/80 uppercase tracking-widest font-semibold">WhatsApp</span>
                    <span class="text-sm text-white/90">Escríbenos directo</span>
                </div>
            </div>
            <span class="material-symbols-outlined text-white/40 group-hover:text-[#C5A059] transition-colors">north_east</span>
        </a>

        <!-- Instagram -->
        <a href="{{ optional($company)->link_instagram ?? 'https://instagram.com' }}" target="_blank" class="glass-btn rounded-xl p-4 w-full flex items-center justify-between group text-white">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-[#f9ce34] via-[#ee2a7b] to-[#6228d7] flex items-center justify-center opacity-90">
                    <span class="material-symbols-outlined text-white text-sm">photo_camera</span>
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-[10px] text-[#C5A059]/80 uppercase tracking-widest font-semibold">Instagram</span>
                    <span class="text-sm text-white/90">Nuestras colecciones</span>
                </div>
            </div>
            <span class="material-symbols-outlined text-white/40 group-hover:text-[#C5A059] transition-colors">north_east</span>
        </a>

        <!-- TikTok -->
        <a href="{{ optional($company)->link_tiktok ?? 'https://tiktok.com' }}" target="_blank" class="glass-btn rounded-xl p-4 w-full flex items-center justify-between group text-white">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white">
                    <span class="material-symbols-outlined">play_arrow</span>
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-[10px] text-[#C5A059]/80 uppercase tracking-widest font-semibold">TikTok</span>
                    <span class="text-sm text-white/90">Síguenos y mira nuestros videos</span>
                </div>
            </div>
            <span class="material-symbols-outlined text-white/40 group-hover:text-[#C5A059] transition-colors">north_east</span>
        </a>

        <!-- Facebook -->
        <a href="{{ optional($company)->link_facebook ?? 'https://facebook.com' }}" target="_blank" class="glass-btn rounded-xl p-4 w-full flex items-center justify-between group text-white">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-[#1877F2]/20 flex items-center justify-center text-[#1877F2]">
                    <span class="material-symbols-outlined">public</span>
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-[10px] text-[#C5A059]/80 uppercase tracking-widest font-semibold">Facebook</span>
                    <span class="text-sm text-white/90">Página oficial</span>
                </div>
            </div>
            <span class="material-symbols-outlined text-white/40 group-hover:text-[#C5A059] transition-colors">north_east</span>
        </a>

        <!-- Location -->
        <a href="{{ route('pages.contact') }}" class="glass-btn rounded-xl p-4 w-full flex items-center justify-between group text-white">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-[#825159]/30 flex items-center justify-center text-[#E5A8B1]">
                    <span class="material-symbols-outlined">location_on</span>
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-[10px] text-[#C5A059]/80 uppercase tracking-widest font-semibold">Ubicación</span>
                    <span class="text-sm text-white/90">{{ optional($company)->direccion ?? 'San Isidro, Lima - Perú' }}</span>
                </div>
            </div>
            <span class="material-symbols-outlined text-white/40 group-hover:text-[#C5A059] transition-colors">north_east</span>
        </a>
    </div>

    <!-- Footer Status Indicator -->
    <div class="mt-12 flex items-center justify-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10">
            <div class="w-2 h-2 rounded-full bg-[#9ac2a2] animate-pulse"></div>
            <span class="text-[11px] text-white/60 uppercase tracking-widest font-medium">Atención disponible 24/7</span>
        </div>
    </div>
</main>
@endsection
