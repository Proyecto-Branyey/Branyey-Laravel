<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClasificacionTalla extends Model
{
    use SoftDeletes;

    protected $table = 'clasificacion_talla';

    protected $fillable = ['nombre'];
    
    protected $dates = ['deleted_at'];

    public function productos() {
        return $this->hasMany(Producto::class, 'clasificacion_id');
    }
}