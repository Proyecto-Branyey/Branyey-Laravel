<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    // Se eliminó SoftDeletes para evitar errores de columna 'deleted_at' en SQLite
    
    protected $table = 'colores';

    protected $fillable = ['nombre', 'codigo_hex'];
    
    // Se eliminó la propiedad $dates que hacía referencia a deleted_at

    public function variantes() {
        return $this->belongsToMany(Variante::class, 'variante_color', 'color_id', 'variante_id')
                    ->withPivot('orden');
    }
}