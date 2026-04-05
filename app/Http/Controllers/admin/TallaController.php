<?php

namespace App\Http\Controllers\Admin;

use App\Models\Talla;
use App\Models\ClasificacionTalla;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TallaController extends Controller
{
    /**
     * Muestra tallas inactivas (papelera).
     */
    public function papelera()
    {
        $tallas = Talla::with('clasificacion')->where('activo', false)->get();
        return view('admin.tallas.papelera', compact('tallas'));
    }

    /**
     * Reactiva una talla inactiva.
     */
    public function activar($id)
    {
        $talla = Talla::findOrFail($id);
        $talla->activo = true;
        $talla->save();
        return redirect()->route('admin.tallas.index')->with('success', 'Talla reactivada correctamente.');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tallas = Talla::with('clasificacion')->where('activo', true)->get();
        return view('admin.tallas.index', compact('tallas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clasificaciones = ClasificacionTalla::all();
        return view('admin.tallas.create', compact('clasificaciones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:10',
            'clasificacion_id' => 'required|exists:clasificacion_talla,id',
        ]);

        // Verificar si ya existe una talla con el mismo nombre en la misma clasificación
        $existingTalla = Talla::where('nombre', $request->nombre)
                              ->where('clasificacion_id', $request->clasificacion_id)
                              ->first();

        if ($existingTalla) {
            return redirect()->back()
                           ->withInput()
                           ->withErrors(['nombre' => 'Esta talla ya existe para la clasificación seleccionada.']);
        }

        Talla::create($request->only(['nombre', 'clasificacion_id']));

        return redirect()->route('admin.tallas.index')->with('success', 'Talla creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Talla $talla)
    {
        $clasificaciones = ClasificacionTalla::all();
        return view('admin.tallas.edit', compact('talla', 'clasificaciones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Talla $talla)
    {
        $request->validate([
            'nombre' => 'required|string|max:10',
            'clasificacion_id' => 'required|exists:clasificacion_talla,id',
        ]);

        // Verificar si ya existe otra talla con el mismo nombre en la misma clasificación
        $existingTalla = Talla::where('nombre', $request->nombre)
                              ->where('clasificacion_id', $request->clasificacion_id)
                              ->where('id', '!=', $talla->id)
                              ->first();

        if ($existingTalla) {
            return redirect()->back()
                           ->withInput()
                           ->withErrors(['nombre' => 'Esta talla ya existe para la clasificación seleccionada.']);
        }

        $talla->update($request->only(['nombre', 'clasificacion_id']));

        return redirect()->route('admin.tallas.index')->with('success', 'Talla actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Talla $talla)
    {
        $talla->activo = false;
        $talla->save();
        return redirect()->route('admin.tallas.index')->with('success', 'Talla desactivada exitosamente.');
    }
}
