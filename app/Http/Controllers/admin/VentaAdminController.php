<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\User;

class VentaAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Venta::with('usuario');


        // Filtro por nombre o email de cliente
        if ($request->filled('cliente')) {
            $cliente = $request->cliente;
            $query->whereHas('usuario', function($q) use ($cliente) {
                $q->where('nombre_completo', 'like', "%$cliente%")
                  ->orWhere('name', 'like', "%$cliente%")
                  ->orWhere('email', 'like', "%$cliente%")
                  ->orWhere('telefono', 'like', "%$cliente%")
                  ;
            });
        }

        // Filtro por tipo de cliente (rol)
        if ($request->filled('tipo_cliente')) {
            $tipo = $request->tipo_cliente;
            $query->whereHas('usuario.rol', function($q) use ($tipo) {
                if ($tipo === 'mayorista') {
                    $q->where('nombre', 'like', '%mayorista%');
                } elseif ($tipo === 'minorista') {
                    $q->where('nombre', 'like', '%minorista%');
                } elseif ($tipo === 'admin') {
                    $q->where('nombre', 'like', '%admin%');
                }
            });
        } else {
            // Por defecto, ocultar ventas de administradores (admin, administrador, etc.)
            $query->whereHas('usuario.rol', function($q) {
                $q->whereRaw("LOWER(nombre) NOT LIKE '%admin%'")
                  ->whereRaw("LOWER(nombre) NOT LIKE '%administrador%'");
            });
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro por fechas
        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        // Filtro por total mínimo/máximo
        if ($request->filled('total_min')) {
            $query->where('total', '>=', $request->total_min);
        }
        if ($request->filled('total_max')) {
            $query->where('total', '<=', $request->total_max);
        }

        $ventas = $query->latest()->paginate(15)->appends($request->all());
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
