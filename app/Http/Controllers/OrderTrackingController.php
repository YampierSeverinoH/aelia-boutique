<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function index(Request $request)
    {
        $order = null;
        $searched = false;

        if ($request->filled('order_number')) {
            $searched = true;
            $orderNumber = trim($request->get('order_number'));
            $order = Order::with('items')->where('order_number', $orderNumber)->first();
        }

        return view('tracking.index', compact('order', 'searched'));
    }
}
