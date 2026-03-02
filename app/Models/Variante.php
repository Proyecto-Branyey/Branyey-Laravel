<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variante extends Model
{
    protected $table = 'variantes';
    public $timestamps = false;

    protected $fillable = ['producto_id', 'talla_id', 'sku', 'stock'];

    public function producto() {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function talla() {
        return $this->belongsTo(Talla::class, 'talla_id');
    }

    public function colores() {
        return $this->belongsToMany(Color::class, 'variante_color', 'variante_id', 'color_id')
                    ->withPivot('orden');
    }

    public function detallesVentas() {
        return $this->hasMany(DetalleVenta::class, 'variante_id');
    }
}