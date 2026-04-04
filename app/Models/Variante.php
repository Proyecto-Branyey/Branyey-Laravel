<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

class Variante extends Model
{
    protected $table = 'variantes';
    public $timestamps = true;
    protected $fillable = [
        'producto_id', 'talla_id', 'sku', 'stock', 'precio_base'
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

    // Precio formateado
    public function getPrecioFormateadoAttribute(): string {
        return '$' . number_format($this->precio_base, 2);
    }
}