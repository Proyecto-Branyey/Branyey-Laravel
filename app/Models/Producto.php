<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Producto extends Model
{
    protected $table = 'productos';
    public $timestamps = false;

    protected $fillable = [
        'nombre', 'descripcion', 'estilo_camisa_id', 'clasificacion_talla_id'
    ];

    public function estilo(): BelongsTo {
        return $this->belongsTo(EstiloCamisa::class, 'estilo_camisa_id');
    }

    public function clasificacionTalla(): BelongsTo {
        return $this->belongsTo(ClasificacionTalla::class, 'clasificacion_talla_id');
    }

    public function variantes(): HasMany {
        return $this->hasMany(Variante::class, 'producto_id');
    }

    public function imagenes(): HasMany {
        return $this->hasMany(ImagenProducto::class, 'producto_id');
    }
}