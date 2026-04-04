<?php
// app/Models/ImagenProducto.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ImagenProducto extends Model
{
    use HasFactory;

    /**
     * La tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'imagenes_producto';

    /**
     * La clave primaria asociada a la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_producto',
        'color',
        'url'
    ];

    /**
     * Los atributos que deben ser ocultados para arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id_producto' => 'integer',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    /**
     * Los accesores a agregar al array del modelo.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'url_completa',
        'nombre_archivo',
        'extension',
        'existe_en_storage'
    ];

    // ==========================================
    // RELACIONES
    // ==========================================

    /**
     * Obtener el producto al que pertenece esta imagen.
     *
     * @return BelongsTo
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id');
    }

    // ==========================================
    // SCOPES (CONSULTAS PERSONALIZADAS)
    // ==========================================

    /**
     * Scope para filtrar imágenes por producto.
     */
    public function scopePorProducto($query, int $productoId)
    {
        return $query->where('id_producto', $productoId);
    }

    /**
     * Scope para filtrar imágenes por color.
     */
    public function scopePorColor($query, string $color)
    {
        return $query->where('color', $color);
    }

    /**
     * Scope para buscar imágenes que existen físicamente.
     */
    public function scopeExistenEnStorage($query)
    {
        return $query;
    }

    // ==========================================
    // ACCESORES (GET)
    // ==========================================

    /**
     * Obtener la URL completa de la imagen.
     */
    public function getUrlCompletaAttribute(): string
    {
        if (filter_var($this->url, FILTER_VALIDATE_URL)) {
            return $this->url;
        }
        
        if (preg_match('/^[A-Z]:\\\\/', $this->url)) {
            return $this->url;
        }
        
        return asset($this->url);
    }

    /**
     * Obtener solo el nombre del archivo de la ruta.
     */
    public function getNombreArchivoAttribute(): string
    {
        return basename($this->url);
    }

    /**
     * Obtener la extensión del archivo.
     */
    public function getExtensionAttribute(): string
    {
        return pathinfo($this->url, PATHINFO_EXTENSION);
    }

    /**
     * Obtener el directorio donde se encuentra la imagen.
     */
    public function getDirectorioAttribute(): string
    {
        return dirname($this->url);
    }

    /**
     * Verificar si la imagen existe físicamente.
     */
    public function getExisteEnStorageAttribute(): bool
    {
        if (filter_var($this->url, FILTER_VALIDATE_URL)) {
            return true; 
        }
        
        if (preg_match('/^[A-Z]:\\\\/', $this->url)) {
            return file_exists($this->url);
        }
        
        $rutaStorage = str_replace('/storage/', '', $this->url);
        return Storage::disk('public')->exists($rutaStorage);
    }

    /**
     * Obtener el tamaño del archivo en bytes.
     */
    public function getTamañoAttribute(): ?int
    {
        if ($this->existe_en_storage && !filter_var($this->url, FILTER_VALIDATE_URL) && file_exists($this->url)) {
            return filesize($this->url);
        }
        return null;
    }

    /**
     * Obtener el tamaño formateado (KB, MB).
     */
    public function getTamañoFormateadoAttribute(): ?string
    {
        $bytes = $this->tamaño;
        if (!$bytes) return null;
        
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }

    // ==========================================
    // MUTADORES (SET)
    // ==========================================

    /**
     * Normalizar la URL al guardar.
     */
    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = str_replace('\\', '/', $value);
    }

    /**
     * Asegurar que el color tenga formato correcto.
     */
    public function setColorAttribute($value)
    {
        $this->attributes['color'] = ucfirst(trim($value));
    }

    // ==========================================
    // MÉTODOS PERSONALIZADOS
    // ==========================================

    public function copiarA(string $nuevaRuta): bool
    {
        if (!$this->existe_en_storage) return false;
        return copy($this->url, $nuevaRuta);
    }

    public function moverA(string $nuevaRuta): bool
    {
        if (!$this->existe_en_storage) return false;
        
        if (rename($this->url, $nuevaRuta)) {
            $this->update(['url' => $nuevaRuta]);
            return true;
        }
        return false;
    }

    public function eliminarArchivo(): bool
    {
        if (!$this->existe_en_storage) return false;
        return unlink($this->url);
    }

    public function toBase64(): ?string
    {
        if (!$this->existe_en_storage) return null;
        
        $contenido = file_get_contents($this->url);
        if (!$contenido) return null;
        
        return 'data:' . mime_content_type($this->url) . ';base64,' . base64_encode($contenido);
    }

    public function colorEsValido(): bool
    {
        if (!$this->producto) return false;
        
        return $this->producto->variantes()
            ->where('color', $this->color)
            ->exists();
    }

    // ==========================================
    // EVENTOS DEL MODELO
    // ==========================================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($imagen) {
            if (!Producto::find($imagen->id_producto)) {
                return false;
            }
        });
    }

    // ==========================================
    // MÉTODOS ESTÁTICOS DE AYUDA
    // ==========================================

    public static function sincronizar(int $productoId, array $imagenes): void
    {
        $coloresExistentes = self::where('id_producto', $productoId)
            ->pluck('color')
            ->toArray();
        
        $coloresNuevos = array_keys($imagenes);
        $coloresAEliminar = array_diff($coloresExistentes, $coloresNuevos);

        if (!empty($coloresAEliminar)) {
            self::where('id_producto', $productoId)
                ->whereIn('color', $coloresAEliminar)
                ->delete();
        }
        
        foreach ($imagenes as $color => $url) {
            self::updateOrCreate(
                ['id_producto' => $productoId, 'color' => $color],
                ['url' => $url]
            );
        }
    }

    public static function agrupadasPorProducto()
    {
        return self::with('producto')->get()->groupBy('id_producto');
    }
}