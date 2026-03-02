<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClasificacionTalla extends Model
{
    protected $table = 'clasificacion_talla';
    public $timestamps = false;

    protected $fillable = ['nombre'];

    public function productos() {
        return $this->hasMany(Producto::class, 'clasificacion_id');
    }
}