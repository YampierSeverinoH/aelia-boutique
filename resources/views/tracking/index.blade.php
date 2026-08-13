@extends('layouts.app')

@section('title', 'Seguimiento de Pedido - Aelia Boutique')

@section('content')
<div class="max-w-3xl mx-auto px-margin-mobile md:px-margin-desktop py-12 space-y-8">

    <!-- Header -->
    <div class="text-center space-y-2">
        <span class="text-xs uppercase tracking-[0.2em] text-antique-gold font-semibold">Rastrea tu Envío</span>
        <h1 class="font-serif text-3xl md:text-4xl text-primary font-normal">Seguimiento de Pedido</h1>
        <p class="text-xs text-on-surface-variant max-w-md mx-auto">
            Ingresa tu código de pedido (Ej. AEL-123456) para conocer el estado actual de tu entrega.
        </p>
    </div>

    <!-- Lookup Form -->
    <form action="{{ route('tracking.index') }}" method="GET" class="bg-blush-silk p-6 rounded-2xl border border-outline-variant/30 shadow-xs flex flex-col md:flex-row gap-3">
        <input type="text" name="order_number" value="{{ request('order_number') }}" required placeholder="Código de Pedido (Ej. AEL-123456)" class="flex-grow rounded-xl border-outline-variant/50 focus:border-primary focus:ring-primary text-sm px-4 py-3">
        <button type="submit" class="bg-ink-black text-white px-8 py-3 rounded-xl text-xs uppercase tracking-widest font-semibold hover:bg-primary transition-colors">Buscar Pedido</button>
    </form>

    <!-- Order Tracking Result -->
    @if($searched)
        @if($order)
            <div class="bg-white p-6 rounded-2xl border border-outline-variant/30 space-y-6 shadow-sm">
                <div class="flex justify-between items-center border-b border-outline-variant/20 pb-4">
                    <div>
                        <span class="text-xs text-on-surface-variant">Pedido #</span>
                        <h3 class="font-serif text-xl font-bold text-primary">{{ $order->order_number }}</h3>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-on-surface-variant">Fecha de Registro</span>
                        <p class="text-xs text-on-surface font-semibold">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <!-- Timeline Steps -->
                <div class="py-4">
                    @php
                        $statuses = [
                            'pending' => ['title' => 'Pedido Recibido', 'desc' => 'Esperando confirmación de pago'],
                            'processing' => ['title' => 'En Preparación', 'desc' => 'Empacando tus prendas en boutique'],
                            'shipped' => ['title' => 'En Camino', 'desc' => 'Entregado a la agencia de envío'],
                            'delivered' => ['title' => 'Entregado', 'desc' => 'Entregado en tu dirección de destino'],
                        ];
                        $statusOrder = ['pending', 'processing', 'shipped', 'delivered'];
                        $currentIndex = array_search($order->order_status, $statusOrder);
                        if ($currentIndex === false) $currentIndex = 0;
                    @endphp

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($statusOrder as $idx => $stKey)
                            @php $st = $statuses[$stKey]; @endphp
                            <div class="flex flex-col items-center text-center p-3 rounded-xl border {{ $idx <= $currentIndex ? 'border-primary bg-blush-silk text-primary font-semibold' : 'border-outline-variant/30 text-on-surface-variant/50' }}">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold mb-2 {{ $idx <= $currentIndex ? 'bg-primary text-white' : 'bg-surface-variant text-on-surface-variant/50' }}">
                                    {{ $idx + 1 }}
                                </div>
                                <span class="text-xs font-serif">{{ $st['title'] }}</span>
                                <span class="text-[10px] mt-1 font-light opacity-80">{{ $st['desc'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Details -->
                <div class="border-t border-outline-variant/20 pt-4 space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-primary">Detalles del Destino:</h4>
                    <div class="text-xs text-on-surface-variant space-y-1 bg-surface p-4 rounded-lg">
                        <p><strong>Cliente:</strong> {{ $order->customer_name }}</p>
                        <p><strong>Destino:</strong> {{ $order->shipping_address }}, {{ $order->region }}</p>
                        <p><strong>Agencia:</strong> {{ $order->shipping_agency }}</p>
                        <p><strong>Total:</strong> S/ {{ number_format($order->total, 2) }}</p>
                    </div>
                </div>

            </div>
        @else
            <div class="text-center py-12 bg-blush-silk rounded-2xl border border-outline-variant/30 space-y-2">
                <span class="material-symbols-outlined text-4xl text-outline-variant">error_outline</span>
                <h3 class="font-serif text-lg text-primary">No se encontró el pedido "{{ request('order_number') }}"</h3>
                <p class="text-xs text-on-surface-variant">Verifica el código e intenta nuevamente o comunícate con nosotros por WhatsApp.</p>
            </div>
        @endif
    @endif

</div>
@endsection
