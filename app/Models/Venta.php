<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Venta extends Model
{
    // Solo úsalo si agregaste la columna deleted_at a la tabla 'ventas'
    use SoftDeletes; 

    protected $table = 'ventas';

    protected $fillable = [
        'usuario_id',
        'total',
        'estado',
        'fecha'
    ];
    
    protected $casts = [
        'total' => 'float',
        'fecha' => 'datetime',
        'usuario_id' => 'integer',
    ];

    // Constantes de Estado (Excelentes para mantener orden)
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_PAGADO = 'pagado';
    const ESTADO_ENVIADO = 'enviado';
    const ESTADO_CANCELADO = 'cancelado';

    /*
    |--------------------------------------------------------------------------
    | RELACIONES (Ajustadas a tu DB)
    |--------------------------------------------------------------------------
    */
    
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
    
    public function detallesOrden(): HasOne
    {
        // Apuntamos al modelo que maneja la tabla 'detalles_orden'
        return $this->hasOne(DetalleOrden::class, 'venta_id');
    }
    
    public function detallesVenta(): HasMany
    {
        // Apuntamos al modelo que maneja la tabla 'detalle_ventas'
        return $this->hasMany(DetalleVenta::class, 'venta_id');
    }

    /*
    |--------------------------------------------------------------------------
    | LÓGICA DE NEGOCIO
    |--------------------------------------------------------------------------
    */

    public function recalcularTotal(): float
    {
        // Calculamos multiplicando cantidad por precio_cobrado (según tu SQL)
        $total = $this->detallesVenta->sum(function($detalle) {
            return $detalle->cantidad * $detalle->precio_cobrado;
        });

        $this->update(['total' => $total]);
        return $total;
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS (Para las vistas de Branyey)
    |--------------------------------------------------------------------------
    */

    public function getTotalFormateadoAttribute(): string
    {
        return '$' . number_format($this->total, 0, ',', '.'); // Formato moneda colombiana
    }

    public function getEstadoBadgeAttribute(): string
    {
        $clases = [
            self::ESTADO_PENDIENTE => 'warning',
            self::ESTADO_PAGADO => 'success',
            self::ESTADO_ENVIADO => 'info',
            self::ESTADO_CANCELADO => 'danger',
        ];
        
        $clase = $clases[$this->estado] ?? 'secondary';
        return "<span class='badge bg-{$clase}'>" . ucfirst($this->estado) . "</span>";
    }
}