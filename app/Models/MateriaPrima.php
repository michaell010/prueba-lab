<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MovimientoInventario;

class MateriaPrima extends Model
{
    protected $fillable = [
        'nombre', 'descripcion', 'costo_unitario', 'stock_actual',
        'stock_minimo', 'unidad_medida', 'fecha_vencimiento'
    ];

    protected $casts = [
        'costo_unitario' => 'decimal:2',
        'fecha_vencimiento' => 'date',
    ];

    public function movimientos()
    {
        return $this->hasMany(MovimientoInventario::class, 'item_id')
                    ->where('tipo_inventario', 'materia_prima');
    }

    public function agregarStock($cantidad, $motivo = 'Compra')
    {
        $this->stock_actual += $cantidad;
        $this->save();

        MovimientoInventario::create([
            'tipo_inventario' => 'materia_prima',
            'item_id' => $this->id,
            'tipo_movimiento' => 'entrada',
            'cantidad' => $cantidad,
            'valor_unitario' => $this->costo_unitario,
            'valor_total' => $cantidad * $this->costo_unitario,
            'motivo' => $motivo
        ]);
    }

    public function reducirStock($cantidad, $motivo = 'Uso en producción')
    {
        if ($this->stock_actual >= $cantidad) {
            $this->stock_actual -= $cantidad;
            $this->save();

            MovimientoInventario::create([
                'tipo_inventario' => 'materia_prima',
                'item_id' => $this->id,
                'tipo_movimiento' => 'salida',
                'cantidad' => $cantidad,
                'valor_unitario' => $this->costo_unitario,
                'valor_total' => $cantidad * $this->costo_unitario,
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

    public function estaVencida()
    {
        return $this->fecha_vencimiento && $this->fecha_vencimiento < now();
    }
}