<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetallesOrden extends Model
{
    use SoftDeletes;

    protected $table = 'detalles_orden';

    protected $fillable = [
        'venta_id',
        'nombre_cliente',
        'email_cliente',
        'telefono_cliente',
        'direccion_envio',
        'ciudad',
        'departamento'
    ];
    
    protected $dates = ['deleted_at'];

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }
}