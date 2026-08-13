<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aelia Boutique - Elegancia Sin Esfuerzo')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@300;400;500;600;700&family=Libre+Caslon+Text:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#825159",
                        "primary-fixed-dim": "#f5b6bf",
                        "blush-silk": "#FDF3F4",
                        "antique-gold": "#B38B4D",
                        "ink-black": "#1A1A1A",
                        "soft-gray": "#F5F5F5",
                        "surface": "#fff8f7",
                        "surface-variant": "#ebe0e0",
                        "on-surface": "#1f1a1b",
                        "on-surface-variant": "#514345",
                        "outline-variant": "#d5c2c4",
                    },
                    fontFamily: {
                        "serif": ["Libre Caslon Text", "serif"],
                        "sans": ["Hanken Grotesk", "sans-serif"],
                    },
                    spacing: {
                        "container-max": "1440px",
                        "margin-desktop": "64px",
                        "margin-mobile": "20px",
                        "gutter": "24px",
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }

        .material-symbols-outlined.fill {
            font-variation-settings: 'FILL' 1, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #d5c2c4;
            border-radius: 4px;
        }

        @keyframes marquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            display: flex;
            width: max-content;
            animation: marquee 25s linear infinite;
        }
        .animate-marquee:hover {
            animation-play-state: paused;
        }
    </style>

    <!-- Alpine.js for interactive UI -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-surface text-on-surface font-sans antialiased min-h-screen flex flex-col overflow-x-hidden"
    x-data="cartApp()"
    @add-to-cart.window="addToCart($event.detail.productId, $event.detail.variantId, $event.detail.quantity)">

    @php $companyInfo = \App\Models\Company::first(); @endphp
    <!-- Top Announcement Bar (Administrable & Animated Marquee) -->
    <div class="bg-ink-black text-white text-[11px] tracking-widest uppercase py-2.5 overflow-hidden relative border-b border-white/10">
        <div class="animate-marquee whitespace-nowrap">
            <span class="inline-block px-8">
                {{ optional($companyInfo)->mensaje_cinta ?? '✨ Aelia Boutique - Elegancia Sin Esfuerzo ✨' }}
            </span>
            <span class="inline-block px-8">
                {{ optional($companyInfo)->mensaje_cinta ?? '✨ Aelia Boutique - Elegancia Sin Esfuerzo ✨' }}
            </span>
            <span class="inline-block px-8">
                {{ optional($companyInfo)->mensaje_cinta ?? '✨ Aelia Boutique - Elegancia Sin Esfuerzo ✨' }}
            </span>
            <span class="inline-block px-8">
                {{ optional($companyInfo)->mensaje_cinta ?? '✨ Aelia Boutique - Elegancia Sin Esfuerzo ✨' }}
            </span>
        </div>
    </div>

    <!-- Header Navbar -->
    <header class="bg-surface/90 sticky top-0 z-40 border-b border-outline-variant/30 backdrop-blur-md">
        <div
            class="flex justify-between items-center w-full px-margin-mobile md:px-margin-desktop py-4 max-w-container-max mx-auto">
            <!-- Mobile Menu Toggle -->
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="md:hidden text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined">menu</span>
            </button>

            <!-- Navigation Links (Desktop) -->
            <nav class="hidden md:flex gap-6 items-center text-xs uppercase tracking-widest font-semibold">
                <a href="{{ route('home') }}"
                    class="hover:text-primary transition-colors {{ request()->routeIs('home') ? 'text-primary border-b-2 border-primary pb-1' : 'text-on-surface-variant' }}">Inicio</a>
                <a href="{{ route('catalog.index') }}"
                    class="hover:text-primary transition-colors {{ request()->routeIs('catalog.index') && !request()->has('on_sale') && !request()->has('new') ? 'text-primary border-b-2 border-primary pb-1' : 'text-on-surface-variant' }}">Colección
                    Completa</a>
                <a href="{{ route('catalog.index', ['new' => 1]) }}"
                    class="hover:text-primary transition-colors {{ request()->has('new') ? 'text-primary border-b-2 border-primary pb-1' : 'text-on-surface-variant' }}">Nuevos
                    Lanzamientos</a>
                <a href="{{ route('catalog.index', ['on_sale' => 1]) }}"
                    class="hover:text-primary transition-colors text-primary {{ request()->has('on_sale') ? 'font-bold border-b-2 border-primary pb-1' : '' }}">🔥
                    Ofertas</a>
            </nav>

            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex flex-col items-center justify-center">
                <span class="font-serif text-2xl font-normal tracking-wider text-primary">Aelia</span>
                <span
                    class="text-[9px] uppercase tracking-[0.3em] text-antique-gold -mt-1 font-semibold">Boutique</span>
            </a>

            <!-- Right Header Actions -->
            <div class="flex gap-4 items-center text-on-surface-variant">
                <button @click="searchOpen = true" class="hover:text-primary transition-all duration-300">
                    <span class="material-symbols-outlined">search</span>
                </button>
                <a href="{{ route('tracking.index') }}" title="Seguimiento de Pedido"
                    class="hover:text-primary transition-all duration-300">
                    <span class="material-symbols-outlined">local_shipping</span>
                </a>
                <button @click="cartOpen = true" class="hover:text-primary transition-all duration-300 relative">
                    <span class="material-symbols-outlined">shopping_bag</span>
                    <span x-text="cart.total_count" x-show="cart.total_count > 0"
                        class="absolute -top-1.5 -right-1.5 bg-primary text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">0</span>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Navigation -->
        <div x-show="mobileMenuOpen" x-transition
            class="md:hidden bg-surface border-b border-outline-variant/30 px-6 py-4 space-y-3">
            <a href="{{ route('home') }}"
                class="block text-sm font-semibold uppercase tracking-wider text-on-surface">Inicio</a>
            <a href="{{ route('catalog.index') }}"
                class="block text-sm font-semibold uppercase tracking-wider text-on-surface">Colección Completa</a>
            <a href="{{ route('catalog.index', ['new' => 1]) }}"
                class="block text-sm font-semibold uppercase tracking-wider text-on-surface">Nuevos Lanzamientos</a>
            <a href="{{ route('catalog.index', ['on_sale' => 1]) }}"
                class="block text-sm font-semibold uppercase tracking-wider text-primary">🔥 Ofertas</a>
            <a href="{{ route('pages.about') }}" class="block text-sm text-on-surface-variant">Nosotros</a>
            <a href="{{ route('pages.contact') }}" class="block text-sm text-on-surface-variant">Contacto</a>
        </div>
    </header>

    <!-- Search Modal -->
    <div x-show="searchOpen" x-transition
        class="fixed inset-0 z-50 bg-ink-black/60 backdrop-blur-sm flex items-start justify-center pt-20 px-4"
        style="display: none;">
        <div @click.away="searchOpen = false" class="bg-surface w-full max-w-xl rounded-xl p-6 shadow-2xl relative">
            <button @click="searchOpen = false"
                class="absolute top-4 right-4 text-on-surface-variant hover:text-primary">
                <span class="material-symbols-outlined">close</span>
            </button>
            <h3 class="font-serif text-xl text-primary mb-4">Buscar en Aelia Boutique</h3>
            <form action="{{ route('catalog.index') }}" method="GET" class="flex gap-2">
                <input type="text" name="q"
                    placeholder="¿Qué prenda estás buscando? (Ej. Blusa, Vestido, Seda...)"
                    class="w-full rounded-lg border-outline-variant focus:border-primary focus:ring-primary text-sm px-4 py-3">
                <button type="submit"
                    class="bg-ink-black text-white px-6 py-3 rounded-lg font-semibold text-xs uppercase tracking-widest hover:bg-primary transition-colors">Buscar</button>
            </form>
        </div>
    </div>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @if (session('success'))
            <div
                class="bg-primary/10 border-l-4 border-primary text-primary p-4 mx-auto max-w-container-max my-4 text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif
        @if (session('warning'))
            <div
                class="bg-amber-500/10 border-l-4 border-amber-500 text-amber-800 p-4 mx-auto max-w-container-max my-4 text-sm font-semibold">
                {{ session('warning') }}
            </div>
        @endif
        @if (session('error'))
            <div
                class="bg-red-500/10 border-l-4 border-red-500 text-red-700 p-4 mx-auto max-w-container-max my-4 text-sm font-semibold">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Off-Canvas Cart Drawer Component -->
    @include('components.cart-drawer')

    <!-- Footer Shell -->
    <footer class="bg-blush-silk border-t border-outline-variant/30 mt-section-gap pt-16 pb-12">
        <div
            class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="space-y-4">
                <span class="font-serif text-2xl text-primary">Aelia Boutique</span>
                <p class="text-xs text-on-surface-variant leading-relaxed">
                    {{ optional($companyInfo)->descripcion ?? 'Elegancia sin esfuerzo. Colecciones exclusivas diseñadas con la máxima atención al detalle y acabados de alta costura.' }}
                </p>
                <div class="flex gap-3 text-primary">
                    @if(optional($companyInfo)->link_instagram)
                        <a href="{{ $companyInfo->link_instagram }}" target="_blank" title="Instagram"
                            class="w-8 h-8 rounded-full bg-white flex items-center justify-center shadow-sm hover:bg-primary hover:text-white transition-colors"><span
                                class="material-symbols-outlined text-sm">photo_camera</span></a>
                    @endif
                    @if(optional($companyInfo)->link_facebook)
                        <a href="{{ $companyInfo->link_facebook }}" target="_blank" title="Facebook"
                            class="w-8 h-8 rounded-full bg-white flex items-center justify-center shadow-sm hover:bg-primary hover:text-white transition-colors"><span
                                class="material-symbols-outlined text-sm">public</span></a>
                    @endif
                    @if(optional($companyInfo)->telefono)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $companyInfo->telefono) }}" target="_blank" title="WhatsApp"
                            class="w-8 h-8 rounded-full bg-white flex items-center justify-center shadow-sm hover:bg-primary hover:text-white transition-colors"><span
                                class="material-symbols-outlined text-sm">chat</span></a>
                    @endif
                </div>
            </div>

            <div>
                <h4 class="font-semibold text-xs uppercase tracking-widest text-primary mb-4">Navegación</h4>
                <ul class="space-y-2 text-xs text-on-surface-variant">
                    <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors">Inicio /
                            Tienda</a></li>
                    <li><a href="{{ route('catalog.index') }}" class="hover:text-primary transition-colors">Catálogo
                            Completo</a></li>
                    <li><a href="{{ route('catalog.index', ['on_sale' => 1]) }}"
                            class="hover:text-primary transition-colors">Ofertas Especiales</a></li>
                    <li><a href="{{ route('tracking.index') }}"
                            class="hover:text-primary transition-colors">Seguimiento de Pedido</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-semibold text-xs uppercase tracking-widest text-primary mb-4">Información Legal</h4>
                <ul class="space-y-2 text-xs text-on-surface-variant">
                    <li><a href="{{ route('pages.about') }}"
                            class="hover:text-primary transition-colors">Nosotros</a></li>
                    <li><a href="{{ route('pages.contact') }}"
                            class="hover:text-primary transition-colors">Contáctanos</a></li>
                    <li><a href="{{ route('pages.terms') }}" class="hover:text-primary transition-colors">Términos y
                            Condiciones</a></li>
                    <li><a href="{{ route('pages.complaints-book') }}"
                            class="hover:text-primary transition-colors flex items-center gap-1"><span
                                class="material-symbols-outlined text-sm text-antique-gold">menu_book</span> Libro de
                            Reclamaciones</a></li>
                </ul>
            </div>

            <div class="space-y-3 text-xs text-on-surface-variant">
                <h4 class="font-semibold text-xs uppercase tracking-widest text-primary mb-4">Atención al Cliente</h4>
                @if(optional($companyInfo)->direccion)
                    <p>📍 {{ $companyInfo->direccion }}</p>
                @endif
                @if(optional($companyInfo)->telefono)
                    <p>💬 WhatsApp: {{ $companyInfo->telefono }}</p>
                @endif
                @if(optional($companyInfo)->correo)
                    <p>✉️ {{ $companyInfo->correo }}</p>
                @endif
                @if(optional($companyInfo)->horario)
                    <p>⏰ {{ $companyInfo->horario }}</p>
                @endif
            </div>
        </div>
        <div
            class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop mt-12 pt-6 border-t border-outline-variant/20 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-on-surface-variant/70">
            <div>
                &copy; {{ date('Y') }} Aelia Boutique. Todos los derechos reservados.
            </div>
            <div>
                Desarrollado por <a href="https://cadi-soft.com" target="_blank" rel="noopener" class="font-bold text-primary hover:underline">cadi-soft.com</a>
            </div>
        </div>
    </footer>

    <script>
        function cartApp() {
            return {
                cartOpen: false,
                searchOpen: false,
                mobileMenuOpen: false,
                cart: {
                    items: [],
                    subtotal: 0,
                    total_count: 0,
                    free_shipping_progress: 0
                },
                init() {
                    this.fetchCart();
                },
                async fetchCart() {
                    const res = await fetch('{{ route('cart.index') }}');
                    if (res.ok) {
                        this.cart = await res.json();
                    }
                },
                async addToCart(productId, variantId = null, quantity = 1) {
                    const res = await fetch('{{ route('cart.add') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            variant_id: variantId,
                            quantity: quantity
                        })
                    });
                    if (res.ok) {
                        const data = await res.json();
                        this.cart = data.cart;
                        this.cartOpen = true;
                    }
                },
                async updateQuantity(key, quantity) {
                    const res = await fetch(`/carrito/actualizar/${key}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            quantity: quantity
                        })
                    });
                    if (res.ok) {
                        const data = await res.json();
                        this.cart = data.cart;
                    }
                },
                async removeItem(key) {
                    const res = await fetch(`/carrito/eliminar/${key}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    if (res.ok) {
                        const data = await res.json();
                        this.cart = data.cart;
                    }
                }
            }
        }
    </script>
    <!-- Eye-catching Floating WhatsApp Widget -->
    @php
        $companyWsp = \App\Models\Company::first();
        $wspPhone = preg_replace('/[^0-9]/', '', optional($companyWsp)->telefono ?? '51987654321');
        $wspText = urlencode('¡Hola Aelia Boutique! Quisiera información y asesoría sobre sus prendas.');
    @endphp
    <div class="fixed bottom-6 right-6 z-50 flex items-center gap-3 group" x-data="{ tooltipOpen: true }">
        <!-- Tooltip Badge Bubble -->
        <div x-show="tooltipOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-2" x-transition:enter-end="opacity-100 translate-x-0" class="bg-white border border-outline-variant/30 text-on-surface shadow-2xl rounded-2xl py-2 px-4 flex items-center gap-3 text-xs font-semibold">
            <div class="w-2.5 h-2.5 rounded-full bg-[#25D366] animate-ping"></div>
            <span>💬 ¿Necesitas ayuda? Escríbenos</span>
            <button @click.stop="tooltipOpen = false" class="text-on-surface-variant/50 hover:text-red-500 text-sm font-bold ml-1">&times;</button>
        </div>

        <!-- Floating Green WhatsApp Button with Pulse Wave -->
        <a href="https://wa.me/{{ $wspPhone }}?text={{ $wspText }}" target="_blank" title="Chatear por WhatsApp" class="relative w-14 h-14 bg-[#25D366] text-white rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-transform duration-300">
            <!-- Pulsing outer ring -->
            <span class="absolute -inset-1 rounded-full bg-[#25D366]/40 animate-ping pointer-events-none"></span>
            <!-- Icon -->
            <span class="material-symbols-outlined text-3xl font-bold relative z-10">chat</span>
        </a>
    </div>

</body>

</html>
