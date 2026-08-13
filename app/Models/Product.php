<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'short_description',
        'description',
        'base_price',
        'sale_price',
        'cost',
        'stock',
        'has_variants',
        'is_active',
        'is_featured',
        'is_new',
        'is_on_sale',
        'published_at',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'cost' => 'decimal:2',
        'stock' => 'integer',
        'has_variants' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
        'is_on_sale' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function videos(): HasMany
    {
        return $this->hasMany(ProductVideo::class)->where('is_active', true)->orderBy('sort_order');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function getEffectivePriceAttribute(): float
    {
        if ($this->is_on_sale && $this->sale_price !== null && $this->sale_price > 0) {
            return (float) $this->sale_price;
        }

        return (float) $this->base_price;
    }

    public function getDiscountPercentageAttribute(): int
    {
        if ($this->is_on_sale && $this->sale_price && $this->base_price > $this->sale_price) {
            return (int) round((($this->base_price - $this->sale_price) / $this->base_price) * 100);
        }

        return 0;
    }

    public function getTotalStockAttribute(): int
    {
        if ($this->has_variants) {
            return (int) $this->variants()->sum('stock');
        }

        return (int) $this->stock;
    }

    public function getPrimaryImageUrlAttribute(): ?string
    {
        if ($this->primaryImage) {
            return $this->primaryImage->url;
        }

        if ($this->images->isNotEmpty()) {
            return $this->images->first()->url;
        }

        if ($this->relationLoaded('variants') && $this->variants->isNotEmpty()) {
            foreach ($this->variants as $variant) {
                if ($variant->primary_image_url) {
                    return $variant->primary_image_url;
                }
            }
        }

        return null;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeNewReleases($query)
    {
        return $query->where('is_new', true);
    }

    public function scopeOnSale($query)
    {
        return $query->where('is_on_sale', true);
    }
}
