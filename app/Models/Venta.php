<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Venta extends Model {

    /**
     * Filtros avanzados para reportes y listados de ventas.
     */
    public function scopeFiltros($query, $filtros)
    {
        // Filtrar por cliente (nombre_completo, email, teléfono)
        if (!empty($filtros['cliente'])) {
            $query->whereHas('usuario', function ($q) use ($filtros) {
                $q->where('nombre_completo', 'like', '%'.$filtros['cliente'].'%')
                  ->orWhere('email', 'like', '%'.$filtros['cliente'].'%')
                  ->orWhere('telefono', 'like', '%'.$filtros['cliente'].'%');
            });
        }

        // Filtrar por tipo de cliente (rol)
        if (!empty($filtros['tipo_cliente'])) {
            $tipo = $filtros['tipo_cliente'];
            $query->whereHas('usuario.rol', function ($q) use ($tipo) {
                if ($tipo === 'mayorista') {
                    $q->where('nombre', 'like', '%mayorista%');
                } elseif ($tipo === 'minorista') {
                    $q->where('nombre', 'like', '%minorista%');
                }
            });
        }

        // Filtrar por estado
        if (!empty($filtros['estado'])) {
            $query->where('estado', $filtros['estado']);
        }

        // Filtrar por fecha desde
        if (!empty($filtros['fecha_desde'])) {
            $query->whereDate('created_at', '>=', $filtros['fecha_desde']);
        }

        // Filtrar por fecha hasta
        if (!empty($filtros['fecha_hasta'])) {
            $query->whereDate('created_at', '<=', $filtros['fecha_hasta']);
        }

        // Filtrar por total mínimo
        if (!empty($filtros['total_min'])) {
            $query->where('total', '>=', $filtros['total_min']);
        }

        // Filtrar por total máximo
        if (!empty($filtros['total_max'])) {
            $query->where('total', '<=', $filtros['total_max']);
        }

        return $query;
    }
    // Solo úsalo si agregaste la columna deleted_at a la tabla 'ventas'
    use SoftDeletes; 

    protected $table = 'ventas';

    protected $fillable = [
        'usuario_id',
        'total',
        'estado',
    ];
    
    protected $casts = [
        'total' => 'float',
        'usuario_id' => 'integer',
    ];

    // Estados de venta para el flujo operativo del negocio
    const ESTADO_PAGADO = 'pagado';
    const ESTADO_EN_PROCESO = 'en_proceso';
    const ESTADO_ENVIADO = 'enviado';
    const ESTADO_ENTREGADO = 'entregado';
    const ESTADO_CANCELADO = 'cancelado';

    public static function estadosDisponibles(): array
    {
        return [
            self::ESTADO_PAGADO => 'Pagado',
            self::ESTADO_EN_PROCESO => 'En proceso',
            self::ESTADO_ENVIADO => 'Enviado',
            self::ESTADO_ENTREGADO => 'Entregado',
            self::ESTADO_CANCELADO => 'Cancelado',
        ];
    }

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
        return $this->hasOne(DetallesOrden::class, 'venta_id');
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
        return formatPriceCOP($this->total); // Formato moneda colombiana
    }

    public function getEstadoLabelAttribute(): string
    {
        return self::estadosDisponibles()[$this->estado] ?? ucfirst(str_replace('_', ' ', $this->estado));
    }

    public function getEstadoBadgeAttribute(): string
    {
        $clases = [
            self::ESTADO_PAGADO => 'success',
            self::ESTADO_EN_PROCESO => 'warning',
            self::ESTADO_ENVIADO => 'primary',
            self::ESTADO_ENTREGADO => 'info',
            self::ESTADO_CANCELADO => 'danger',
        ];
        
        $clase = $clases[$this->estado] ?? 'secondary';
        return "<span class='badge bg-{$clase}'>" . $this->estado_label . "</span>";
    }
}