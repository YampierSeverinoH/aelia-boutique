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
        \Illuminate\Support\Facades\Mail::fake();

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

        \Illuminate\Support\Facades\Mail::assertSent(\App\Mail\OrderConfirmationCustomerMail::class);
        \Illuminate\Support\Facades\Mail::assertSent(\App\Mail\OrderNotificationAdminMail::class);
    }

    public function test_complaints_book_notifications(): void
    {
        \Illuminate\Support\Facades\Mail::fake();

        $response = $this->post('/libro-de-reclamaciones/enviar', [
            'fullname' => 'Ana López',
            'dni' => '44556677',
            'email' => 'ana@example.com',
            'phone' => '912345678',
            'address' => 'Calle Los Olivos 123',
            'contracted_type' => 'producto',
            'amount' => 129.90,
            'description_good' => 'Blusa Elegance Rosada',
            'complaint_type' => 'reclamo',
            'description' => 'La costura del botón vino suelta.',
            'consumer_request' => 'Solicito cambio de la prenda.',
        ]);

        $response->assertRedirect();
        \Illuminate\Support\Facades\Mail::assertSent(\App\Mail\ComplaintConfirmationCustomerMail::class);
        \Illuminate\Support\Facades\Mail::assertSent(\App\Mail\ComplaintNotificationAdminMail::class);
    }

    public function test_contact_form_notifications(): void
    {
        \Illuminate\Support\Facades\Mail::fake();

        $response = $this->post('/contacto/enviar', [
            'name' => 'Carlos Pérez',
            'email' => 'carlos@example.com',
            'phone' => '998877665',
            'subject' => 'Consulta sobre disponibilidad',
            'message' => 'Deseo saber si habrá reposición del vestido Aurora en talla S.',
        ]);

        $response->assertRedirect();
        \Illuminate\Support\Facades\Mail::assertSent(\App\Mail\ContactMessageAdminMail::class);
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
