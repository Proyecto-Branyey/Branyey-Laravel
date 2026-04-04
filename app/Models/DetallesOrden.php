<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetallesOrden extends Model
{
    // Solo si añades la columna a la DB, si no, puedes borrar esta línea
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
    
    // Desactivamos timestamps porque no están en tu SQL para esta tabla
    public $timestamps = false;

    /**
     * Relación: El detalle de envío pertenece a una venta.
     */
    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }
}