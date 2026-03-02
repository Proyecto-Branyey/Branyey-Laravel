<?php
// app/Models/Producto.php (agrega este método)

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    // ... tus otros métodos y propiedades ...

    /**
     * Relación: Un producto tiene muchas imágenes por color.
     */
    public function imagenesPorColor(): HasMany
    {
        return $this->hasMany(ImagenProducto::class, 'id_producto');
    }

    /**
     * Obtener la imagen de un color específico.
     */
    public function getImagenPorColor(string $color): ?ImagenProducto
    {
        return $this->imagenesPorColor()
                    ->where('color', $color)
                    ->first();
    }

    /**
     * Obtener todos los colores disponibles con sus imágenes.
     */
    public function getColoresConImagenesAttribute()
    {
        return $this->imagenesPorColor->mapWithKeys(function ($imagen) {
            return [$imagen->color => $imagen->url];
        })->toArray();
    }
}