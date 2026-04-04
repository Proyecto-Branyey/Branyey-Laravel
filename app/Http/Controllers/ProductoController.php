<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\ClasificacionTalla;
use App\Models\EstiloCamisa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    public function inicio()
    {
        $destacados = Producto::activos()
            ->with(['imagenes', 'estilo'])
            ->latest()
            ->take(3)
            ->get();

        return view('tienda.inicio', compact('destacados'));
    }

    public function index(Request $request)
    {
        $query = Producto::activos()->with(['imagenes', 'estilo', 'clasificacion']);

        if ($request->filled('clasificacion_id')) {
            $query->where('clasificacion_id', $request->clasificacion_id);
        }

        if ($request->filled('estilo_id')) {
            $query->where('estilo_id', $request->estilo_id);
        }

        $productos = $query->latest()->paginate(12);
        $clasificaciones = ClasificacionTalla::all();
        $estilos = EstiloCamisa::all();

        return view('tienda.catalogo', compact('productos', 'clasificaciones', 'estilos'));
    }

    public function show($id)
    {
        $producto = Producto::activos()->with([
            'imagenes', 
            'estilo', 
            'clasificacion', 
            'variantes.talla', 
            'variantes.colores'
        ])->findOrFail($id);

        $tipoPrecio = 'minorista';
        if (Auth::check() && Auth::user()->rol && strtolower(Auth::user()->rol->nombre) === 'mayorista') {
            $tipoPrecio = 'mayorista';
        }

        $variantesPreparadas = $producto->variantes->map(function($variante) use ($tipoPrecio, $producto) {
            $precioBase = $tipoPrecio === 'mayorista'
                ? ($producto->estilo->precio_base_mayorista ?? 0)
                : ($producto->estilo->precio_base_minorista ?? 0);

            $recargoTalla = method_exists($variante->talla, 'getRecargo')
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

    public function buscar(Request $request)
    {
        $term = $request->get('q');
        if (strlen($term) < 2) return response()->json([]);

        $productos = Producto::activos()
            ->where('nombre_comercial', 'LIKE', "%{$term}%")
            ->limit(5)
            ->get(['id', 'nombre_comercial']);

        return response()->json($productos);
    }
}