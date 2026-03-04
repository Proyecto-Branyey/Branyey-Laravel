<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'colores';
    protected $fillable = ['nombre', 'codigo_hex'];

    public function variantes() {
        return $this->belongsToMany(Variante::class, 'variante_color', 'color_id', 'variante_id')
                    ->withPivot('orden');
    }
}