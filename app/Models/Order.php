<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'document_type',
        'document_number',
        'shipping_address',
        'region',
        'province',
        'district',
        'shipping_agency',
        'reference',
        'subtotal',
        'shipping_cost',
        'total',
        'payment_method',
        'payment_status',
        'order_status',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalAmountAttribute()
    {
        return $this->total;
    }

    public function getStatusAttribute()
    {
        return $this->order_status;
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            'bank_transfer' => 'Depósito / Transferencia Bancaria',
            'yape_plin' => 'Yape / Plin',
            default => strtoupper((string) $this->payment_method),
        };
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'AEL-';
        $number = mt_rand(100000, 999999);
        while (self::where('order_number', $prefix . $number)->exists()) {
            $number = mt_rand(100000, 999999);
        }
        return $prefix . $number;
    }
}
