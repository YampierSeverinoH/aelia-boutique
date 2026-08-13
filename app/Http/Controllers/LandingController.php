<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Company;

class LandingController extends Controller
{
    public function index()
    {
        $company = Company::first();
        $banner = Banner::latest()->first();

        return view('landing.bio', compact('company', 'banner'));
    }
}
