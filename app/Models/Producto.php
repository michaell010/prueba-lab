<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MovimientoInventario; 

class Producto extends Model
{
    protected $table = 'productos_terminados';
    protected $fillable = [
    'nombre',
    'cantidad',
    'fecha_vencimiento',
    'precio_unitario'
];

    protected $casts = [
        'precio_venta' => 'decimal:2',
    ];

    public function movimientos()
    {
        return $this->hasMany(MovimientoInventario::class, 'item_id')
                    ->where('tipo_inventario', 'producto');
    }

    public function agregarStock($cantidad, $motivo = 'Entrada manual')
    {
        $this->stock_actual += $cantidad;
        $this->save();

        MovimientoInventario::create([
            'tipo_inventario' => 'producto',
            'item_id' => $this->id,
            'tipo_movimiento' => 'entrada',
            'cantidad' => $cantidad,
            'valor_unitario' => $this->precio_venta,
            'valor_total' => $cantidad * $this->precio_venta,
            'motivo' => $motivo
        ]);
    }

    public function reducirStock($cantidad, $motivo = 'Salida manual')
    {
        if ($this->stock_actual >= $cantidad) {
            $this->stock_actual -= $cantidad;
            $this->save();

            MovimientoInventario::create([
                'tipo_inventario' => 'producto',
                'item_id' => $this->id,
                'tipo_movimiento' => 'salida',
                'cantidad' => $cantidad,
                'valor_unitario' => $this->precio_venta,
                'valor_total' => $cantidad * $this->precio_venta,
                'motivo' => $motivo
            ]);

            return true;
        }
        return false;
    }

    public function stockBajo()
    {
        return $this->stock_actual <= $this->stock_minimo;
    }
}