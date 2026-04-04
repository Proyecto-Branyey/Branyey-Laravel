<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImagenProducto extends Model
{
    use SoftDeletes;

    protected $table = 'imagenes_producto';

    protected $fillable = [
        'producto_id',
        'color_id',
        'url',
        'es_principal'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'id');
    }
}