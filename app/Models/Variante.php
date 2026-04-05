<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

class Variante extends Model
{
    protected $table = 'variantes';
    public $timestamps = true;
    protected $fillable = [
        'producto_id', 'talla_id', 'precio_minorista', 'precio_mayorista', 'stock'
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

    // Precio formateado según rol
    public function getPrecioFormateadoAttribute(): string {
        $precio = $this->getPrecioActual();
        return formatPriceCOP($precio);
    }

    public function getPrecioActual(): float {
        // Lógica para determinar precio según usuario
        if (auth()->check() && auth()->user()->rol && strtolower(auth()->user()->rol->nombre) === 'mayorista') {
            return $this->precio_mayorista ?? 0;
        }
        return $this->precio_minorista ?? 0;
    }
}