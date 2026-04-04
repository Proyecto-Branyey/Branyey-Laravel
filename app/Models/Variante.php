<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Variante extends Model
{
    use HasFactory;

    protected $table = 'variantes';
    
    // Desactivamos timestamps si tu tabla no tiene created_at/updated_at
    public $timestamps = false;

    protected $fillable = [
        'producto_id',
        'talla_id',
        'sku',
        'stock'
    ];

    protected $casts = [
        'stock' => 'integer',
        'producto_id' => 'integer',
        'talla_id' => 'integer',
    ];

    // ==========================================
    // RELACIONES
    // ==========================================

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    
    public function talla(): BelongsTo
    {
        return $this->belongsTo(Talla::class, 'talla_id');
    }
    
    public function colores(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'variante_color', 'variante_id', 'color_id')
                    ->withPivot('orden')
                    ->orderBy('orden');
    }

    public function detallesVentas(): HasMany
    {
        return $this->hasMany(DetalleVenta::class, 'variante_id');
    }

    // ==========================================
    // LÓGICA DE STOCK
    // ==========================================

    public function tieneStock(int $cantidad = 1): bool
    {
        return $this->stock >= $cantidad;
    }

    public function reducirStock(int $cantidad): bool
    {
        if (!$this->tieneStock($cantidad)) {
            return false;
        }
        
        $this->stock -= $cantidad;
        return $this->save();
    }

    public function aumentarStock(int $cantidad): bool
    {
        $this->stock += $cantidad;
        return $this->save();
    }

    // ==========================================
    // ACCESORES Y CÁLCULOS
    // ==========================================

    public function getNombreCompletoAttribute(): string
    {
        // Usamos optional para evitar errores si las relaciones no cargan
        $nombreProducto = $this->producto->nombre_comercial ?? 'Producto';
        $nombreTalla = $this->talla->nombre ?? 'N/A';
        $colores = $this->colores->pluck('nombre')->implode(' + ');
        
        return "{$nombreProducto} - Talla {$nombreTalla}" . ($colores ? " - {$colores}" : "");
    }

    public function getPrecioVenta(string $tipo = 'minorista'): float
    {
        // Obtenemos el precio del estilo a través del producto
        $precioBase = $this->producto && $this->producto->estilo 
            ? $this->producto->estilo->getPrecioBase($tipo) 
            : 0;

        // Sumamos recargos de talla si existen (puedes ajustar esta lógica según tu modelo Talla)
        $recargo = (method_exists($this->talla, 'getRecargo')) 
            ? $this->talla->getRecargo($tipo) 
            : 0;
        
        return $precioBase + $recargo;
    }

    // ==========================================
    // SCOPES (FILTROS)
    // ==========================================

    public function scopeConStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeSinStock($query)
    {
        return $query->where('stock', '<=', 0);
    }

    public function scopeStockBajo($query, int $minimo = 5)
    {
        return $query->where('stock', '>', 0)
                     ->where('stock', '<=', $minimo);
    }

    public function scopeSku($query, $sku)
    {
        return $query->where('sku', 'like', "%{$sku}%");
    }

    public function scopeDeProducto($query, $productoId)
    {
        return $query->where('producto_id', $productoId);
    }

    public function scopeDeTalla($query, $tallaId)
    {
        return $query->where('talla_id', $tallaId);
    }
}