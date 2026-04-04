<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\ClasificacionTalla;
use App\Models\EstiloCamisa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class ProductoController extends Controller
{
    /**
     * LANDING PAGE (Inicio)
     * Muestra productos destacados y novedades para el Home de Branyey.
     */
    public function inicio()
    {
        try {
            // Obtenemos los 3 productos más recientes marcados como activos
            // Incluimos 'estilo' para tener acceso a los precios base desde el Home
            $destacados = Producto::activos()
                ->with(['imagenes', 'estilo'])
                ->latest()
                ->take(3)
                ->get();
        } catch (\Exception $e) {
            // Fallback en caso de error de base de datos
            $destacados = collect();
        }

        return view('tienda.inicio', compact('destacados'));
    }

    /**
     * CATÁLOGO COMPLETO
     * Maneja la paginación y el sistema de filtros por Estilo y Clasificación.
     */
    public function index(Request $request)
    {
        // Iniciamos la consulta base con Eager Loading para optimizar SQL (Problema N+1)
        $query = Producto::activos()->with(['imagenes', 'estilo', 'clasificacion']);

        // Filtro por Clasificación (Dama, Caballero, Niño, etc.)
        if ($request->filled('clasificacion_id')) {
            $query->where('clasificacion_id', $request->clasificacion_id);
        }

        // Filtro por Estilo (Oversize, Slim Fit, etc.)
        if ($request->filled('estilo_id')) {
            $query->where('estilo_id', $request->estilo_id);
        }

        // Paginación de 12 productos (estándar para grillas de 3 o 4 columnas)
        $productos = $query->latest()->paginate(12);

        // Datos necesarios para llenar los select de los filtros en la vista
        $clasificaciones = ClasificacionTalla::all();
        $estilos = EstiloCamisa::all();

        return view('tienda.catalogo', compact('productos', 'clasificaciones', 'estilos'));
    }

    /**
     * DETALLE DEL PRODUCTO (RF-05)
     * Procesa precios dinámicos según el ROL del usuario y prepara las variantes.
     */
    public function show($id)
    {
        // 1. Buscamos el producto activo con TODA su descendencia técnica
        $producto = Producto::activos()->with([
            'imagenes', 
            'estilo',
            'clasificacion',
            'variantes.talla',
            'variantes.colores'
        ])->findOrFail($id);

        /**
         * 2. LÓGICA RF-05: Determinamos el tipo de precio según el perfil (Breeze/Auth)
         * Se usa strtolower para evitar errores si el rol está como "Mayorista" o "mayorista"
         */
        $tipoPrecio = 'minorista';
        if (Auth::check() && Auth::user()->rol && strtolower(Auth::user()->rol->nombre) === 'mayorista') {
            $tipoPrecio = 'mayorista';
        }

        /**
         * 3. Mapeo de variantes:
         * Preparamos un array limpio para que el JavaScript en el detalle
         * gestione el stock y los precios al cambiar talla/color.
         */
        $variantesPreparadas = $producto->variantes->map(function ($variante) use ($tipoPrecio, $producto) {
            
            // El precio base viene del Estilo vinculado al Producto
            $precioBase = ($tipoPrecio === 'mayorista') 
                ? ($producto->estilo->precio_base_mayorista ?? 0)
                : ($producto->estilo->precio_base_minorista ?? 0);

            // Sumamos recargo de talla si el modelo Talla tiene esa lógica (Fase 1)
            $recargoTalla = (method_exists($variante->talla, 'getRecargo')) 
                ? $variante->talla->getRecargo($tipoPrecio) 
                : 0;

            $precioFinal = $precioBase + $recargoTalla;

            return [
                'id' => $variante->id,
                'sku' => $variante->sku,
                'stock' => $variante->stock,
                'talla' => $variante->talla->nombre ?? 'Única',
                'color' => $variante->colores->pluck('nombre')->implode(' + '),
                'precio_final' => $precioFinal,
                'precio_formateado' => '$' . number_format($precioFinal, 0, ',', '.')
            ];
        });

        return view('tienda.producto_detalle', compact('producto', 'variantesPreparadas', 'tipoPrecio'));
    }

    /**
     * BÚSQUEDA AJAX
     * Para el buscador predictivo en el Navbar (UX mejorada).
     */
    public function buscar(Request $request)
    {
        $term = $request->get('q');
        
        if (strlen($term) < 2) {
            return response()->json([]);
        }

        $productos = Producto::activos()
            ->where('nombre_comercial', 'LIKE', "%{$term}%")
            ->limit(5)
            ->get(['id', 'nombre_comercial']);

        return response()->json($productos);
    }
}