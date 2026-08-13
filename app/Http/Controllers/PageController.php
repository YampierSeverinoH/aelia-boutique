<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Company;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $about = About::first();
        return view('pages.about', compact('about'));
    }

    public function contact()
    {
        $company = Company::first();
        return view('pages.contact', compact('company'));
    }

    public function terms()
    {
        $company = Company::first();
        return view('pages.terms', compact('company'));
    }

    public function complaintsBook()
    {
        $company = Company::first();
        return view('pages.complaints-book', compact('company'));
    }

    public function processComplaint(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'dni' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:30',
            'address' => 'required|string|max:500',
            'complaint_type' => 'required|string|in:reclamo,queja',
            'description' => 'required|string|max:2000',
        ]);

        return redirect()->back()->with('success', 'Su reclamo/queja ha sido registrado exitosamente con el código ' . rand(10000, 99999) . '. Nos pondremos en contacto a la brevedad.');
    }
}
