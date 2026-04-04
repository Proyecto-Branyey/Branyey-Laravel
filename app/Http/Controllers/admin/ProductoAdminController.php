<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    Producto, 
    Variante, 
    ImagenProducto, 
    EstiloCamisa, 
    ClasificacionTalla, 
    Talla, 
    Color
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Storage};

class ProductoAdminController extends Controller
{
    public function index() {
        $productos = Producto::with(['estilo', 'imagenes', 'clasificacion'])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.productos.index', compact('productos'));
    }

    public function create() {
        return view('admin.productos.create', [
            'estilos'         => EstiloCamisa::all(),
            'clasificaciones' => ClasificacionTalla::all(),
            'tallas'          => Talla::all(),
            'colores'         => Color::orderBy('nombre', 'asc')->get()
        ]);
    }

    public function store(Request $request) {

        $request->validate([
            'nombre_comercial' => 'required|string|max:255',
            'estilo_id'        => 'required|exists:estilos_camisa,id',
            'clasificacion_id' => 'required|exists:clasificacion_talla,id',
            'variantes'        => 'required|array|min:1',
            'variantes.*.talla_id' => 'required|exists:tallas,id',
            'variantes.*.color_id' => 'required|exists:colores,id',
            'variantes.*.stock'    => 'required|integer|min:0',
            'variantes.*.precio_base' => 'required|numeric|min:0',
            'variantes.*.foto'     => 'required|image|max:10240',
        ]);

        $uploadedPaths = [];

        try {
            DB::beginTransaction();

            // Crear producto
            $producto = Producto::create([
                'nombre_comercial' => $request->nombre_comercial,
                'estilo_id'        => $request->estilo_id,
                'clasificacion_id' => $request->clasificacion_id,
                'descripcion'      => $request->descripcion,
                'activo'           => true
            ]);

            foreach ($request->variantes as $index => $v) {

                $sku = "BRA-{$producto->id}-{$v['color_id']}-{$v['talla_id']}";

                // Crear variante
                $variante = Variante::create([
                    'producto_id' => $producto->id,
                    'talla_id'    => $v['talla_id'],
                    'sku'         => $sku,
                    'stock'       => $v['stock'],
                    'precio_base' => $v['precio_base'], // ✅ precio base agregado
                ]);

                // Relación variante-color
                $variante->colores()->attach($v['color_id']);

                // Guardar imagen
                if ($request->hasFile("variantes.$index.foto")) {
                    $path = $request->file("variantes.$index.foto")
                        ->store('productos', 'public');

                    $uploadedPaths[] = $path;

                    ImagenProducto::updateOrCreate(
                        [
                            'producto_id' => $producto->id,
                            'color_id'    => $v['color_id']
                        ],
                        [
                            'url'         => $path,
                            'es_principal'=> true
                        ]
                    );
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.productos.index')
                ->with('success', 'Producto guardado correctamente.');

        } catch (\Exception $e) {

            DB::rollback();

            // borrar imágenes si falla
            foreach ($uploadedPaths as $p) {
                Storage::disk('public')->delete($p);
            }

            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy($id) {

        $producto = Producto::with('imagenes')->findOrFail($id);

        // borrar imágenes físicas
        foreach ($producto->imagenes as $img) {
            Storage::disk('public')->delete($img->url);
        }

        $producto->delete();

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}