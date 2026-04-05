<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    Producto, 
    Variante, 
    ImagenProducto, 
    EstiloCamisa, 
    Talla, 
    Color,
    ClasificacionTalla
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Storage};

class ProductoAdminController extends Controller
{
    public function index() {
        $productos = Producto::with(['estilo', 'imagenes', 'variantes'])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.productos.index', compact('productos'));
    }

    public function create() {
        return view('admin.productos.create', [
            'estilos' => EstiloCamisa::all(),
            'tallas' => Talla::with('clasificacion')->get(),
            'clasificaciones' => \App\Models\ClasificacionTalla::all(),
            'colores' => Color::orderBy('nombre', 'asc')->get()
        ]);
    }

    public function store(Request $request) {

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estilo_camisa_id' => 'required|exists:estilos_camisa,id',
            'clasificacion_talla_id' => 'required|exists:clasificacion_talla,id',
            'variantes' => 'required|array|min:1',
            'variantes.*.talla_id' => [
                'required',
                'exists:tallas,id',
                function ($attribute, $value, $fail) use ($request) {
                    $talla = Talla::find($value);
                    if ($talla && $talla->clasificacion_id != $request->clasificacion_talla_id) {
                        $fail('La talla seleccionada no pertenece a la clasificación elegida.');
                    }
                },
            ],
            'variantes.*.color_id' => 'required|exists:colores,id',
            'variantes.*.precio_minorista' => 'required|numeric|min:0',
            'variantes.*.precio_mayorista' => 'required|numeric|min:0',
            'variantes.*.stock' => 'required|integer|min:0',
            'variantes.*.foto' => 'required|image|max:10240',
        ]);

        $uploadedPaths = [];

        try {
            DB::beginTransaction();

            // Crear producto
            $producto = Producto::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'estilo_camisa_id' => $request->estilo_camisa_id,
                'clasificacion_talla_id' => $request->clasificacion_talla_id,
            ]);

            foreach ($request->variantes as $index => $v) {

                // Crear variante
                $variante = Variante::create([
                    'producto_id' => $producto->id,
                    'talla_id' => $v['talla_id'],
                    'precio_minorista' => $v['precio_minorista'],
                    'precio_mayorista' => $v['precio_mayorista'],
                    'stock' => $v['stock'],
                ]);

                // Relación variante-color
                $variante->colores()->attach($v['color_id']);

                // Guardar imagen
                if ($request->hasFile("variantes.$index.foto")) {
                    $path = $request->file("variantes.$index.foto")
                        ->store('productos', 'public');

                    $uploadedPaths[] = $path;

                    ImagenProducto::create([
                        'producto_id' => $producto->id,
                        'ruta' => $path,
                        'orden' => $index,
                    ]);
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

    public function show($id) {
        $producto = Producto::with(['estilo', 'imagenes', 'variantes.talla', 'variantes.colores'])
            ->findOrFail($id);

        return view('admin.productos.show', compact('producto'));
    }

    public function edit($id) {
        $producto = Producto::with(['estilo', 'imagenes', 'variantes.talla', 'variantes.colores'])
            ->findOrFail($id);

        return view('admin.productos.edit', [
            'producto' => $producto,
            'estilos' => EstiloCamisa::all(),
            'tallas' => Talla::with('clasificacion')->get(),
            'clasificaciones' => \App\Models\ClasificacionTalla::all(),
            'colores' => Color::orderBy('nombre', 'asc')->get()
        ]);
    }

    public function update(Request $request, $id) {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estilo_camisa_id' => 'required|exists:estilos_camisa,id',
            'clasificacion_talla_id' => 'required|exists:clasificacion_talla,id',
            'variantes' => 'required|array|min:1',
            'variantes.*.id' => 'nullable|exists:variantes,id', // Para variantes existentes
            'variantes.*.talla_id' => [
                'required',
                'exists:tallas,id',
                function ($attribute, $value, $fail) use ($request) {
                    $talla = Talla::find($value);
                    if ($talla && $talla->clasificacion_id != $request->clasificacion_talla_id) {
                        $fail('La talla seleccionada no pertenece a la clasificación elegida.');
                    }
                },
            ],
            'variantes.*.color_id' => 'required|exists:colores,id',
            'variantes.*.precio_minorista' => 'required|numeric|min:0',
            'variantes.*.precio_mayorista' => 'required|numeric|min:0',
            'variantes.*.stock' => 'required|integer|min:0',
            'variantes.*.foto' => 'nullable|image|max:10240', // Opcional en edición
        ]);

        $uploadedPaths = [];

        try {
            DB::beginTransaction();

            // Actualizar producto
            $producto->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'estilo_camisa_id' => $request->estilo_camisa_id,
                'clasificacion_talla_id' => $request->clasificacion_talla_id,
            ]);

            // Obtener IDs de variantes existentes para eliminar las que no están en el request
            $existingVariantIds = $producto->variantes->pluck('id')->toArray();
            $updatedVariantIds = [];

            foreach ($request->variantes as $index => $v) {
                if (isset($v['id']) && $v['id']) {
                    // Actualizar variante existente
                    $variante = Variante::find($v['id']);
                    $variante->update([
                        'talla_id' => $v['talla_id'],
                        'precio_minorista' => $v['precio_minorista'],
                        'precio_mayorista' => $v['precio_mayorista'],
                        'stock' => $v['stock'],
                    ]);

                    // Actualizar relación color
                    $variante->colores()->sync([$v['color_id']]);

                    // Actualizar imagen si se proporciona nueva
                    if ($request->hasFile("variantes.$index.foto")) {
                        // Eliminar imagen anterior
                        $imagenAnterior = ImagenProducto::where('producto_id', $producto->id)
                            ->where('orden', $index)
                            ->first();
                        if ($imagenAnterior) {
                            Storage::disk('public')->delete($imagenAnterior->ruta);
                            $imagenAnterior->delete();
                        }

                        // Guardar nueva imagen
                        $path = $request->file("variantes.$index.foto")
                            ->store('productos', 'public');
                        $uploadedPaths[] = $path;

                        ImagenProducto::create([
                            'producto_id' => $producto->id,
                            'ruta' => $path,
                            'orden' => $index,
                        ]);
                    }

                    $updatedVariantIds[] = $v['id'];
                } else {
                    // Crear nueva variante
                    $variante = Variante::create([
                        'producto_id' => $producto->id,
                        'talla_id' => $v['talla_id'],
                        'precio_minorista' => $v['precio_minorista'],
                        'precio_mayorista' => $v['precio_mayorista'],
                        'stock' => $v['stock'],
                    ]);

                    // Relación variante-color
                    $variante->colores()->attach($v['color_id']);

                    // Guardar imagen
                    if ($request->hasFile("variantes.$index.foto")) {
                        $path = $request->file("variantes.$index.foto")
                            ->store('productos', 'public');
                        $uploadedPaths[] = $path;

                        ImagenProducto::create([
                            'producto_id' => $producto->id,
                            'ruta' => $path,
                            'orden' => $index,
                        ]);
                    }

                    $updatedVariantIds[] = $variante->id;
                }
            }

            // Eliminar variantes que ya no existen
            $variantsToDelete = array_diff($existingVariantIds, $updatedVariantIds);
            foreach ($variantsToDelete as $variantId) {
                $variante = Variante::find($variantId);
                if ($variante) {
                    // Eliminar imágenes asociadas
                    $imagenes = ImagenProducto::where('producto_id', $producto->id)
                        ->where('orden', array_search($variantId, $existingVariantIds))
                        ->get();
                    foreach ($imagenes as $imagen) {
                        Storage::disk('public')->delete($imagen->ruta);
                        $imagen->delete();
                    }
                    $variante->delete();
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.productos.index')
                ->with('success', 'Producto actualizado correctamente.');

        } catch (\Exception $e) {
            DB::rollback();

            // Borrar imágenes si falla
            foreach ($uploadedPaths as $p) {
                Storage::disk('public')->delete($p);
            }

            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }
}