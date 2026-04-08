<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

class Variante extends Model
{
    use SoftDeletes;

    // Scope para variantes activas
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
    protected $table = 'variantes';
    public $timestamps = true;
    protected $fillable = [
        'producto_id', 'talla_id', 'sku', 'stock', 'precio_minorista', 'precio_mayorista', 'activo'
    ];

    protected $casts = [
        'precio_minorista' => 'decimal:2',
        'precio_mayorista' => 'decimal:2',
        'stock' => 'integer',
        'activo' => 'boolean',
    ];

    public function producto(): BelongsTo {
        return $this->belongsTo(Producto::class, 'producto_id');
    }


    public function talla(): BelongsTo {
        return $this->belongsTo(Talla::class, 'talla_id');
    }

    // Relación solo con tallas activas
    public function tallaActiva(): BelongsTo {
        return $this->belongsTo(Talla::class, 'talla_id')->where('activo', true);
    }


    public function colores(): BelongsToMany {
        return $this->belongsToMany(Color::class, 'variante_color', 'variante_id', 'color_id');
    }

    // Relación solo con colores activos
    public function coloresActivos(): BelongsToMany {
        return $this->belongsToMany(Color::class, 'variante_color', 'variante_id', 'color_id')->where('activo', true);
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

    public static function generarSku(int $productoId, int $tallaId, int $colorId): string
    {
        $base = 'P' . str_pad($productoId, 4, '0', STR_PAD_LEFT)
              . 'T' . str_pad($tallaId, 2, '0', STR_PAD_LEFT)
              . 'C' . str_pad($colorId, 2, '0', STR_PAD_LEFT);

        $sku = $base;
        $counter = 1;
        while (static::withTrashed()->where('sku', $sku)->exists()) {
            $sku = $base . '-' . $counter;
            $counter++;
        }
        return $sku;
    }
}