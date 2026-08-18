@extends('layouts.bio')

@section('content')
<!-- Left Side: Immersive Image -->
<div class="hidden md:block md:w-1/2 h-screen relative">
    @if(optional($company)->imagen_bio)
        <img alt="Aelia Boutique Fashion Editorial" class="absolute inset-0 w-full h-full object-cover" src="{{ asset('storage/' . $company->imagen_bio) }}" />
    @else
        <img alt="Aelia Boutique Fashion Editorial" class="absolute inset-0 w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBiyrBXYHzrroxFNOwybTx5NcceTgMZOVNEFu1IXTY2jK1f_JDGUHVwA7eHosA1E8QiCVskit-M--OzbK0z_CI1BHIwSmfv97w0VPCpXHUGu6n5P-tcTPVZMbSmALgDZGL32KHIiT03cKS2vtbr61eqBTp2y9eV_5E-BZJK-a0IuZ45ngucWEtuZPVV4f4ACnR9TWstgZr-FyEwKGentdzQ5eJVJvR9ReGteLB3sMpwLTjPYYD-hxAu" />
    @endif
    <div class="absolute inset-0 bg-black/10"></div>
</div>

<!-- Right Side: Link Tree -->
<main class="w-full md:w-1/2 min-h-screen flex flex-col justify-center items-center p-margin-mobile md:p-margin-desktop bg-surface z-10 relative overflow-y-auto">
    <div class="w-full max-w-md mx-auto flex flex-col items-center py-6">
        <!-- Logo Header -->
        <div class="mb-stack-lg flex flex-col items-center">
            <div class="w-32 h-32 md:w-40 md:h-40 rounded-full overflow-hidden mb-stack-md shadow-lg relative bg-black flex items-center justify-center p-2">
                @if(optional($company)->logo)
                    <img alt="Aelia Boutique Logo" class="w-full h-full object-contain" src="{{ asset('storage/' . $company->logo) }}" />
                @else
                    <div class="flex flex-col items-center justify-center text-center text-white">
                        <span class="font-serif text-2xl font-normal tracking-wider text-[#E5A8B1]">Aelia</span>
                        <span class="text-[9px] uppercase tracking-[0.3em] text-[#C5A059] -mt-1 font-semibold">Boutique</span>
                    </div>
                @endif
            </div>
            <h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary text-center tracking-wide">
                Aelia Boutique
            </h1>
            <p class="font-title-lg text-title-lg text-secondary/80 mt-2 text-center uppercase tracking-[0.2em]">
                Elegancia Sin Esfuerzo
            </p>
        </div>

        <!-- Links Container -->
        <div class="w-full flex flex-col gap-stack-sm md:gap-stack-md">
            <!-- Primary Action (Store) -->
            <a class="primary-link-btn rounded-xl p-4 w-full flex items-center justify-between group cursor-pointer text-white" href="{{ route('home') }}">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">storefront</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-white/80 uppercase tracking-widest">Explorar</span>
                        <span class="font-body-lg text-body-lg font-semibold">Tienda Virtual</span>
                    </div>
                </div>
                <span class="material-symbols-outlined text-white/80 group-hover:text-white transition-colors group-hover:translate-x-1 duration-300">arrow_forward</span>
            </a>

            <!-- WhatsApp Direct -->
            @if(!empty(optional($company)->telefono))
            <a class="link-btn rounded-xl p-4 w-full flex items-center justify-between group cursor-pointer text-on-surface" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $company->telefono) }}" target="_blank">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-[#25D366]/10 flex items-center justify-center text-[#25D366]">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">chat</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-secondary/70 uppercase tracking-widest">Whatsapp</span>
                        <span class="font-body-md text-body-md text-on-surface/90">Escríbenos directo</span>
                    </div>
                </div>
                <span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors">north_east</span>
            </a>
            @endif

            <!-- Instagram -->
            @if(!empty(optional($company)->link_instagram))
            <a class="link-btn rounded-xl p-4 w-full flex items-center justify-between group cursor-pointer text-on-surface" href="{{ $company->link_instagram }}" target="_blank">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-[#f9ce34]/10 via-[#ee2a7b]/10 to-[#6228d7]/10 flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 opacity-20 bg-gradient-to-tr from-[#f9ce34] via-[#ee2a7b] to-[#6228d7]"></div>
                        <span class="material-symbols-outlined text-[#ee2a7b] z-10" style="font-variation-settings: 'FILL' 1;">photo_camera</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-secondary/70 uppercase tracking-widest">Instagram</span>
                        <span class="font-body-md text-body-md text-on-surface/90">Nuestras colecciones</span>
                    </div>
                </div>
                <span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors">north_east</span>
            </a>
            @endif

            <!-- TikTok -->
            @if(!empty(optional($company)->link_tiktok))
            <a class="link-btn rounded-xl p-4 w-full flex items-center justify-between group cursor-pointer text-on-surface" href="{{ $company->link_tiktok }}" target="_blank">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-black/5 flex items-center justify-center text-ink-black">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">play_arrow</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-secondary/70 uppercase tracking-widest">Tiktok</span>
                        <span class="font-body-md text-body-md text-on-surface/90">Síguenos y mira nuestros videos</span>
                    </div>
                </div>
                <span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors">north_east</span>
            </a>
            @endif

            <!-- Facebook -->
            @if(!empty(optional($company)->link_facebook))
            <a class="link-btn rounded-xl p-4 w-full flex items-center justify-between group cursor-pointer text-on-surface" href="{{ $company->link_facebook }}" target="_blank">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-[#1877F2]/10 flex items-center justify-center text-[#1877F2]">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">public</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-secondary/70 uppercase tracking-widest">Facebook</span>
                        <span class="font-body-md text-body-md text-on-surface/90">Página oficial</span>
                    </div>
                </div>
                <span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors">north_east</span>
            </a>
            @endif

            <!-- YouTube -->
            @if(!empty(optional($company)->link_youtube))
            <a class="link-btn rounded-xl p-4 w-full flex items-center justify-between group cursor-pointer text-on-surface" href="{{ $company->link_youtube }}" target="_blank">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-red-600/10 flex items-center justify-center text-red-600">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">video_library</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-secondary/70 uppercase tracking-widest">YouTube</span>
                        <span class="font-body-md text-body-md text-on-surface/90">Canal oficial</span>
                    </div>
                </div>
                <span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors">north_east</span>
            </a>
            @endif

            <!-- LinkedIn -->
            @if(!empty(optional($company)->link_linkedin))
            <a class="link-btn rounded-xl p-4 w-full flex items-center justify-between group cursor-pointer text-on-surface" href="{{ $company->link_linkedin }}" target="_blank">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-[#0A66C2]/10 flex items-center justify-center text-[#0A66C2]">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">work</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-secondary/70 uppercase tracking-widest">LinkedIn</span>
                        <span class="font-body-md text-body-md text-on-surface/90">Perfil profesional</span>
                    </div>
                </div>
                <span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors">north_east</span>
            </a>
            @endif

            <!-- Location -->
            @if(!empty(optional($company)->direccion))
            <a class="link-btn rounded-xl p-4 w-full flex items-center justify-between group cursor-pointer text-on-surface" href="{{ route('pages.contact') }}">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-error/10 flex items-center justify-center text-error">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">location_on</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-secondary/70 uppercase tracking-widest">Ubicación</span>
                        <span class="font-body-md text-body-md text-on-surface/90">{{ $company->direccion }}</span>
                    </div>
                </div>
                <span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors">north_east</span>
            </a>
            @endif
        </div>

        <!-- Footer Indicator -->
        <div class="mt-section-gap pt-stack-md flex items-center justify-center w-full">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/5 border border-primary/10">
                <div class="w-2 h-2 rounded-full bg-primary animate-pulse"></div>
                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Atención disponible 24/7</span>
            </div>
        </div>
    </div>
</main>
@endsection
