@extends('layouts.app')

@section('title', 'Libro de Reclamaciones - Aelia Boutique')

@section('content')
<div class="max-w-3xl mx-auto px-margin-mobile md:px-margin-desktop py-12 space-y-8">

    <!-- Header -->
    <div class="text-center space-y-2 border-b border-outline-variant/30 pb-6">
        <span class="text-xs uppercase tracking-[0.2em] text-antique-gold font-semibold">Conforme al Código de Protección al Consumidor</span>
        <h1 class="font-serif text-3xl md:text-4xl text-primary font-normal">Libro de Reclamaciones Virtual</h1>
        <p class="text-xs text-on-surface-variant max-w-md mx-auto">
            RUC: <strong>{{ optional($company)->ruc ?? '20601234567' }}</strong> | Razon Social: <strong>AELIA BOUTIQUE S.A.C.</strong>
        </p>
    </div>

    <!-- Form -->
    <form action="{{ route('pages.complaints-book.store') }}" method="POST" class="bg-white p-8 rounded-2xl border border-outline-variant/30 space-y-6 shadow-xs">
        @csrf

        <div class="space-y-4">
            <h3 class="font-serif text-lg text-primary border-b border-outline-variant/20 pb-2">1. Identificación del Consumidor Reclamante</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Nombres y Apellidos *</label>
                    <input type="text" name="fullname" required placeholder="Nombre completo..." class="w-full text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary py-2.5 px-3">
                </div>
                <div class="space-y-1">
                    <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">DNI / CE / Pasaporte *</label>
                    <input type="text" name="dni" required placeholder="Número de documento..." class="w-full text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary py-2.5 px-3">
                </div>
                <div class="space-y-1">
                    <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Correo Electrónico *</label>
                    <input type="email" name="email" required placeholder="tu@email.com" class="w-full text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary py-2.5 px-3">
                </div>
                <div class="space-y-1">
                    <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Teléfono de Contacto *</label>
                    <input type="text" name="phone" required placeholder="987 654 321" class="w-full text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary py-2.5 px-3">
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Dirección Domiciliaria *</label>
                <input type="text" name="address" required placeholder="Av. Principal 123..." class="w-full text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary py-2.5 px-3">
            </div>
        </div>

        <div class="space-y-4 pt-4 border-t border-outline-variant/20">
            <h3 class="font-serif text-lg text-primary border-b border-outline-variant/20 pb-2">2. Identificación del Bien Contratado</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Tipo de Bien *</label>
                    <select name="contracted_type" required class="w-full text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary py-2.5 px-3">
                        <option value="producto" selected>Producto (Prenda / Accesorio)</option>
                        <option value="servicio">Servicio (Atención / Envío)</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Monto Reclamado (S/) *</label>
                    <input type="number" step="0.01" name="amount" required placeholder="0.00" class="w-full text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary py-2.5 px-3">
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Descripción del Bien o Servicio *</label>
                <input type="text" name="description_good" required placeholder="Ej: Blusa Elegance Silk Rosada / Pedido #1002" class="w-full text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary py-2.5 px-3">
            </div>
        </div>

        <div class="space-y-4 pt-4 border-t border-outline-variant/20">
            <h3 class="font-serif text-lg text-primary border-b border-outline-variant/20 pb-2">3. Detalle de la Reclamación y Pedido</h3>

            <div class="space-y-1">
                <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Tipo de Registro *</label>
                <div class="flex gap-6 pt-1 text-xs">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="complaint_type" value="reclamo" checked class="text-primary focus:ring-primary">
                        <span><strong>Reclamo</strong> (Disconformidad relacionada a los productos)</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="complaint_type" value="queja" class="text-primary focus:ring-primary">
                        <span><strong>Queja</strong> (Disconformidad relacionada a la atención)</span>
                    </label>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Detalle de la Reclamación o Queja *</label>
                <textarea name="description" rows="4" required placeholder="Detalla claramente los hechos de tu reclamo o queja..." class="w-full text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary py-2.5 px-3"></textarea>
            </div>

            <div class="space-y-1">
                <label class="text-xs uppercase tracking-wider font-semibold text-on-surface-variant">Pedido o Solución Solicitada *</label>
                <textarea name="consumer_request" rows="3" required placeholder="Indica el pedido o solución concreta que solicitas (cambio, reembolso, etc.)..." class="w-full text-xs rounded-lg border-outline-variant/50 focus:border-primary focus:ring-primary py-2.5 px-3"></textarea>
            </div>
        </div>

        <button type="submit" class="w-full bg-ink-black text-white py-3.5 rounded-lg text-xs uppercase tracking-widest font-semibold hover:bg-primary transition-colors">Registrar en Libro de Reclamaciones &rarr;</button>
    </form>

</div>
@endsection
