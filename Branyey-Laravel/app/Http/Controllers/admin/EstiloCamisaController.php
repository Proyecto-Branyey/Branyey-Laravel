<?php

namespace App\Http\Controllers\Admin;

use App\Models\EstiloCamisa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EstiloCamisaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estilos = EstiloCamisa::activos()->get();
        return view('admin.estilos-camisa.index', compact('estilos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.estilos-camisa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:estilos_camisa,nombre',
        ]);

        EstiloCamisa::create($request->only(['nombre']));

        return redirect()->route('admin.estilos-camisa.index')->with('success', 'Estilo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $estilo = EstiloCamisa::with('productos')->findOrFail($id);
        return view('admin.estilos-camisa.show', compact('estilo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EstiloCamisa $estilos_camisa)
    {
        return view('admin.estilos-camisa.edit', ['estilos_camisa' => $estilos_camisa]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EstiloCamisa $estilos_camisa)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:estilos_camisa,nombre,' . $estilos_camisa->id,
        ]);

        $estilos_camisa->update($request->only(['nombre']));

        return redirect()->route('admin.estilos-camisa.index')->with('success', 'Estilo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EstiloCamisa $estilos_camisa)
    {
        $estilos_camisa->activo = false;
        $estilos_camisa->save();
        return redirect()->route('admin.estilos-camisa.index')->with('success', 'Estilo desactivado exitosamente.');
    }

    /**
     * Muestra estilos inactivos (papelera).
     */
    public function papelera()
    {
        $estilos = EstiloCamisa::where('activo', false)->get();
        return view('admin.estilos-camisa.papelera', compact('estilos'));
    }

    /**
     * Reactiva un estilo inactivo.
     */
    public function activar($id)
    {
        $estilo = EstiloCamisa::findOrFail($id);
        $estilo->activo = true;
        $estilo->save();
        return redirect()->route('admin.estilos-camisa.index')->with('success', 'Estilo reactivado correctamente.');
    }
}
