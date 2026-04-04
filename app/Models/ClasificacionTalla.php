<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClasificacionTalla extends Model
{
    use HasFactory;

    /**
     * La tabla asociada al modelo.
     */
    protected $table = 'clasificacion_talla';

    /**
     * Los atributos que son asignables en masa.
     */
    protected $fillable = ['nombre'];

    /**
     * Desactivamos timestamps si tu tabla no tiene 
     * las columnas created_at y updated_at.
     */
    public $timestamps = false;

    // ==========================================
    // RELACIONES
    // ==========================================

    /**
     * Una clasificación tiene muchos productos asociados.
     */
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'clasificacion_id');
    }

    /**
     * Relación con las tallas específicas de esta clasificación 
     * (Ej: S, M, L pertenecen a 'Adultos')
     */
    public function tallas(): HasMany
    {
        return $this->hasMany(Talla::class, 'clasificacion_id');
    }
}