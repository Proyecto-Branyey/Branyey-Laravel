<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Venta;
use App\Models\DetallesOrden;

class OrdenController extends Controller
{
    /**
     * Mostrar el formulario de checkout.
     */
    public function checkout()
    {
        $user = Auth::user();
        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('tienda.cart.index')->with('error', 'Tu carrito está vacío.');
        }

        // Calcular total
        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        return view('tienda.checkout', compact('carrito', 'total', 'user'));
    }

    /**
     * Procesar la orden y crear la venta.
     */
    public function store(Request $request)
    {
        $request->validate([
            'telefono' => 'required|string|max:50',
            'direccion' => 'required|string',
            'departamento' => 'required|string|max:100',
        ]);

        $user = Auth::user();
        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('tienda.cart.index')->with('error', 'Tu carrito está vacío.');
        }

        // Calcular total
        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        // Crear la venta
        $venta = Venta::create([
            'usuario_id' => $user->id,
            'total' => $total,
            'estado' => Venta::ESTADO_PENDIENTE,
        ]);

        // Crear detalles de orden
        DetallesOrden::create([
            'venta_id' => $venta->id,
            'nombre_cliente' => $user->name,
            'email_cliente' => $user->email,
            'telefono_cliente' => $request->telefono,
            'direccion_envio' => $request->direccion,
            'ciudad' => 'Bogotá', // hardcoded in view
            'departamento' => $request->departamento,
        ]);

        // Crear detalles de venta
        foreach ($carrito as $item) {
            $venta->detallesVenta()->create([
                'variante_id' => $item['variante_id'],
                'cantidad' => $item['cantidad'],
                'precio_cobrado' => $item['precio'],
            ]);
        }

        // Limpiar carrito
        session()->forget('carrito');

        return redirect()->route('tienda.pedidos')->with('success', '¡Tu pedido ha sido creado exitosamente!');
    }
}