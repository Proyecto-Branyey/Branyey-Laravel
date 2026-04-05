<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

class Variante extends Model
{
    use SoftDeletes;

    protected $table = 'variantes';
    public $timestamps = true;
    protected $fillable = [
        'producto_id', 'talla_id', 'sku', 'stock', 'precio_minorista', 'precio_mayorista'
    ];

    protected $casts = [
        'precio_minorista' => 'decimal:2',
        'precio_mayorista' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function producto(): BelongsTo {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function talla(): BelongsTo {
        return $this->belongsTo(Talla::class, 'talla_id');
    }

    public function colores(): BelongsToMany {
        return $this->belongsToMany(Color::class, 'variante_color', 'variante_id', 'color_id');
    }

    public function getPrecioFormateadoAttribute(): string {
        $precio = $this->getPrecioActual();
        return '$' . number_format($precio, 0, ',', '.');
    }

    public function getPrecioActual(): float {
        if (auth()->check() && auth()->user()->rol && strtolower(auth()->user()->rol->nombre) === 'mayorista') {
            return $this->precio_mayorista ?? 0;
        }
        return $this->precio_minorista ?? 0;
    }
}