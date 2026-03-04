<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use SoftDeletes;

    protected $table = 'colores';

    protected $fillable = ['nombre', 'codigo_hex'];
    
    protected $dates = ['deleted_at'];

    public function variantes() {
        return $this->belongsToMany(Variante::class, 'variante_color', 'color_id', 'variante_id')
                    ->withPivot('orden');
    }
}