<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request, ?string $categorySlug = null)
    {
        $selectedCategory = null;
        if ($categorySlug) {
            $selectedCategory = Category::where('slug', $categorySlug)->firstOrFail();
        }

        $query = Product::query()
            ->active()
            ->with(['primaryImage', 'categories', 'variants.attributeValues']);

        // Filter by category
        if ($selectedCategory) {
            $query->whereHas('categories', function ($q) use ($selectedCategory) {
                $q->where('categories.id', $selectedCategory->id);
            });
        } elseif ($request->has('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.slug', $request->get('category'));
            });
        }

        // Search term
        if ($request->filled('q')) {
            $term = $request->get('q');
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('short_description', 'like', "%{$term}%")
                  ->orWhere('sku', 'like', "%{$term}%");
            });
        }

        // Price filter
        if ($request->filled('min_price')) {
            $query->where('base_price', '>=', (float) $request->get('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('base_price', '<=', (float) $request->get('max_price'));
        }

        // Special filters
        if ($request->boolean('featured')) {
            $query->featured();
        }
        if ($request->boolean('new')) {
            $query->newReleases();
        }
        if ($request->boolean('on_sale')) {
            $query->onSale();
        }

        // Color filter
        if ($request->filled('color')) {
            $colorParam = $request->get('color');
            $query->where(function ($q) use ($colorParam) {
                $q->whereHas('variants.attributeValues', function ($attrQ) use ($colorParam) {
                    $attrQ->where('attribute_values.slug', $colorParam);
                    if (is_numeric($colorParam)) {
                        $attrQ->orWhere('attribute_values.id', (int) $colorParam);
                    }
                })
                ->orWhereHas('variants', function ($varQ) use ($colorParam) {
                    $varQ->where('name', 'like', "%{$colorParam}%");
                })
                ->orWhere('name', 'like', "%{$colorParam}%");
            });
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'price_low' => $query->orderBy('base_price', 'asc'),
            'price_high' => $query->orderBy('base_price', 'desc'),
            'popular' => $query->where('is_featured', true)->latest(),
            default => $query->latest('published_at'),
        };

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::roots()->active()->with('children')->get();
        $colors = Color::active()->get();
        $attributes = Attribute::active()->with('values')->get();

        return view('catalog.index', compact(
            'products',
            'categories',
            'selectedCategory',
            'colors',
            'attributes'
        ));
    }
}
