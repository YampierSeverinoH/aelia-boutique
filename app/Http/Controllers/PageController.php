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
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'dni' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:30',
            'address' => 'required|string|max:500',
            'contracted_type' => 'required|string|in:producto,servicio',
            'amount' => 'required|numeric|min:0',
            'description_good' => 'required|string|max:500',
            'complaint_type' => 'required|string|in:reclamo,queja',
            'description' => 'required|string|max:2000',
            'consumer_request' => 'required|string|max:1000',
        ]);

        $code = 'LR-' . date('Ymd') . '-' . rand(1000, 9999);
        $date = now()->format('d/m/Y H:i');

        $claimData = [
            'code' => $code,
            'date' => $date,
            'name' => $validated['fullname'],
            'document_type' => strlen($validated['dni']) === 8 ? 'DNI' : (strlen($validated['dni']) === 11 ? 'RUC' : 'CE'),
            'document_number' => $validated['dni'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'contracted_type' => $validated['contracted_type'],
            'amount' => (float) $validated['amount'],
            'description_good' => $validated['description_good'],
            'claim_type' => $validated['complaint_type'],
            'detail' => $validated['description'],
            'request' => $validated['consumer_request'],
        ];

        try {
            $company = Company::first();
            $adminEmail = optional($company)->correo_notificaciones ?: (optional($company)->correo ?: 'notificaciones@aeliastore.pe');

            // 1. Notificar al cliente con PDF de la Hoja de Reclamación
            \Illuminate\Support\Facades\Mail::to($claimData['email'])->send(new \App\Mail\ComplaintConfirmationCustomerMail($claimData));

            // 2. Notificar a la empresa
            \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\ComplaintNotificationAdminMail($claimData));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Error enviando correos de Libro de Reclamaciones: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', "Su reclamo/queja ha sido registrado exitosamente con el código {$code}. Se ha enviado una copia en PDF a su correo.");
    }

    public function processContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:3000',
        ]);

        try {
            $company = Company::first();
            $adminEmail = optional($company)->correo_notificaciones ?: (optional($company)->correo ?: 'notificaciones@aeliastore.pe');

            // Notificar únicamente a la empresa
            \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\ContactMessageAdminMail($validated));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Error enviando correo de contacto: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', '¡Gracias por contactarnos! Tu mensaje ha sido recibido y te responderemos a la brevedad.');
    }
}
