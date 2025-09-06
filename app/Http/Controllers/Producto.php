<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('movimientos')->get();
        return response()->json($productos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_venta' => 'required|numeric|min:0',
            'stock_actual' => 'nullable|integer|min:0',
            'stock_minimo' => 'nullable|integer|min:0',
            'unidad_medida' => 'nullable|string'
        ]);

        $producto = Producto::create($request->all());
        return response()->json($producto, 201);
    }

    public function show($id)
    {
        $producto = Producto::with('movimientos')->findOrFail($id);
        return response()->json($producto);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_venta' => 'required|numeric|min:0',
            'stock_actual' => 'nullable|integer|min:0',
            'stock_minimo' => 'nullable|integer|min:0',
            'unidad_medida' => 'nullable|string'
        ]);

        $producto->update($request->all());
        return response()->json($producto);
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return response()->json(['message' => 'Producto eliminado correctamente']);
    }

    public function ajustarStock(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        
        $request->validate([
            'tipo' => 'required|in:entrada,salida',
            'cantidad' => 'required|integer|min:1',
            'motivo' => 'nullable|string'
        ]);

        if ($request->tipo === 'entrada') {
            $producto->agregarStock($request->cantidad, $request->motivo);
        } else {
            $success = $producto->reducirStock($request->cantidad, $request->motivo);
            if (!$success) {
                return response()->json(['error' => 'Stock insuficiente'], 400);
            }
        }

        return response()->json($producto->fresh());
    }
}