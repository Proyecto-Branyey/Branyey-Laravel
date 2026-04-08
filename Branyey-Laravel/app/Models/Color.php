<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Color extends Model
{
    // Nombre de la tabla en tu SQL
    protected $table = 'colores';

    // Campos asignables
    protected $fillable = ['nombre', 'codigo_hex', 'activo'];

    /**
     * Query scope to get only active colors.
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
    /**
     * Relación con Variantes.
     * Se eliminó ->withPivot('orden') para evitar el error SQLSTATE[42S22]
     */
    public function variantes(): BelongsToMany
    {
        return $this->belongsToMany(
            Variante::class, 
            'variante_color', 
            'color_id', 
            'variante_id'
        );
    }
}