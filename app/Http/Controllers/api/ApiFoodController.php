<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ApiFoodController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'Lista de productos',
            'data' => Product::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Producto creado',
            'data' => $product
        ], 201);
    }

    public function show(Product $product)
    {
        return response()->json([
            'status' => true,
            'message' => 'Detalle del producto',
            'data' => $product
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
           
        ]);

        $product->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Producto actualizado',
            'data' => $product
        ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Producto eliminado'
        ]);
    }
}
