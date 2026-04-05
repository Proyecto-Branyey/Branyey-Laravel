<?php

namespace App\Http\Controllers\Admin;

use App\Models\Color;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colores = Color::all();
        return view('admin.colores.index', compact('colores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.colores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:colores,nombre',
            'codigo_hex' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
        ]);

        Color::create($request->only(['nombre', 'codigo_hex']));

        return redirect()->route('admin.colores.index')->with('success', 'Color creado exitosamente.');
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
    public function edit(Color $colore)
    {
        return view('admin.colores.edit', compact('colore'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Color $colore)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:colores,nombre,' . $colore->id,
            'codigo_hex' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
        ]);

        $colore->update($request->only(['nombre', 'codigo_hex']));

        return redirect()->route('admin.colores.index')->with('success', 'Color actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $colore)
    {
        $colore->delete();
        return redirect()->route('admin.colores.index')->with('success', 'Color eliminado exitosamente.');
    }
}
