<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Offer;
use App\Services\ProductCatalogService;

class HomeController extends Controller
{
    protected ProductCatalogService $catalogService;

    public function __construct(ProductCatalogService $catalogService)
    {
        $this->catalogService = $catalogService;
    }

    public function index()
    {
        $banners = Banner::latest()->get();
        $categories = Category::roots()->active()->with('children')->get();
        $offers = Offer::active()->get();
        $featuredProducts = $this->catalogService->getFeaturedProducts(8);
        $newReleases = $this->catalogService->getNewReleases(8);
        $onSaleProducts = $this->catalogService->getOnSaleProducts(8);

        return view('home', compact(
            'banners',
            'categories',
            'offers',
            'featuredProducts',
            'newReleases',
            'onSaleProducts'
        ));
    }
}
