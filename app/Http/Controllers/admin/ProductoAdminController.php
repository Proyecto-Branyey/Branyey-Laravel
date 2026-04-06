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
    /**
     * Muestra productos inactivos (papelera).
     */
    public function papelera()
    {
        $productos = Producto::withTrashed()
            ->with([
                'estilo',
                'imagenes',
                'variantes' => function ($query) {
                    $query->withTrashed();
                },
            ])
            ->where(function ($query) {
                $query->where('activo', false)
                    ->orWhereNotNull('deleted_at');
            })
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.productos.papelera', compact('productos'));
    }
    /**
     * Reactiva un producto y sus variantes.
     */
    public function activar($id)
    {
        $producto = Producto::withTrashed()->findOrFail($id);

        if ($producto->trashed()) {
            $producto->restore();
        }

        $producto->activo = true;
        $producto->save();

        $variantes = Variante::withTrashed()->where('producto_id', $producto->id)->get();
        foreach ($variantes as $variante) {
            if ($variante->trashed()) {
                $variante->restore();
            }
            $variante->activo = true;
            $variante->save();
        }

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto y variantes activados correctamente.');
    }
    public function index() {
        $productos = Producto::with(['estilo', 'imagenes', 'variantes'])
            ->where('activo', true)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.productos.index', compact('productos'));
    }

    public function create() {
        return view('admin.productos.create', [
            'estilos' => EstiloCamisa::activos()->get(),
            'tallas' => Talla::with('clasificacion')->activos()->get(),
            'clasificaciones' => \App\Models\ClasificacionTalla::all(),
            'colores' => Color::activos()->orderBy('nombre', 'asc')->get()
        ]);
    }

    public function store(Request $request) {

        $request->validate([
            'nombre_comercial' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estilo_id' => 'required|exists:estilos_camisa,id',
            'clasificacion_id' => 'required|exists:clasificacion_talla,id',
            'variantes' => 'required|array|min:1',
            'variantes.*.talla_id' => [
                'required',
                'exists:tallas,id',
                function ($attribute, $value, $fail) use ($request) {
                    $talla = Talla::find($value);
                    if ($talla && $talla->clasificacion_id != $request->clasificacion_id) {
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
                'nombre_comercial' => $request->nombre_comercial,
                'descripcion' => $request->descripcion,
                'estilo_id' => $request->estilo_id,
                'clasificacion_id' => $request->clasificacion_id,
            ]);

            foreach ($request->variantes as $index => $v) {

                $sku = Variante::generarSku($producto->id, $v['talla_id'], $v['color_id']);

                // Crear variante
                $variante = Variante::create([
                    'producto_id' => $producto->id,
                    'talla_id' => $v['talla_id'],
                    'sku' => $sku,
                    'stock' => $v['stock'],
                    'precio_minorista' => $v['precio_minorista'],
                    'precio_mayorista' => $v['precio_mayorista'],
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
                        'color_id' => $v['color_id'],
                        'url' => $path,
                        'es_principal' => $index === 0,
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

        $imagenesPorColor = $producto->imagenes->keyBy('color_id');

        return view('admin.productos.edit', [
            'producto' => $producto,
            'imagenesPorColor' => $imagenesPorColor,
            'estilos' => EstiloCamisa::activos()->get(),
            'tallas' => Talla::with('clasificacion')->activos()->get(),
            'clasificaciones' => \App\Models\ClasificacionTalla::all(),
            'colores' => Color::activos()->orderBy('nombre', 'asc')->get()
        ]);
    }

    public function update(Request $request, $id) {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'nombre_comercial' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estilo_id' => 'required|exists:estilos_camisa,id',
            'clasificacion_id' => 'required|exists:clasificacion_talla,id',
            'variantes' => 'required|array|min:1',
            'variantes.*.id' => 'nullable|exists:variantes,id',
            'variantes.*.talla_id' => [
                'required',
                'exists:tallas,id',
                function ($attribute, $value, $fail) use ($request) {
                    $talla = Talla::find($value);
                    if ($talla && $talla->clasificacion_id != $request->clasificacion_id) {
                        $fail('La talla seleccionada no pertenece a la clasificación elegida.');
                    }
                },
            ],
            'variantes.*.color_id' => 'required|exists:colores,id',
            'variantes.*.precio_minorista' => 'required|numeric|min:0',
            'variantes.*.precio_mayorista' => 'required|numeric|min:0',
            'variantes.*.stock' => 'required|integer|min:0',
            'variantes.*.foto' => 'nullable|image|max:10240',
        ]);

        $uploadedPaths = [];

        try {
            DB::beginTransaction();

            // Actualizar producto
            $producto->update([
                'nombre_comercial' => $request->nombre_comercial,
                'descripcion' => $request->descripcion,
                'estilo_id' => $request->estilo_id,
                'clasificacion_id' => $request->clasificacion_id,
            ]);

            $existingVariantIds = $producto->variantes()->pluck('id')->toArray();
            $updatedVariantIds = [];

            foreach ($request->variantes as $index => $v) {
                if (isset($v['id']) && $v['id']) {
                    // Actualizar variante existente
                    $variante = Variante::find($v['id']);
                    $variante->update([
                        'talla_id' => $v['talla_id'],
                        'stock' => $v['stock'],
                        'precio_minorista' => $v['precio_minorista'],
                        'precio_mayorista' => $v['precio_mayorista'],
                    ]);

                    // Actualizar relación color
                    $variante->colores()->sync([$v['color_id']]);

                    // Actualizar imagen si se proporciona nueva
                    if ($request->hasFile("variantes.$index.foto")) {
                        $imagenAnterior = ImagenProducto::where('producto_id', $producto->id)
                            ->where('color_id', $v['color_id'])
                            ->first();
                        if ($imagenAnterior) {
                            Storage::disk('public')->delete($imagenAnterior->url);
                            $imagenAnterior->delete();
                        }

                        $path = $request->file("variantes.$index.foto")
                            ->store('productos', 'public');
                        $uploadedPaths[] = $path;

                        ImagenProducto::updateOrCreate(
                            ['producto_id' => $producto->id, 'color_id' => $v['color_id']],
                            ['url' => $path, 'es_principal' => $index === 0]
                        );
                    }

                    $updatedVariantIds[] = $v['id'];
                } else {
                    $sku = Variante::generarSku($producto->id, $v['talla_id'], $v['color_id']);

                    $variante = Variante::create([
                        'producto_id' => $producto->id,
                        'talla_id' => $v['talla_id'],
                        'sku' => $sku,
                        'stock' => $v['stock'],
                        'precio_minorista' => $v['precio_minorista'],
                        'precio_mayorista' => $v['precio_mayorista'],
                    ]);

                    $variante->colores()->attach($v['color_id']);

                    if ($request->hasFile("variantes.$index.foto")) {
                        $path = $request->file("variantes.$index.foto")
                            ->store('productos', 'public');
                        $uploadedPaths[] = $path;

                        ImagenProducto::create([
                            'producto_id' => $producto->id,
                            'color_id' => $v['color_id'],
                            'url' => $path,
                            'es_principal' => $index === 0,
                        ]);
                    }

                    $updatedVariantIds[] = $variante->id;
                }
            }

            // Enviar a papelera variantes removidas desde el formulario de edición
            $variantsToDelete = array_diff($existingVariantIds, $updatedVariantIds);
            $removedVariantsCount = count($variantsToDelete);
            foreach ($variantsToDelete as $variantId) {
                $variante = Variante::where('producto_id', $producto->id)->find($variantId);
                if ($variante) {
                    // En papelera lógica de variantes no se elimina la imagen para poder recuperarla intacta.
                    Variante::where('id', $variantId)->update(['activo' => false]);
                    Variante::where('id', $variantId)->delete();
                }
            }




            DB::commit();

            return redirect()
                ->route('admin.productos.index')
                ->with('success', 'Producto actualizado correctamente.' . ($removedVariantsCount > 0 ? ' Se enviaron ' . $removedVariantsCount . ' variante(s) a la papelera.' : ''));

        } catch (\Exception $e) {
            DB::rollback();

            foreach ($uploadedPaths as $p) {
                Storage::disk('public')->delete($p);
            }

            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Envía un producto a papelera junto con sus variantes.
     */
    public function destroy($id)
    {
        $producto = Producto::with('variantes')->findOrFail($id);

        foreach ($producto->variantes as $variante) {
            $variante->activo = false;
            $variante->save();
            $variante->delete();
        }

        $producto->activo = false;
        $producto->save();
        $producto->delete();

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto enviado a la papelera junto con sus variantes.');
    }
}