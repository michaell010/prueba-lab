<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\MateriaPrimaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Productos terminados
    Route::apiResource('productos', ProductoController::class);
    Route::post('productos/{id}/ajustar-stock', [ProductoController::class, 'ajustarStock']);
    
    // Materias primas
    Route::apiResource('materias-primas', MateriaPrimaController::class);
    Route::post('materias-primas/{id}/ajustar-stock', [MateriaPrimaController::class, 'ajustarStock']);
    
    // Resumen
    Route::get('dashboard', function() {
        $productos = \App\Models\Producto::all();
        $materias = \App\Models\MateriaPrima::all();
        
        return response()->json([
            'productos_stock_bajo' => $productos->filter(fn($p) => $p->stockBajo()),
            'materias_stock_bajo' => $materias->filter(fn($m) => $m->stockBajo()),
            'materias_vencidas' => $materias->filter(fn($m) => $m->estaVencida()),
            'total_productos' => $productos->count(),
            'total_materias' => $materias->count(),
            'valor_total_productos' => $productos->sum(function($p) {
                return $p->stock_actual * $p->precio_venta;
            }),
            'valor_total_materias' => $materias->sum(function($m) {
                return $m->stock_actual * $m->costo_unitario;
            })
        ]);
    });
});