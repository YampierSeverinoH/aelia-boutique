<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OffersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = Product::first();

        Offer::create([
            'titulo' => 'Elegancia & Sofisticación en Cada Detalle',
            'imagen' => 'offers/promo1.jpg',
            'descripcion_corta' => 'Nuestra filosofía combina siluetas clásicas con cortes contemporáneos y telas finas de algodón pima y seda. Diseñado en Perú para la mujer exigente.',
            'product_id' => $product ? $product->id : null,
            'link' => null,
            'is_active' => true,
            'sort_order' => 1,
        ]);
    }
}
