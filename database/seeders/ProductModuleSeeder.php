<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Categorías Base
        $catRopa = Category::create([
            'name' => 'Ropa',
            'slug' => 'ropa',
            'description' => 'Colección general de prendas de vestir femeninas Aelia.',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $subcategories = [
            ['name' => 'Blusas', 'slug' => 'blusas', 'sort_order' => 1],
            ['name' => 'Vestidos', 'slug' => 'vestidos', 'sort_order' => 2],
            ['name' => 'Pantalones', 'slug' => 'pantalones', 'sort_order' => 3],
            ['name' => 'Polos', 'slug' => 'polos', 'sort_order' => 4],
            ['name' => 'Casacas', 'slug' => 'casacas', 'sort_order' => 5],
        ];

        $createdCategories = [];
        foreach ($subcategories as $sub) {
            $createdCategories[$sub['slug']] = Category::create([
                'parent_id' => $catRopa->id,
                'name' => $sub['name'],
                'slug' => $sub['slug'],
                'description' => "Sección exclusiva de {$sub['name']} Aelia Boutique.",
                'is_active' => true,
                'sort_order' => $sub['sort_order'],
            ]);
        }

        // Categorías especiales
        $catOfertas = Category::create([
            'name' => 'Ofertas Especiales',
            'slug' => 'ofertas-especiales',
            'description' => 'Prendas seleccionadas con descuentos exclusivos.',
            'is_active' => true,
            'sort_order' => 10,
        ]);

        $catNuevos = Category::create([
            'name' => 'Nuevos Lanzamientos',
            'slug' => 'nuevos-lanzamientos',
            'description' => 'Las últimas tendencias recién agregadas al catálogo.',
            'is_active' => true,
            'sort_order' => 11,
        ]);

        // 2. Colores Visuales
        $colorsData = [
            ['name' => 'Rosado Silk', 'slug' => 'rosado-silk', 'hex_code' => '#E5A8B1'],
            ['name' => 'Negro Azabache', 'slug' => 'negro-azabache', 'hex_code' => '#1A1A1A'],
            ['name' => 'Blanco Marfil', 'slug' => 'blanco-marfil', 'hex_code' => '#FDF3F4'],
            ['name' => 'Dorado Champagne', 'slug' => 'dorado-champagne', 'hex_code' => '#C5A059'],
        ];

        foreach ($colorsData as $c) {
            Color::create($c);
        }

        // 3. Atributos y Valores
        $attrTalla = Attribute::create([
            'name' => 'Talla',
            'slug' => 'talla',
            'type' => 'select',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $tallasValues = [];
        foreach (['S', 'M', 'L', 'XL'] as $idx => $talla) {
            $tallasValues[$talla] = AttributeValue::create([
                'attribute_id' => $attrTalla->id,
                'name' => $talla,
                'slug' => Str::slug($talla),
                'sort_order' => $idx + 1,
                'is_active' => true,
            ]);
        }

        $attrColor = Attribute::create([
            'name' => 'Color',
            'slug' => 'color',
            'type' => 'color',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $coloresValues = [];
        foreach ($colorsData as $idx => $c) {
            $coloresValues[$c['name']] = AttributeValue::create([
                'attribute_id' => $attrColor->id,
                'name' => $c['name'],
                'slug' => $c['slug'],
                'value' => $c['hex_code'],
                'sort_order' => $idx + 1,
                'is_active' => true,
            ]);
        }

        // 4. Productos de Muestra

        // Producto 1: Blusa Elegance Aelia
        $p1 = Product::create([
            'name' => 'Blusa Elegance Silk Aelia',
            'slug' => 'blusa-elegance-silk-aelia',
            'sku' => 'BL-ELEG-001',
            'short_description' => 'Blusa sofisticada de seda suave con caída fluida y puños sutilmente acampanados.',
            'description' => '<p>La <strong>Blusa Elegance Silk</strong> representa el equilibrio perfecto entre la elegancia atemporal y la comodidad moderna. Confeccionada en seda liviana de tacto sedoso, ideal para outfits ejecutivos o de noche.</p>',
            'base_price' => 129.90,
            'sale_price' => 99.90,
            'cost' => 45.00,
            'stock' => 0,
            'has_variants' => true,
            'is_active' => true,
            'is_featured' => true,
            'is_new' => true,
            'is_on_sale' => true,
            'published_at' => now(),
            'meta_title' => 'Blusa Elegance Silk - Aelia Boutique',
            'meta_description' => 'Compra la Blusa Elegance Silk en Aelia Boutique. Envíos a todo el Perú.',
        ]);

        $p1->categories()->sync([
            $createdCategories['blusas']->id,
            $catOfertas->id,
            $catNuevos->id,
        ]);

        // Variantes P1
        $variantsP1Data = [
            ['color' => 'Rosado Silk', 'talla' => 'S', 'sku' => 'BL-ELEG-001-RS-S', 'price' => 129.90, 'sale_price' => 99.90, 'stock' => 8],
            ['color' => 'Rosado Silk', 'talla' => 'M', 'sku' => 'BL-ELEG-001-RS-M', 'price' => 129.90, 'sale_price' => 99.90, 'stock' => 12],
            ['color' => 'Rosado Silk', 'talla' => 'L', 'sku' => 'BL-ELEG-001-RS-L', 'price' => 129.90, 'sale_price' => 99.90, 'stock' => 5],
            ['color' => 'Negro Azabache', 'talla' => 'S', 'sku' => 'BL-ELEG-001-NE-S', 'price' => 129.90, 'sale_price' => 109.90, 'stock' => 10],
            ['color' => 'Negro Azabache', 'talla' => 'M', 'sku' => 'BL-ELEG-001-NE-M', 'price' => 129.90, 'sale_price' => 109.90, 'stock' => 15],
        ];

        foreach ($variantsP1Data as $vData) {
            $variant = ProductVariant::create([
                'product_id' => $p1->id,
                'sku' => $vData['sku'],
                'name' => "{$vData['color']} / {$vData['talla']}",
                'price' => $vData['price'],
                'sale_price' => $vData['sale_price'],
                'cost' => 45.00,
                'stock' => $vData['stock'],
                'is_active' => true,
            ]);

            // Vincular atributos
            $variant->attributeValues()->attach([
                $coloresValues[$vData['color']]->id => ['attribute_id' => $attrColor->id],
                $tallasValues[$vData['talla']]->id => ['attribute_id' => $attrTalla->id],
            ]);

            // Imagen específica de la variante según su color
            $variantImg = $vData['color'] === 'Rosado Silk' 
                ? 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=800'
                : 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=800';

            $variant->images()->create([
                'path' => $variantImg,
                'alt' => "Blusa Elegance - {$vData['color']}",
                'sort_order' => 1,
            ]);
        }

        // Imágenes Generales P1
        $p1->images()->createMany([
            ['path' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=800', 'alt' => 'Blusa Elegance Rosada', 'is_primary' => true, 'sort_order' => 1],
            ['path' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=800', 'alt' => 'Blusa Elegance Negra', 'is_primary' => false, 'sort_order' => 2],
        ]);

        // Producto 2: Vestido Aurora Satin
        $p2 = Product::create([
            'name' => 'Vestido Aurora Satin Grace',
            'slug' => 'vestido-aurora-satin-grace',
            'sku' => 'VES-AUR-002',
            'short_description' => 'Vestido largo de satén premium con escote sutil y cintura entallada.',
            'description' => '<p>El <strong>Vestido Aurora Satin Grace</strong> resalta la silueta con gracia y sofisticación. Perfecto para galas y eventos nocturnos.</p>',
            'base_price' => 249.90,
            'sale_price' => null,
            'cost' => 90.00,
            'stock' => 0,
            'has_variants' => true,
            'is_active' => true,
            'is_featured' => true,
            'is_new' => true,
            'is_on_sale' => false,
            'published_at' => now(),
            'meta_title' => 'Vestido Aurora Satin Grace - Aelia Boutique',
            'meta_description' => 'Vestido de fiesta satinado diseño exclusivo Aelia Boutique.',
        ]);

        $p2->categories()->sync([
            $createdCategories['vestidos']->id,
            $catNuevos->id,
        ]);

        // Variantes P2
        $variantsP2Data = [
            ['color' => 'Dorado Champagne', 'talla' => 'S', 'sku' => 'VES-AUR-002-DO-S', 'price' => 249.90, 'stock' => 4],
            ['color' => 'Dorado Champagne', 'talla' => 'M', 'sku' => 'VES-AUR-002-DO-M', 'price' => 249.90, 'stock' => 6],
            ['color' => 'Blanco Marfil', 'talla' => 'S', 'sku' => 'VES-AUR-002-BL-S', 'price' => 249.90, 'stock' => 3],
        ];

        foreach ($variantsP2Data as $vData) {
            $variant = ProductVariant::create([
                'product_id' => $p2->id,
                'sku' => $vData['sku'],
                'name' => "{$vData['color']} / {$vData['talla']}",
                'price' => $vData['price'],
                'cost' => 90.00,
                'stock' => $vData['stock'],
                'is_active' => true,
            ]);

            $variant->attributeValues()->attach([
                $coloresValues[$vData['color']]->id => ['attribute_id' => $attrColor->id],
                $tallasValues[$vData['talla']]->id => ['attribute_id' => $attrTalla->id],
            ]);

            $variantImg = $vData['color'] === 'Dorado Champagne'
                ? 'https://images.unsplash.com/photo-1566174053879-31528523f8ae?w=800'
                : 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=800';

            $variant->images()->create([
                'path' => $variantImg,
                'alt' => "Vestido Aurora - {$vData['color']}",
                'sort_order' => 1,
            ]);
        }

        $p2->images()->createMany([
            ['path' => 'https://images.unsplash.com/photo-1566174053879-31528523f8ae?w=800', 'alt' => 'Vestido Aurora Champagne', 'is_primary' => true, 'sort_order' => 1],
            ['path' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=800', 'alt' => 'Vestido Aurora Blanco', 'is_primary' => false, 'sort_order' => 2],
        ]);

        // Producto 3: Polo Oversize Minimal (Sin variantes inicialmente)
        $p3 = Product::create([
            'name' => 'Polo Oversize Cotton Touch',
            'slug' => 'polo-oversize-cotton-touch',
            'sku' => 'POL-OVR-003',
            'short_description' => 'Polo oversize de algodón pima 100% peruano con caída libre estilo urbano chic.',
            'description' => '<p>Polo minimalista de corte amplio. Frescura y suave textura al tacto.</p>',
            'base_price' => 69.90,
            'sale_price' => 59.90,
            'cost' => 20.00,
            'stock' => 25,
            'has_variants' => false,
            'is_active' => true,
            'is_featured' => false,
            'is_new' => true,
            'is_on_sale' => true,
            'published_at' => now(),
            'meta_title' => 'Polo Oversize Cotton Touch - Aelia Boutique',
            'meta_description' => 'Polo casual premium en algodón pima peruano.',
        ]);

        $p3->categories()->sync([
            $createdCategories['polos']->id,
            $catOfertas->id,
        ]);

        $p3->images()->create([
            'path' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=800',
            'alt' => 'Polo Oversize Cotton Touch',
            'is_primary' => true,
            'sort_order' => 1,
        ]);
    }
}
