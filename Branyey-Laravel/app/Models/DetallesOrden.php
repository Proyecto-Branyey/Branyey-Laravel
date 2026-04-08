<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetallesOrden extends Model
{
    protected $table = 'detalles_orden';

    protected $fillable = [
        'venta_id',
        'nombre_cliente',
        'email_cliente',
        'telefono_cliente',
        'direccion_envio',
        'ciudad',
        'departamento',
    ];

    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }
}
