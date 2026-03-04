<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venta extends Model
{
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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'usuario_id' => 'integer',
    ];

    protected $dates = ['deleted_at'];
    
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_PAGADO = 'pagado';
    const ESTADO_ENVIADO = 'enviado';
    const ESTADO_CANCELADO = 'cancelado';
    
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
    
    public function detallesOrden()
    {
        return $this->hasOne(DetallesOrden::class);
    }
    
    public function detallesVenta()
    {
        return $this->hasMany(DetalleVenta::class);
    }
    
    public function estadoEs(string $estado): bool
    {
        return $this->estado === $estado;
    }
    
    public function estaPendiente(): bool
    {
        return $this->estadoEs(self::ESTADO_PENDIENTE);
    }
    
    public function estaPagada(): bool
    {
        return $this->estadoEs(self::ESTADO_PAGADO);
    }
    
    public function estaEnviada(): bool
    {
        return $this->estadoEs(self::ESTADO_ENVIADO);
    }
    
    public function estaCancelada(): bool
    {
        return $this->estadoEs(self::ESTADO_CANCELADO);
    }
    
    public function cambiarEstado(string $nuevoEstado): bool
    {
        if (!in_array($nuevoEstado, [
            self::ESTADO_PENDIENTE,
            self::ESTADO_PAGADO,
            self::ESTADO_ENVIADO,
            self::ESTADO_CANCELADO
        ])) {
            return false;
        }
        
        $this->estado = $nuevoEstado;
        return $this->save();
    }
    
    /**
     * Recalcular total desde cada detalle en la venta
     */
    public function recalcularTotal(): float
    {
        $total = $this->detallesVenta->sum('subtotal');
        $this->total = $total;
        $this->save();
        
        return $total;
    }

    public function getFechaFormateadaAttribute(): string
    {
        return $this->fecha->format('d/m/Y H:i');
    }
    
    public function getCreadoFormateadoAttribute(): string
    {
        return $this->created_at->format('d/m/Y H:i');
    }
    
    public function getActualizadoFormateadoAttribute(): string
    {
        return $this->updated_at->format('d/m/Y H:i');
    }
    
    public function getTotalFormateadoAttribute(): string
    {
        return '$' . number_format($this->total, 2);
    }
    
    /**
     * Badge de estado para vistas - configurado con bootstrap
     */
    public function getEstadoBadgeAttribute(): string
    {
        $clases = [
            self::ESTADO_PENDIENTE => 'warning',
            self::ESTADO_PAGADO => 'success',
            self::ESTADO_ENVIADO => 'info',
            self::ESTADO_CANCELADO => 'danger',
        ];
        
        $clase = $clases[$this->estado] ?? 'secondary';
        $texto = ucfirst($this->estado);
        
        return "<span class='badge bg-{$clase}'>{$texto}</span>";
    }
    
    /**
     * Información de auditoría
     */
    public function getInfoAuditoriaAttribute(): array
    {
        return [
            'registrada_por' => $this->usuario?->name ?? 'Usuario no disponible',
            'fecha_registro' => $this->creado_formateado,
            'fecha_venta' => $this->fecha_formateada,
            'ultima_modificacion' => $this->actualizado_formateado,
            'dias_desde_registro' => $this->created_at->diffInDays(now()),
        ];
    }
    
    /**
     * Verificar si es una venta registrada con fecha retroactiva - ventas realizadas en tiempos diferentes
     */
    public function esRegistroRetroactivo(): bool
    {
        return $this->fecha->ne($this->created_at);
    }
    
    public function scopePorEstado($query, string $estado)
    {
        return $query->where('estado', $estado);
    }
    
    public function scopePendientes($query)
    {
        return $query->porEstado(self::ESTADO_PENDIENTE);
    }
    
    public function scopePagadas($query)
    {
        return $query->porEstado(self::ESTADO_PAGADO);
    }
    
    public function scopeEnviadas($query)
    {
        return $query->porEstado(self::ESTADO_ENVIADO);
    }
    
    public function scopeCanceladas($query)
    {
        return $query->porEstado(self::ESTADO_CANCELADO);
    }
    
    public function scopeFechaVenta($query, $fecha)
    {
        return $query->whereDate('fecha', $fecha);
    }
    
    public function scopeVentasMes($query, $mes, $anio = null)
    {
        $anio = $anio ?? now()->year;
        return $query->whereYear('fecha', $anio)
                     ->whereMonth('fecha', $mes);
    }
    
    public function scopeVentasHoy($query)
    {
        return $query->whereDate('fecha', today());
    }
    
    public function scopeVentasEstaSemana($query)
    {
        return $query->whereBetween('fecha', [now()->startOfWeek(), now()->endOfWeek()]);
    }
    
    public function scopeVentasEsteMes($query)
    {
        return $query->whereMonth('fecha', now()->month)
                     ->whereYear('fecha', now()->year);
    }
    
    /**
     * Scopes por fecha de registro (auditoría)
     */
    public function scopeRegistradasHoy($query)
    {
        return $query->whereDate('created_at', today());
    }
    
    public function scopeRegistradasEstaSemana($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }
    
    public function scopeRegistradasEsteMes($query)
    {
        return $query->whereMonth('created_at', now()->month)
                     ->whereYear('created_at', now()->year);
    }
    
    /**
     * Ventas retroactivas (fecha de venta diferente a fecha de registro)
     */
    public function scopeRetroactivas($query)
    {
        return $query->whereRaw('DATE(fecha) != DATE(created_at)');
    }
    
    public function scopeDeUsuario($query, $usuarioId)
    {
        return $query->where('usuario_id', $usuarioId);
    }
    
    public function scopeEntreFechas($query, $inicio, $fin)
    {
        return $query->whereBetween('fecha', [$inicio, $fin]);
    }
    
    public function scopeTotalMayorA($query, $monto)
    {
        return $query->where('total', '>', $monto);
    }
    
    public function scopeMasRecientes($query)
    {
        return $query->orderBy('fecha', 'desc');
    }
    
    public function scopeMasAntiguas($query)
    {
        return $query->orderBy('fecha', 'asc');
    }
    
    public function scopeMayorTotal($query)
    {
        return $query->orderBy('total', 'desc');
    }
}