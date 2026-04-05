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
        $destacados = Producto::with(['imagenes', 'estilo', 'variantes'])
            ->latest()
            ->take(3)
            ->get();

        return view('tienda.inicio', compact('destacados'));
    }

    public function index(Request $request)
    {
        $query = Producto::with(['imagenes', 'estilo', 'variantes']);

        if ($request->filled('estilo_id')) {
            $query->where('estilo_id', $request->estilo_id);
        }

        if ($request->filled('clasificacion_id')) {
            $query->where('clasificacion_id', $request->clasificacion_id);
        }

        $productos = $query->latest()->paginate(12);
        $estilos = EstiloCamisa::all();
        $clasificaciones = ClasificacionTalla::all();

        return view('tienda.catalogo', compact('productos', 'estilos', 'clasificaciones'));
    }

    public function show($id)
    {
        $producto = Producto::with([
            'imagenes', 
            'estilo', 
            'variantes.talla', 
            'variantes.colores'
        ])->findOrFail($id);

        return view('tienda.producto_detalle', compact('producto'));
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