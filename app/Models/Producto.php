<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    public $timestamps = false;

    protected $fillable = [
        'estilo_id', 'clasificacion_id', 'nombre_comercial', 'descripcion', 'activo'
    ];

    public function estilo() {
        return $this->belongsTo(EstiloCamisa::class, 'estilo_id');
    }

    public function clasificacion() {
        return $this->belongsTo(ClasificacionTalla::class, 'clasificacion_id');
    }

    public function variantes() {
        return $this->hasMany(Variante::class, 'producto_id');
    }
}