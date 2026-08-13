<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\ShippingRate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendStorefrontTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_landing_bio_page_loads(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200)
            ->assertSee('Aelia Boutique')
            ->assertSee('Tienda Virtual');
    }

    public function test_home_storefront_page_loads(): void
    {
        $response = $this->get('/tienda');
        $response->assertStatus(200)
            ->assertSee('Categorías Principales')
            ->assertSee('Nuevos Lanzamientos');
    }

    public function test_catalog_page_loads(): void
    {
        $response = $this->get('/catalogo');
        $response->assertStatus(200)
            ->assertSee('Colección Completa');
    }

    public function test_color_filtered_catalog_loads(): void
    {
        $response = $this->get('/catalogo?color=rosado-silk');
        $response->assertStatus(200)
            ->assertSee('Colección Completa');
    }

    public function test_category_filtered_catalog_loads(): void
    {
        $category = Category::first();
        $response = $this->get('/categoria/' . $category->slug);
        $response->assertStatus(200)
            ->assertSee($category->name);
    }

    public function test_product_detail_page_loads(): void
    {
        $product = Product::first();
        $response = $this->get('/producto/' . $product->slug);
        $response->assertStatus(200)
            ->assertSee($product->name);
    }

    public function test_cart_add_and_json_endpoint(): void
    {
        $product = Product::first();
        
        $response = $this->postJson('/carrito/agregar', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $getCart = $this->getJson('/carrito');
        $getCart->assertStatus(200)
            ->assertJsonPath('total_count', 2);
    }

    public function test_checkout_page_and_order_submission(): void
    {
        $product = Product::first();
        $shippingRate = ShippingRate::first();

        // Add item to cart first
        $this->postJson('/carrito/agregar', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->get('/checkout');
        $response->assertStatus(200)
            ->assertSee('Finalizar Compra');

        // Submit order
        $orderPost = $this->post('/checkout/procesar', [
            'customer_name' => 'María García',
            'customer_email' => 'maria@example.com',
            'customer_phone' => '987654321',
            'document_type' => 'DNI',
            'document_number' => '76543210',
            'shipping_address' => 'Av. Conquistadores 456',
            'region' => 'Lima',
            'province' => 'Lima',
            'district' => 'San Isidro',
            'shipping_rate_id' => $shippingRate->id,
            'payment_method' => 'bank_transfer',
        ]);

        $orderPost->assertRedirect();
        
        $this->assertDatabaseHas('orders', [
            'customer_email' => 'maria@example.com',
            'customer_name' => 'María García',
        ]);
    }

    public function test_order_tracking_page(): void
    {
        $response = $this->get('/seguimiento');
        $response->assertStatus(200)
            ->assertSee('Seguimiento de Pedido');
    }

    public function test_static_pages_load(): void
    {
        $this->get('/nosotros')->assertStatus(200)->assertSee('Aelia Boutique');
        $this->get('/contacto')->assertStatus(200)->assertSee('Contáctanos');
        $this->get('/terminos-y-condiciones')->assertStatus(200)->assertSee('Términos');
        $this->get('/libro-de-reclamaciones')->assertStatus(200)->assertSee('Libro de Reclamaciones');
    }
}
