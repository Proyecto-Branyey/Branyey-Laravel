<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstiloCamisa extends Model
{
    protected $table = 'estilos_camisa';
    public $timestamps = false;

    protected $fillable = ['nombre', 'precio_base_minorista', 'precio_base_mayorista'];

    public function productos() {
        return $this->hasMany(Producto::class, 'estilo_id');
    }
}