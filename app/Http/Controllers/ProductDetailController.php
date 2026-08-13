<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductCatalogService;

class ProductDetailController extends Controller
{
    protected ProductCatalogService $catalogService;

    public function __construct(ProductCatalogService $catalogService)
    {
        $this->catalogService = $catalogService;
    }

    public function show(string $slug)
    {
        $product = $this->catalogService->getProductBySlug($slug);

        // Related products from the same category
        $relatedProducts = Product::query()
            ->active()
            ->where('id', '!=', $product->id)
            ->whereHas('categories', function ($q) use ($product) {
                $q->whereIn('categories.id', $product->categories->pluck('id'));
            })
            ->with(['primaryImage', 'categories'])
            ->take(4)
            ->get();

        return view('catalog.detail', compact('product', 'relatedProducts'));
    }
}
