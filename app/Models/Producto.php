<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Producto extends Model
{
    protected $table = 'productos';
    public $timestamps = false;

    protected $fillable = [
        'estilo_id', 'clasificacion_id', 'nombre_comercial', 'descripcion', 'activo'
    ];

    public function estilo(): BelongsTo {
        return $this->belongsTo(EstiloCamisa::class, 'estilo_id');
    }

    public function clasificacion(): BelongsTo {
        return $this->belongsTo(ClasificacionTalla::class, 'clasificacion_id');
    }

    public function variantes(): HasMany {
        return $this->hasMany(Variante::class, 'producto_id');
    }

    public function imagenes(): HasMany {
        return $this->hasMany(ImagenProducto::class, 'producto_id');
    }

    public function scopeActivos($query) {
        return $query->where('activo', true);
    }

    public function imagenPrincipalPorColor($colorId) {
        return $this->imagenes()->where('color_id', $colorId)->where('es_principal', 1)->first();
    }
}