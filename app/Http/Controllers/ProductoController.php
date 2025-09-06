<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Listar productos
    public function index()
    {
        return Producto::all();
    }

    // Crear producto
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:0',
            'fecha_vencimiento' => 'required|date',
            'precio_unitario' => 'required|numeric|min:0',
        ]);

        return Producto::create($request->all());
    }

    // Mostrar un producto por ID
    public function show($id)
    {
        return Producto::findOrFail($id);
    }

    // Actualizar producto
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:0',
            'fecha_vencimiento' => 'required|date',
            'precio_unitario' => 'required|numeric|min:0',
        ]);

        $producto->update($request->all());
        return $producto;
    }

    // Eliminar producto
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return response()->json(['message' => 'Producto eliminado']);
    }

    // Ajustar stock (entrada o salida)
    public function ajustarStock(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'tipo' => 'required|in:entrada,salida',
            'cantidad' => 'required|integer|min:1',
        ]);

        if ($request->tipo === 'entrada') {
            $producto->cantidad += $request->cantidad;
        } else {
            if ($producto->cantidad < $request->cantidad) {
                return response()->json(['error' => 'Stock insuficiente'], 400);
            }
            $producto->cantidad -= $request->cantidad;
        }

        $producto->save();
        return $producto;
    }
}