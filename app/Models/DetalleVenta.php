<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleVenta extends Model
{
    use SoftDeletes;
    
    protected $table = 'detalle_ventas';

    protected $fillable = [
        'venta_id',
        'variante_id', 
        'cantidad',
        'precio_cobrado'
    ];

    public function venta() 
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }

    public function variante() 
    {
        return $this->belongsTo(Variante::class, 'variante_id');
    }
}