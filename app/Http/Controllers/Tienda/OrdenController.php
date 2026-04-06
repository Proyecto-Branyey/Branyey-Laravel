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
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('tienda.cart.index')->with('error', 'Tu carrito está vacío.');
        }

        // Calcular total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('tienda.checkout', compact('cart', 'total', 'user'));
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
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('tienda.cart.index')->with('error', 'Tu carrito está vacío.');
        }

        // Calcular total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Crear la venta
        $venta = Venta::create([
            'usuario_id' => $user->id,
            'total' => $total,
            'estado' => Venta::ESTADO_EN_PROCESO,
        ]);

        // Crear detalles de orden
        DetallesOrden::create([
            'venta_id' => $venta->id,
            'nombre_cliente' => $user->nombre_completo ?? $user->email,
            'email_cliente' => $user->email,
            'telefono_cliente' => $request->telefono,
            'direccion_envio' => $request->direccion,
            'ciudad' => 'Bogotá', // hardcoded in view
            'departamento' => $request->departamento,
        ]);

        // Crear detalles de venta (usando el ID de variante como clave del array)
        foreach ($cart as $variante_id => $item) {
            $venta->detallesVenta()->create([
                'variante_id' => $variante_id,
                'cantidad' => $item['quantity'],
                'precio_cobrado' => $item['price'],
            ]);
        }

        // Limpiar carrito
        session()->forget('cart');

        return redirect()->route('tienda.pedidos')->with('success', '¡Tu pedido ha sido creado exitosamente!');
    }
}