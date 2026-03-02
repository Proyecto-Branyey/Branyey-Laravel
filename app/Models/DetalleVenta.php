<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_ventas';
    public $timestamps = false;

    protected $fillable = ['venta_id', 'variante_id', 'cantidad', 'precio_cobrado'];

    public function venta() {
        return $this->belongsTo(Venta::class, 'venta_id');
    }

    public function variante() {
        return $this->belongsTo(Variante::class, 'variante_id');
    }
}