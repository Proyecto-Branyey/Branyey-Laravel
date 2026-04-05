<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagenProducto extends Model
{

    protected $table = 'imagenes_producto';

    protected $fillable = [
        'producto_id',
        'color_id',
        'url',
        'es_principal',
    ];

    protected $casts = [
        'es_principal' => 'boolean',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
}