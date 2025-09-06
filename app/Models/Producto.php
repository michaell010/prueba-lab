<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    
    protected $table = 'productos_terminados';
    
    protected $fillable = [
        'nombre',
        'cantidad',
        'fecha_vencimiento',
        'precio_unitario'
    ];
    
    protected $casts = [
        'fecha_vencimiento' => 'date:Y-m-d',  // ← Formato limpio sin tiempo
        'precio_unitario' => 'decimal:2',
        'cantidad' => 'integer'
    ];
}