<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talla extends Model
{
    protected $table = 'tallas';
    public $timestamps = false;

    protected $fillable = ['nombre', 'recargo_minorista', 'recargo_mayorista'];

    public function variantes() {
        return $this->hasMany(Variante::class, 'talla_id');
    }
}