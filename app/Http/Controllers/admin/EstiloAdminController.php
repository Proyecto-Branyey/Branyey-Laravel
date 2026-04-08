<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\EstiloCamisa;
use Illuminate\Http\Request;

class EstiloAdminController extends Controller
{
    public function index() {
        $estilos = EstiloCamisa::orderBy('id', 'desc')->get();
        return view('admin.estilos.index', compact('estilos'));
    }

    public function create() {
        return view('admin.estilos.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:estilos_camisa,nombre',
        ]);

        EstiloCamisa::create($request->only(['nombre']));

        return redirect()->route('admin.estilos.index')->with('success', 'Estilo creado correctamente.');
    }

    public function edit($id) {
        $estilo = EstiloCamisa::findOrFail($id);
        return view('admin.estilos.edit', compact('estilo'));
    }

    public function update(Request $request, $id) {
        $estilo = EstiloCamisa::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:estilos_camisa,nombre,' . $id,
        ]);

        $estilo->update($request->only(['nombre']));

        return redirect()->route('admin.estilos.index')->with('success', 'Estilo actualizado correctamente.');
    }

    public function destroy($id) {
        $estilo = EstiloCamisa::findOrFail($id);
        $estilo->delete();
        return redirect()->route('admin.estilos.index')->with('success', 'Estilo eliminado correctamente.');
    }
}