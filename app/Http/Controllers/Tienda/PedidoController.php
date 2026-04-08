<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Venta;

class PedidoController extends Controller
{
    /**
     * Display a listing of the authenticated user's orders.
     */
    public function index()
    {
        $user = Auth::user();
        $ventas = Venta::with(['detallesVenta.variante.producto.imagenes', 'detallesVenta.variante.talla', 'detallesOrden'])
            ->where('usuario_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(10);
        
        return view('tienda.pedidos', compact('ventas'));
    }

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
     * Marcar un pedido como recibido (cambiar estado a entregado)
     */
    public function recibido(Request $request, Venta $venta)
    {
        $user = Auth::user();
        if ($venta->usuario_id !== $user->id) {
            abort(403, 'No tienes permiso para modificar este pedido.');
        }
        if ($venta->estado === \App\Models\Venta::ESTADO_ENVIADO) {
            $venta->estado = \App\Models\Venta::ESTADO_ENTREGADO;
            $venta->save();
        }
        return redirect()->route('tienda.pedidos')->with('success', '¡Gracias por confirmar la recepción de tu pedido!');
    }
}