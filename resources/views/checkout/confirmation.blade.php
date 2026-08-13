@extends('layouts.app')

@section('title', '¡Pedido Confirmado! - Aelia Boutique')

@section('content')
<div class="max-w-3xl mx-auto px-margin-mobile md:px-margin-desktop py-12 space-y-8 text-center">

    <!-- Success Icon & Header -->
    <div class="space-y-3">
        <div class="w-16 h-16 bg-primary/10 text-primary rounded-full flex items-center justify-center mx-auto shadow-sm">
            <span class="material-symbols-outlined text-3xl">check_circle</span>
        </div>
        <span class="text-xs uppercase tracking-[0.25em] text-antique-gold font-semibold">¡Muchas gracias por tu compra!</span>
        <h1 class="font-serif text-3xl md:text-4xl text-primary font-normal">Pedido Registrado con Éxito</h1>
        <p class="text-xs text-on-surface-variant max-w-md mx-auto">
            Hemos recibido tu pedido <strong>#{{ $order->order_number }}</strong>. Para procesar tu envío de inmediato, por favor envía el comprobante de depósito por WhatsApp.
        </p>
    </div>

    <!-- Direct WhatsApp CTA Button -->
    <div class="bg-blush-silk p-6 rounded-2xl border border-outline-variant/30 space-y-4 shadow-sm">
        <h3 class="font-serif text-xl text-primary font-normal">Enviar Comprobante de Pago</h3>
        <p class="text-xs text-on-surface-variant">Haz clic en el siguiente botón para abrir WhatsApp con los datos de tu pedido autocompletados:</p>
        <div>
            <a href="{{ $whatsappUrl }}" target="_blank" class="inline-flex items-center gap-3 bg-[#25D366] text-white px-8 py-3.5 rounded-xl text-xs uppercase tracking-widest font-bold hover:bg-[#1ebd59] transition-all shadow-lg">
                <span class="material-symbols-outlined text-lg">chat</span>
                <span>Enviar Comprobante a WhatsApp</span>
            </a>
        </div>
    </div>

    <!-- Order Summary & Items Card -->
    <div class="bg-white p-6 rounded-2xl border border-outline-variant/30 text-left space-y-6 shadow-xs">
        <div class="flex justify-between items-center border-b border-outline-variant/20 pb-4">
            <div>
                <span class="text-xs text-on-surface-variant">Número de Pedido</span>
                <h4 class="font-serif text-lg font-bold text-primary">#{{ $order->order_number }}</h4>
            </div>
            <div class="text-right">
                <span class="text-xs text-on-surface-variant">Total a Pagar</span>
                <h4 class="font-serif text-lg font-bold text-primary">S/ {{ number_format($order->total, 2) }}</h4>
            </div>
        </div>

        <!-- Items Table -->
        <div class="space-y-3">
            <h5 class="text-xs font-semibold uppercase tracking-wider text-primary">Prendas Solicitadas:</h5>
            @foreach($order->items as $item)
                <div class="flex justify-between items-center text-xs border-b border-outline-variant/10 pb-2">
                    <div>
                        <span class="font-medium text-on-surface">{{ $item->product_name }}</span>
                        @if($item->variant_name)
                            <span class="text-primary text-[11px] block">{{ $item->variant_name }}</span>
                        @endif
                        <span class="text-on-surface-variant/70 text-[10px]">Cantidad: {{ $item->quantity }} x S/ {{ number_format($item->price, 2) }}</span>
                    </div>
                    <span class="font-semibold font-serif text-on-surface">S/ {{ number_format($item->subtotal, 2) }}</span>
                </div>
            @endforeach
        </div>

        <!-- Customer & Shipping Summary -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-on-surface-variant bg-surface p-4 rounded-lg border border-outline-variant/20">
            <div>
                <strong class="text-primary block mb-1 uppercase tracking-wider text-[10px]">Cliente:</strong>
                <p>{{ $order->customer_name }}</p>
                <p>{{ $order->customer_email }}</p>
                <p>Tel: {{ $order->customer_phone }}</p>
            </div>
            <div>
                <strong class="text-primary block mb-1 uppercase tracking-wider text-[10px]">Dirección de Envío:</strong>
                <p>{{ $order->shipping_address }}</p>
                <p>{{ $order->region }} ({{ $order->shipping_agency }})</p>
            </div>
        </div>

        <!-- Bank Accounts Info -->
        <div class="space-y-3 pt-2">
            <h5 class="text-xs font-semibold uppercase tracking-wider text-primary">Cuentas Bancarias para Depósito:</h5>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach($bankAccounts as $acc)
                    <div class="bg-blush-silk p-3 rounded border border-outline-variant/20 text-xs space-y-1">
                        <span class="font-bold text-primary block">{{ $acc->bank_name }}</span>
                        <p class="text-on-surface">Cuenta: <strong>{{ $acc->account_number }}</strong></p>
                        @if($acc->cci)
                            <p class="text-[11px] text-on-surface-variant">CCI: {{ $acc->cci }}</p>
                        @endif
                        <p class="text-[11px] text-on-surface-variant">Titular: {{ $acc->holder_name }}</p>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- Actions Footer -->
    <div class="flex justify-center gap-4">
        <a href="{{ route('home') }}" class="bg-ink-black text-white px-8 py-3 rounded-lg text-xs uppercase tracking-widest font-semibold hover:bg-primary transition-colors">Volver a la Tienda</a>
        <a href="{{ route('tracking.index', ['order_number' => $order->order_number]) }}" class="border border-outline-variant/40 px-6 py-3 rounded-lg text-xs uppercase tracking-widest font-semibold hover:border-primary transition-colors">Rastrear Estado</a>
    </div>

</div>
@endsection
