<!-- Off-Canvas Cart Drawer -->
<div x-show="cartOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-hidden" style="display: none;">
    <!-- Backdrop -->
    <div @click="cartOpen = false" class="absolute inset-0 bg-ink-black/60 backdrop-blur-xs transition-opacity"></div>

    <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
        <div x-show="cartOpen" x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="w-screen max-w-md bg-surface shadow-2xl flex flex-col">
            
            <!-- Drawer Header -->
            <div class="px-6 py-4 border-b border-outline-variant/30 flex items-center justify-between bg-surface-container-lowest">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">shopping_bag</span>
                    <h2 class="font-serif text-lg text-primary">Bolsa de Compras</h2>
                    <span class="text-xs text-on-surface-variant font-bold">('<span x-text="cart.total_count">0</span>')</span>
                </div>
                <button @click="cartOpen = false" class="text-on-surface-variant hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Cart Items List -->
            <div class="flex-grow overflow-y-auto px-6 py-4 space-y-4">
                <template x-if="cart.items.length === 0">
                    <div class="flex flex-col items-center justify-center h-64 text-center text-on-surface-variant space-y-3">
                        <span class="material-symbols-outlined text-5xl text-outline-variant">shopping_bag</span>
                        <p class="font-serif text-base text-primary">Tu bolsa está vacía</p>
                        <p class="text-xs">Descubre nuestras colecciones exclusivas</p>
                        <a href="{{ route('catalog.index') }}" @click="cartOpen = false" class="mt-2 bg-ink-black text-white px-6 py-2.5 rounded-lg text-xs uppercase tracking-widest font-semibold hover:bg-primary transition-colors">Explorar Tienda</a>
                    </div>
                </template>

                <template x-for="item in cart.items" :key="item.key">
                    <div class="flex gap-4 p-3 rounded-lg border border-outline-variant/30 bg-white">
                        <div class="w-20 h-24 bg-surface-container-low rounded overflow-hidden flex-shrink-0">
                            <template x-if="item.image">
                                <img :src="'/storage/' + item.image" :alt="item.product_name" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!item.image">
                                <div class="w-full h-full flex items-center justify-center text-on-surface-variant/40">
                                    <span class="material-symbols-outlined">image</span>
                                </div>
                            </template>
                        </div>
                        <div class="flex-grow flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start">
                                    <h4 class="font-serif text-sm text-on-surface font-normal" x-text="item.product_name"></h4>
                                    <button @click="removeItem(item.key)" class="text-on-surface-variant/50 hover:text-red-500 transition-colors">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                </div>
                                <template x-if="item.variant_name">
                                    <span class="text-xs text-primary font-medium" x-text="item.variant_name"></span>
                                </template>
                                <div class="text-xs font-semibold text-on-surface mt-1" x-text="'S/ ' + parseFloat(item.price).toFixed(2)"></div>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <div class="flex items-center border border-outline-variant/40 rounded bg-surface">
                                    <button @click="updateQuantity(item.key, item.quantity - 1)" class="px-2 py-0.5 text-xs text-on-surface-variant hover:text-primary">-</button>
                                    <span class="px-2 py-0.5 text-xs font-semibold text-on-surface" x-text="item.quantity"></span>
                                    <button @click="updateQuantity(item.key, item.quantity + 1)" class="px-2 py-0.5 text-xs text-on-surface-variant hover:text-primary">+</button>
                                </div>
                                <span class="text-xs font-bold text-primary" x-text="'S/ ' + parseFloat(item.subtotal).toFixed(2)"></span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Drawer Footer -->
            <div x-show="cart.items.length > 0" class="p-6 border-t border-outline-variant/30 bg-surface-container-lowest space-y-4">
                <div class="flex justify-between items-center text-sm font-semibold">
                    <span class="text-on-surface-variant uppercase tracking-wider">Subtotal:</span>
                    <span class="font-serif text-xl text-primary font-normal" x-text="'S/ ' + parseFloat(cart.subtotal).toFixed(2)"></span>
                </div>
                <p class="text-[11px] text-on-surface-variant/70">Los costos de envío e impuestos se calculan al finalizar la compra.</p>
                <a href="{{ route('checkout.index') }}" @click="cartOpen = false" class="block w-full text-center bg-ink-black text-white py-3.5 rounded-lg text-xs uppercase tracking-widest font-semibold hover:bg-primary transition-colors shadow-lg">
                    Proceder al Checkout &rarr;
                </a>
            </div>

        </div>
    </div>
</div>
