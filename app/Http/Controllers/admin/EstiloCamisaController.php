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
        $estilos = EstiloCamisa::all();
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
    public function edit(EstiloCamisa $estilo)
    {
        return view('admin.estilos-camisa.edit', compact('estilo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EstiloCamisa $estilo)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:estilos_camisa,nombre,' . $estilo->id,
        ]);

        $estilo->update($request->only(['nombre']));

        return redirect()->route('admin.estilos-camisa.index')->with('success', 'Estilo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EstiloCamisa $estilo)
    {
        $estilo->delete();
        return redirect()->route('admin.estilos-camisa.index')->with('success', 'Estilo eliminado exitosamente.');
    }
}
