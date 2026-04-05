<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Producto extends Model
{
    use SoftDeletes;

    protected $table = 'productos';

    protected $fillable = [
        'nombre_comercial', 'descripcion', 'estilo_id', 'clasificacion_id', 'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function estilo(): BelongsTo {
        return $this->belongsTo(EstiloCamisa::class, 'estilo_id');
    }

    public function clasificacionTalla(): BelongsTo {
        return $this->belongsTo(ClasificacionTalla::class, 'clasificacion_id');
    }


    public function variantes(): HasMany {
        return $this->hasMany(Variante::class, 'producto_id');
    }

    // Relación solo con variantes activas
    public function variantesActivas(): HasMany {
        return $this->hasMany(Variante::class, 'producto_id')->where('activo', true);
    }

    public function imagenes(): HasMany {
        return $this->hasMany(ImagenProducto::class, 'producto_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true)
            ->whereHas('estilo', function($q) { $q->where('activo', true); })
            ->whereHas('variantes', function($q) {
                $q->where('activo', true)
                  ->whereHas('talla', function($t) { $t->where('activo', true); })
                  ->whereHas('colores', function($c) { $c->where('activo', true); });
            });
    }
}