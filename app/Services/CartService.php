<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ShippingRate;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected string $sessionKey = 'aelia_cart';

    public function getCart(): array
    {
        $cart = Session::get($this->sessionKey, []);

        $items = [];
        $subtotal = 0;
        $totalCount = 0;

        foreach ($cart as $key => $item) {
            $product = Product::with(['primaryImage', 'images'])->find($item['product_id']);
            if (! $product) {
                continue;
            }

            $variant = null;
            if (! empty($item['variant_id'])) {
                $variant = ProductVariant::with(['attributeValues', 'images'])->find($item['variant_id']);
            } elseif ($product->has_variants && $product->variants->isNotEmpty()) {
                $variant = $product->variants->first();
            }

            $unitPrice = $variant ? $variant->effective_price : $product->effective_price;
            if ($unitPrice <= 0 && $product->variants->isNotEmpty()) {
                $unitPrice = (float) $product->variants->first()->effective_price;
            }

            $itemSubtotal = $unitPrice * $item['quantity'];
            $subtotal += $itemSubtotal;
            $totalCount += $item['quantity'];

            // Determine thumbnail
            $imagePath = null;
            if ($variant && $variant->images->isNotEmpty()) {
                $imagePath = $variant->images->first()->path;
            } elseif ($product->primaryImage) {
                $imagePath = $product->primaryImage->path;
            } elseif ($product->images->isNotEmpty()) {
                $imagePath = $product->images->first()->path;
            }

            $items[] = [
                'key' => $key,
                'product_id' => $product->id,
                'variant_id' => $variant ? $variant->id : null,
                'product_name' => $product->name,
                'variant_name' => $variant ? $variant->name : null,
                'sku' => $variant ? $variant->sku : $product->sku,
                'price' => $unitPrice,
                'quantity' => $item['quantity'],
                'subtotal' => $itemSubtotal,
                'image' => $imagePath,
            ];
        }

        return [
            'items' => $items,
            'subtotal' => $subtotal,
            'total_count' => $totalCount,
        ];
    }

    public function add(int $productId, ?int $variantId = null, int $quantity = 1): array
    {
        $product = Product::with('variants')->find($productId);
        if ($product && $product->has_variants && empty($variantId) && $product->variants->isNotEmpty()) {
            $variantId = $product->variants->first()->id;
        }

        $cart = Session::get($this->sessionKey, []);
        $key = $productId . ($variantId ? '_' . $variantId : '_base');

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $cart[$key] = [
                'product_id' => $productId,
                'variant_id' => $variantId,
                'quantity' => $quantity,
            ];
        }

        Session::put($this->sessionKey, $cart);

        return $this->getCart();
    }

    public function update(string $key, int $quantity): array
    {
        $cart = Session::get($this->sessionKey, []);

        if (isset($cart[$key])) {
            if ($quantity <= 0) {
                unset($cart[$key]);
            } else {
                $cart[$key]['quantity'] = $quantity;
            }
            Session::put($this->sessionKey, $cart);
        }

        return $this->getCart();
    }

    public function remove(string $key): array
    {
        $cart = Session::get($this->sessionKey, []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
            Session::put($this->sessionKey, $cart);
        }

        return $this->getCart();
    }

    public function clear(): void
    {
        Session::forget($this->sessionKey);
    }
}
