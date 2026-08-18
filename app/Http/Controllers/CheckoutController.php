<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ShippingRate;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();

        if (empty($cart['items'])) {
            return redirect()->route('catalog.index')->with('warning', 'Tu carrito está vacío');
        }

        $shippingRates = ShippingRate::active()->get();
        $bankAccounts = BankAccount::active()->get();

        return view('checkout.index', compact('cart', 'shippingRates', 'bankAccounts'));
    }

    public function store(Request $request)
    {
        $cart = $this->cartService->getCart();

        if (empty($cart['items'])) {
            return redirect()->route('catalog.index')->with('error', 'Tu carrito está vacío');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:30',
            'document_type' => 'required|string|in:DNI,RUC,CE,PASAPORTE',
            'document_number' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'region' => 'required|string|max:255',
            'province' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'shipping_rate_id' => 'required|exists:shipping_rates,id',
            'reference' => 'nullable|string|max:500',
            'payment_method' => 'required|string|in:bank_transfer,yape_plin',
            'notes' => 'nullable|string|max:1000',
        ]);

        $shippingRate = ShippingRate::findOrFail($validated['shipping_rate_id']);
        $shippingCost = (float) $shippingRate->cost;
        $subtotal = (float) $cart['subtotal'];
        $total = $subtotal + $shippingCost;

        $order = DB::transaction(function () use ($validated, $shippingRate, $cart, $subtotal, $shippingCost, $total) {
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'document_type' => $validated['document_type'],
                'document_number' => $validated['document_number'],
                'shipping_address' => $validated['shipping_address'],
                'region' => $shippingRate->region,
                'province' => $shippingRate->province ?? ($validated['province'] ?? null),
                'district' => $validated['district'] ?? null,
                'shipping_agency' => $shippingRate->agency,
                'reference' => $validated['reference'] ?? null,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($cart['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_variant_id' => $item['variant_id'],
                    'product_name' => $item['product_name'],
                    'variant_name' => $item['variant_name'],
                    'sku' => $item['sku'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Decrement stock
                if (! empty($item['variant_id'])) {
                    ProductVariant::where('id', $item['variant_id'])->decrement('stock', $item['quantity']);
                } else {
                    Product::where('id', $item['product_id'])->decrement('stock', $item['quantity']);
                }
            }

            return $order;
        });

        $this->cartService->clear();

        try {
            $company = \App\Models\Company::first();
            $adminEmail = optional($company)->correo_notificaciones ?: (optional($company)->correo ?: 'notificaciones@aeliastore.pe');

            // 1. Notificar al cliente con PDF adjunto
            \Illuminate\Support\Facades\Mail::to($order->customer_email)->send(new \App\Mail\OrderConfirmationCustomerMail($order));

            // 2. Notificar al correo configurado de empresa
            \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\OrderNotificationAdminMail($order));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Error enviando correos de pedido: ' . $e->getMessage());
        }

        return redirect()->route('checkout.confirmation', $order->order_number);
    }

    public function confirmation(string $orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();
        $bankAccounts = BankAccount::active()->get();

        // Build WhatsApp order confirmation text
        $whatsappNumber = '51987654321'; // Default or from Company
        $message = "Hola Aelia Boutique, acabo de realizar el pedido *#{$order->order_number}* por un total de *S/ " . number_format($order->total, 2) . "*.\n\n";
        $message .= "Cliente: {$order->customer_name}\n";
        $message .= "Teléfono: {$order->customer_phone}\n";
        $message .= "Envío: {$order->region} ({$order->shipping_agency})\n\n";
        $message .= "Adjunto mi comprobante de pago.";

        $whatsappUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode($message);

        return view('checkout.confirmation', compact('order', 'bankAccounts', 'whatsappUrl'));
    }
}
