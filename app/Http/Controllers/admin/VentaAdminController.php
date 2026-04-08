<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VentaAdminController extends Controller
{
    public function index(Request $request)
    {
        $ventas = Venta::with(['usuario.rol'])
            ->filtros($request->all())
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.ventas.index', compact('ventas'));
    }

    public function show(Venta $venta)
    {
        $venta->load([
            'usuario.rol',
            'detallesOrden',
            'detallesVenta.variante.producto',
            'detallesVenta.variante.talla',
            'detallesVenta.variante.colores',
        ]);

        return view('admin.ventas.show', compact('venta'));
    }

    public function factura(Venta $venta)
    {
        $venta->load([
            'usuario.rol',
            'detallesOrden',
            'detallesVenta.variante.producto',
            'detallesVenta.variante.talla',
            'detallesVenta.variante.colores',
        ]);

        $pdf = \PDF::loadView('admin.ventas.factura', compact('venta'));

        if (request()->boolean('pdf')) {
            return $pdf->download('factura_venta_' . $venta->id . '.pdf');
        }

        return $pdf->stream('factura_venta_' . $venta->id . '.pdf');
    }

    public function cambiarEstado(Request $request, Venta $venta): RedirectResponse
    {
        $estado = $request->input('estado');

        if (!array_key_exists($estado, Venta::estadosDisponibles())) {
            return back()->with('error', 'Estado de venta no valido.');
        }

        $venta->estado = $estado;
        $venta->save();

        return back()->with('success', 'Estado de la venta actualizado correctamente.');
    }
}
