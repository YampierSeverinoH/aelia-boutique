<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductVariantAttribute extends Pivot
{
    protected $table = 'product_variant_attributes';

    public $incrementing = true;

    protected $fillable = [
        'product_variant_id',
        'attribute_id',
        'attribute_value_id',
    ];

    protected static function booted(): void
    {
        static::creating(function (ProductVariantAttribute $pivot) {
            if (empty($pivot->attribute_id) && !empty($pivot->attribute_value_id)) {
                $attributeValue = AttributeValue::find($pivot->attribute_value_id);
                if ($attributeValue) {
                    $pivot->attribute_id = $attributeValue->attribute_id;
                }
            }
        });

        static::updating(function (ProductVariantAttribute $pivot) {
            if (empty($pivot->attribute_id) && !empty($pivot->attribute_value_id)) {
                $attributeValue = AttributeValue::find($pivot->attribute_value_id);
                if ($attributeValue) {
                    $pivot->attribute_id = $attributeValue->attribute_id;
                }
            }
        });
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function attributeValue(): BelongsTo
    {
        return $this->belongsTo(AttributeValue::class);
    }
}
