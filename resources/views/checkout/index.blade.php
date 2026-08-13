@extends('layouts.app')

@section('title', 'Finalizar Compra - Aelia Boutique')

@section('content')
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-8 space-y-8" x-data="checkoutForm({{ json_encode($shippingRates) }})">

    <!-- Header -->
    <div class="border-b border-outline-variant/30 pb-6 text-center space-y-2">
        <span class="text-xs uppercase tracking-[0.2em] text-antique-gold font-semibold">Proceso Seguro</span>
        <h1 class="font-serif text-3xl md:text-4xl text-primary font-normal">Finalizar Compra</h1>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
        @csrf

        <!-- Form Columns (Left 2 Columns) -->
        <div class="md:col-span-2 space-y-8">
            
            <!-- Step 1: Customer Info -->
            <div class="bg-white p-6 rounded-xl border border-outline-variant/30 space-y-4 shadow-xs">
                <h3 class="font-serif text-xl text-primary border-b border-outline-variant/20 pb-3 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-primary text-white text-xs flex items-center justify-center font-bold font-sans">1</span>
                    <span>Datos del Cliente</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Nombres y Apellidos *</label>
                        <input type="text" name="customer_name" required value="{{ old('customer_name') }}" placeholder="Ej. María García" class="w-full text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary py-2.5 px-3">
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Correo Electrónico *</label>
                        <input type="email" name="customer_email" required value="{{ old('customer_email') }}" placeholder="tu@email.com" class="w-full text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary py-2.5 px-3">
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Teléfono / WhatsApp *</label>
                        <input type="text" name="customer_phone" required value="{{ old('customer_phone') }}" placeholder="987 654 321" class="w-full text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary py-2.5 px-3">
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="space-y-1">
                            <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Doc.</label>
                            <select name="document_type" class="w-full text-xs rounded-lg border-outline-variant/50 py-2.5 px-2">
                                <option value="DNI">DNI</option>
                                <option value="RUC">RUC</option>
                                <option value="CE">CE</option>
                            </select>
                        </div>
                        <div class="col-span-2 space-y-1">
                            <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Número *</label>
                            <input type="text" name="document_number" required value="{{ old('document_number') }}" placeholder="12345678" class="w-full text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary py-2.5 px-3">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Shipping Destination & Agency Selection -->
            <div class="bg-white p-6 rounded-xl border border-outline-variant/30 space-y-4 shadow-xs">
                <h3 class="font-serif text-xl text-primary border-b border-outline-variant/20 pb-3 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-primary text-white text-xs flex items-center justify-center font-bold font-sans">2</span>
                    <span>Destino y Agencia de Envío</span>
                </h3>

                <div class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Selecciona tu Tarifa / Agencia de Envío *</label>
                        <select name="shipping_rate_id" x-model="selectedShippingId" @change="updateShipping()" required class="w-full text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary py-2.5 px-3">
                            <option value="">-- Seleccionar Agencia o Ciudad --</option>
                            @foreach($shippingRates as $rate)
                                <option value="{{ $rate->id }}" data-cost="{{ $rate->cost }}" data-region="{{ $rate->region }}">
                                    {{ $rate->region }} {{ $rate->province ? '('.$rate->province.')' : '' }} - {{ $rate->agency }} (S/ {{ number_format($rate->cost, 2) }})
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="region" :value="selectedRegion">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Provincia</label>
                            <input type="text" name="province" placeholder="Ej. Lima" class="w-full text-xs rounded-lg border-outline-variant/50 py-2.5 px-3">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Distrito</label>
                            <input type="text" name="district" placeholder="Ej. San Isidro" class="w-full text-xs rounded-lg border-outline-variant/50 py-2.5 px-3">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Dirección de Entrega Exacta *</label>
                        <input type="text" name="shipping_address" required placeholder="Av. Principal 123, Dpto 402" class="w-full text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary py-2.5 px-3">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Referencia</label>
                        <input type="text" name="reference" placeholder="Frente al parque, portón blanco..." class="w-full text-xs rounded-lg border-outline-variant/50 py-2.5 px-3">
                    </div>
                </div>
            </div>

            <!-- Step 3: Payment Method & Bank Details -->
            <div class="bg-white p-6 rounded-xl border border-outline-variant/30 space-y-4 shadow-xs">
                <h3 class="font-serif text-xl text-primary border-b border-outline-variant/20 pb-3 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-primary text-white text-xs flex items-center justify-center font-bold font-sans">3</span>
                    <span>Información de Pago</span>
                </h3>

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <label class="p-4 rounded-lg border cursor-pointer flex flex-col items-center justify-center text-center gap-2 transition-all" :class="paymentMethod === 'bank_transfer' ? 'border-primary bg-blush-silk text-primary font-bold' : 'border-outline-variant/40 bg-surface'">
                            <input type="radio" name="payment_method" value="bank_transfer" x-model="paymentMethod" class="sr-only">
                            <span class="material-symbols-outlined text-2xl">account_balance</span>
                            <span class="text-xs uppercase tracking-wider">Transferencia Bancaria</span>
                        </label>
                        <label class="p-4 rounded-lg border cursor-pointer flex flex-col items-center justify-center text-center gap-2 transition-all" :class="paymentMethod === 'yape_plin' ? 'border-primary bg-blush-silk text-primary font-bold' : 'border-outline-variant/40 bg-surface'">
                            <input type="radio" name="payment_method" value="yape_plin" x-model="paymentMethod" class="sr-only">
                            <span class="material-symbols-outlined text-2xl">qr_code_2</span>
                            <span class="text-xs uppercase tracking-wider">Yape / Plin</span>
                        </label>
                    </div>

                    <!-- Bank Accounts Info Box -->
                    <div class="bg-blush-silk p-4 rounded-lg border border-outline-variant/30 space-y-3">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-primary">Cuentas Disponibles para Depósito:</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($bankAccounts as $acc)
                                <div class="bg-white p-3 rounded border border-outline-variant/20 text-xs space-y-1">
                                    <span class="font-bold text-primary block">{{ $acc->bank_name }}</span>
                                    <p class="text-on-surface">Cuenta: <strong>{{ $acc->account_number }}</strong></p>
                                    @if($acc->cci)
                                        <p class="text-[11px] text-on-surface-variant">CCI: {{ $acc->cci }}</p>
                                    @endif
                                    <p class="text-[11px] text-on-surface-variant">Titular: {{ $acc->holder_name }}</p>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-[11px] text-on-surface-variant/80 italic mt-2">
                            * Al confirmar la compra te redirigiremos a WhatsApp para enviar el comprobante de pago de forma inmediata.
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Order Summary Sidebar (Right 1 Column) -->
        <div class="bg-blush-silk p-6 rounded-xl border border-outline-variant/30 space-y-6 sticky top-24">
            <h3 class="font-serif text-xl text-primary border-b border-outline-variant/30 pb-3">Resumen de Compra</h3>

            <div class="space-y-3 max-h-64 overflow-y-auto pr-1">
                @foreach($cart['items'] as $item)
                    <div class="flex justify-between items-center text-xs text-on-surface">
                        <div>
                            <span class="font-semibold block line-clamp-1">{{ $item['product_name'] }}</span>
                            @if($item['variant_name'])
                                <span class="text-[10px] text-primary">{{ $item['variant_name'] }}</span>
                            @endif
                            <span class="text-[11px] text-on-surface-variant block">Cant: {{ $item['quantity'] }} x S/ {{ number_format($item['price'], 2) }}</span>
                        </div>
                        <span class="font-semibold font-serif">S/ {{ number_format($item['subtotal'], 2) }}</span>
                    </div>
                @endforeach
            </div>

            <div class="border-t border-outline-variant/30 pt-4 space-y-2 text-xs text-on-surface-variant">
                <div class="flex justify-between">
                    <span>Subtotal Prendas:</span>
                    <span class="font-semibold text-on-surface">S/ {{ number_format($cart['subtotal'], 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Costo de Envío:</span>
                    <span class="font-semibold text-primary" x-text="'S/ ' + shippingCost.toFixed(2)">S/ 0.00</span>
                </div>
                <div class="border-t border-outline-variant/30 pt-3 flex justify-between items-baseline text-base font-bold text-on-surface">
                    <span class="font-serif uppercase tracking-wider text-primary">Total:</span>
                    <span class="font-serif text-2xl text-primary" x-text="'S/ ' + ({{ $cart['subtotal'] }} + shippingCost).toFixed(2)">S/ {{ number_format($cart['subtotal'], 2) }}</span>
                </div>
            </div>

            <button type="submit" class="w-full bg-ink-black text-white py-4 rounded-lg text-xs uppercase tracking-widest font-semibold hover:bg-primary transition-all shadow-xl flex items-center justify-center gap-2">
                <span>Confirmar Pedido</span>
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </button>
        </div>

    </form>
</div>

<script>
    function checkoutForm(ratesData) {
        return {
            rates: ratesData || [],
            selectedShippingId: '',
            selectedRegion: '',
            shippingCost: 0,
            paymentMethod: 'bank_transfer',
            updateShipping() {
                const selected = this.rates.find(r => r.id == this.selectedShippingId);
                if (selected) {
                    this.shippingCost = parseFloat(selected.cost);
                    this.selectedRegion = selected.region;
                } else {
                    this.shippingCost = 0;
                    this.selectedRegion = '';
                }
            }
        }
    }
</script>
@endsection
