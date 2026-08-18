<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductDetailController;
use Illuminate\Support\Facades\Route;

// Ruta Raíz: Landing Bio Linktree (Bienvenida Premium Aelia)
Route::get('/', [LandingController::class, 'index'])->name('landing.bio');

// Tienda Virtual E-commerce Principal
Route::get('/tienda', [HomeController::class, 'index'])->name('home');

// Catálogo y Búsqueda
Route::get('/catalogo', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/categoria/{slug}', [CatalogController::class, 'index'])->name('catalog.category');
Route::get('/producto/{slug}', [ProductDetailController::class, 'show'])->name('catalog.detail');

// Carrito AJAX / Off-Canvas
Route::prefix('carrito')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/agregar', [CartController::class, 'store'])->name('add');
    Route::post('/actualizar/{key}', [CartController::class, 'update'])->name('update');
    Route::delete('/eliminar/{key}', [CartController::class, 'destroy'])->name('remove');
});

// Checkout y Procesamiento de Pedidos
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/procesar', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/pedido/confirmacion/{order_number}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');

// Rastrear Pedido
Route::get('/seguimiento', [OrderTrackingController::class, 'index'])->name('tracking.index');

// Páginas Informativas
Route::get('/nosotros', [PageController::class, 'about'])->name('pages.about');
Route::get('/contacto', [PageController::class, 'contact'])->name('pages.contact');
Route::post('/contacto/enviar', [PageController::class, 'processContact'])->name('pages.contact.store');
Route::get('/terminos-y-condiciones', [PageController::class, 'terms'])->name('pages.terms');
Route::get('/libro-de-reclamaciones', [PageController::class, 'complaintsBook'])->name('pages.complaints-book');
Route::post('/libro-de-reclamaciones/enviar', [PageController::class, 'processComplaint'])->name('pages.complaints-book.store');
