<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'imagen',
        'descripcion_corta',
        'product_id',
        'link',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function getTargetUrlAttribute(): string
    {
        if ($this->product_id && $this->product) {
            return route('catalog.detail', $this->product->slug);
        }

        return $this->link ?? route('catalog.index', ['on_sale' => 1]);
    }
}
