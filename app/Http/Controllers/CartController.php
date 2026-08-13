<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->cartService->getCart());
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $this->cartService->add(
            $request->integer('product_id'),
            $request->input('variant_id') ? $request->integer('variant_id') : null,
            $request->integer('quantity', 1)
        );

        return response()->json([
            'success' => true,
            'message' => 'Prenda agregada al carrito con éxito',
            'cart' => $cart,
        ]);
    }

    public function update(Request $request, string $key): JsonResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $cart = $this->cartService->update($key, $request->integer('quantity'));

        return response()->json([
            'success' => true,
            'cart' => $cart,
        ]);
    }

    public function destroy(string $key): JsonResponse
    {
        $cart = $this->cartService->remove($key);

        return response()->json([
            'success' => true,
            'message' => 'Prenda removida del carrito',
            'cart' => $cart,
        ]);
    }
}
