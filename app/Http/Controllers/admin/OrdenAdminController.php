<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\User;

class OrdenAdminController extends Controller
{
    public function index()
    {
        $ordenes = Orden::with('cliente')->latest()->paginate(15);
        return view('admin.ordenes.index', compact('ordenes'));
    }

    public function create()
    {
        $clientes = User::all();
        return view('admin.ordenes.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $orden = Orden::create($request->all());
        return redirect()->route('admin.ordenes.index')->with('success', 'Orden registrada correctamente.');
    }

    public function show(Orden $orden)
    {
        $orden->load('cliente');
        return view('admin.ordenes.show', compact('orden'));
    }

    public function edit(Orden $orden)
    {
        $clientes = User::all();
        return view('admin.ordenes.edit', compact('orden', 'clientes'));
    }

    public function update(Request $request, Orden $orden)
    {
        $orden->update($request->all());
        return redirect()->route('admin.ordenes.index')->with('success', 'Orden actualizada correctamente.');
    }

    public function destroy(Orden $orden)
    {
        $orden->delete();
        return redirect()->route('admin.ordenes.index')->with('success', 'Orden eliminada correctamente.');
    }
}
