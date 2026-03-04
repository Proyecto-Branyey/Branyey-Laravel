<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variante extends Model
{
    protected $table = 'variantes';
    
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

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
    
    public function talla()
    {
        return $this->belongsTo(Talla::class);
    }
    
    public function colores()
    {
        return $this->belongsToMany(Color::class, 'variante_color')
                    ->withPivot('orden')
                    ->orderBy('orden');
    }

    public function detallesVentas()
    {
        return $this->hasMany(DetalleVenta::class);
    }

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

    public function getNombreCompletoAttribute(): string
    {
        $colores = $this->colores->pluck('nombre')->implode(' + ');
        
        return "{$this->producto->nombre} - Talla {$this->talla->nombre} - {$colores}";
    }

    public function getPrecioVenta(string $tipo = 'minorista'): float
    {
        $precioBase = $this->producto->getPrecioBase($tipo);
        $recargo = $this->talla->getRecargo($tipo);
        
        return $precioBase + $recargo;
    }

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