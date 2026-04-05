<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\User;

class VentaAdminController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('usuario')->latest()->paginate(15);
        return view('admin.ventas.index', compact('ventas'));
    }

    public function create()
    {
        $clientes = User::all();
        return view('admin.ventas.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $venta = Venta::create($request->all());
        return redirect()->route('admin.ventas.index')->with('success', 'Venta registrada correctamente.');
    }

    public function show(Venta $venta)
    {
        $venta->load('usuario');
        return view('admin.ventas.show', compact('venta'));
    }

    public function edit(Venta $venta)
    {
        $clientes = User::all();
        return view('admin.ventas.edit', compact('venta', 'clientes'));
    }

    public function update(Request $request, Venta $venta)
    {
        $venta->update($request->all());
        return redirect()->route('admin.ventas.index')->with('success', 'Venta actualizada correctamente.');
    }

    public function destroy(Venta $venta)
    {
        $venta->delete();
        return redirect()->route('admin.ventas.index')->with('success', 'Venta eliminada correctamente.');
    }

    public function cambiarEstado(Request $request, Venta $venta)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,pagado,enviado,cancelado',
        ]);
        $venta->estado = $request->estado;
        $venta->save();
        return redirect()->back()->with('success', 'Estado de la venta actualizado.');
    }
}
