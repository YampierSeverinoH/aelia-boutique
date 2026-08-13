<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProductCatalogService
{
    /**
     * Obtener productos destacados para el inicio / vitrina.
     */
    public function getFeaturedProducts(int $limit = 8): Collection
    {
        return Product::query()
            ->active()
            ->featured()
            ->with(['primaryImage', 'categories', 'variants.attributeValues'])
            ->latest('published_at')
            ->take($limit)
            ->get();
    }

    /**
     * Obtener nuevos lanzamientos.
     */
    public function getNewReleases(int $limit = 8): Collection
    {
        return Product::query()
            ->active()
            ->newReleases()
            ->with(['primaryImage', 'categories', 'variants.attributeValues'])
            ->latest('published_at')
            ->take($limit)
            ->get();
    }

    /**
     * Obtener productos en oferta.
     */
    public function getOnSaleProducts(int $limit = 8): Collection
    {
        return Product::query()
            ->active()
            ->onSale()
            ->with(['primaryImage', 'categories', 'variants.attributeValues'])
            ->latest('published_at')
            ->take($limit)
            ->get();
    }

    /**
     * Obtener listado de productos filtrados por categoría.
     */
    public function getProductsByCategory(string $categorySlug, int $perPage = 12): LengthAwarePaginator
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();

        return Product::query()
            ->active()
            ->whereHas('categories', function ($q) use ($category) {
                $q->where('categories.id', $category->id);
            })
            ->with(['primaryImage', 'categories', 'variants.attributeValues'])
            ->latest('published_at')
            ->paginate($perPage);
    }

    /**
     * Obtener detalle completo de un producto por su slug.
     */
    public function getProductBySlug(string $slug): Product
    {
        return Product::query()
            ->active()
            ->where('slug', $slug)
            ->with([
                'categories',
                'images',
                'videos',
                'variants' => fn ($q) => $q->active()->with(['attributeValues.attribute', 'images']),
            ])
            ->firstOrFail();
    }

    /**
     * Búsqueda general de productos por término de texto.
     */
    public function searchProducts(string $term, int $perPage = 12): LengthAwarePaginator
    {
        return Product::query()
            ->active()
            ->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('short_description', 'like', "%{$term}%")
                  ->orWhere('sku', 'like', "%{$term}%");
            })
            ->with(['primaryImage', 'categories', 'variants.attributeValues'])
            ->latest('published_at')
            ->paginate($perPage);
    }
}
