<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    protected $table = 'movimientos_inventario';
    
    protected $fillable = [
        'tipo_inventario', 'item_id', 'tipo_movimiento',
        'cantidad', 'valor_unitario', 'valor_total', 'motivo', 'fecha_movimiento'
    ];

    protected $casts = [
        'valor_unitario' => 'decimal:2',
        'valor_total' => 'decimal:2',
        'fecha_movimiento' => 'datetime',
    ];
}