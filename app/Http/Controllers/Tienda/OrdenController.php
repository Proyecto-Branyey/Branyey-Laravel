<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\DetallesOrden;
use App\Models\Variante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrdenController extends Controller
{
    /**
     * Muestra el formulario de Checkout.
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('tienda.catalogo')->with('error', 'Tu carrito está vacío. Agrega productos para finalizar la compra.');
        }

        $user = Auth::user();
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('tienda.checkout', compact('cart', 'user', 'total'));
    }

    /**
     * Procesa el pago, resta stock y crea la orden (Generación de Orden).
     */
    public function store(Request $request)
    {
        $cart = session()->get('cart');

        if (!$cart) {
            return redirect()->route('tienda.catalogo')->with('error', 'El carrito está vacío.');
        }

        // Validación de campos obligatorios para el envío
        $request->validate([
            'direccion' => 'required|string|max:255',
            'telefono'  => 'required|string|max:20',
            'ciudad'    => 'required|string|max:100',
        ]);

        // Iniciamos transacción para asegurar la integridad de los datos
        DB::beginTransaction();

        try {
            $user = Auth::user();
            $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
            $nombreCliente = $user->nombre_completo ?: ($user->username ?: $user->email);
            $emailCliente = $user->email ?: 'sin-correo@local.test';

            // 1. Crear la Cabecera de la Venta (Tabla: ventas)
            $venta = Venta::create([
                'usuario_id' => $user->id,
                'total'      => $total,
                'estado'     => 'pagado',
            ]);

            // 2. Crear los Datos de Envío (Tabla: detalles_orden)
            DetallesOrden::create([
                'venta_id'         => $venta->id,
                'nombre_cliente'   => $nombreCliente,
                'email_cliente'    => $emailCliente,
                'telefono_cliente' => $request->telefono,
                'direccion_envio'  => $request->direccion,
                'ciudad'           => $request->ciudad,
                'departamento'     => $request->departamento ?? 'Bogotá',
            ]);

            // 3. Procesar Productos y Restar Stock (HU-014)
            foreach ($cart as $id => $details) {
                // Bloqueamos la fila de la variante para evitar ventas simultáneas sin stock real
                $variante = Variante::lockForUpdate()->find($id);

                if (!$variante || $variante->stock < $details['quantity']) {
                    throw new \Exception("Stock insuficiente para: " . $details['name']);
                }

                // Restar del inventario físico
                $variante->decrement('stock', $details['quantity']);

                // Guardar el detalle de la venta (Tabla: detalle_ventas)
                DetalleVenta::create([
                    'venta_id'        => $venta->id,
                    'variante_id'     => $id,
                    'cantidad'        => $details['quantity'],
                    'precio_cobrado'  => $details['price'],
                ]);
            }

            DB::commit();
            
            // Limpiamos la sesión del carrito al finalizar con éxito
            session()->forget('cart'); 

            return redirect()->route('tienda.inicio')->with('success', '¡Orden #'.$venta->id.' generada con éxito! Pronto recibirás tus prendas Branyey.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al procesar la compra: ' . $e->getMessage());
        }
    }
}