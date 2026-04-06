<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Venta;

class PedidoController extends Controller
{
    /**
     * Mostrar la factura de una venta del usuario autenticado.
     */
    public function factura(Venta $venta)
    {
        $user = Auth::user();
        if ($venta->usuario_id !== $user->id) {
            abort(403, 'No tienes permiso para ver esta factura.');
        }
        $venta->load(['usuario', 'detallesVenta.variante.producto', 'detallesOrden']);
        $pdf = \PDF::loadView('admin.ventas.factura', compact('venta'));
        return $pdf->download('factura_venta_'.$venta->id.'.pdf');
    }
    /**
     * Display a listing of the authenticated user's orders.
     */
    public function index()
    {
        $user = Auth::user();
        $ventas = Venta::where('usuario_id', $user->id)
            ->orderByDesc('created_at')
            ->get();
        return view('tienda.pedidos', compact('ventas'));
    }
}
