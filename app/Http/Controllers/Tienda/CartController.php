<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use App\Models\DetalleVenta;
use App\Models\DetallesOrden;
use App\Models\Venta;
use App\Models\Variante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Muestra la vista del carrito con el total calculado.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('tienda.carrito.index', compact('cart', 'total'));
    }

    /**
     * Agregar producto al carrito con VALIDACIÓN DE STOCK (HU-014)
     */
    public function add(Request $request)
    {
        // 1. Buscamos la variante con sus relaciones
        $variante = Variante::with(['producto.estilo', 'producto.imagenes', 'talla'])->findOrFail($request->variante_id);

        // --- VALIDACIÓN DE STOCK CRÍTICO (HU-014) ---
        if ($variante->stock <= 0) {
            return redirect()->back()->with('error', 'Lo sentimos, esta talla se encuentra agotada actualmente.');
        }
        // --- FIN VALIDACIÓN ---

        $cart = session()->get('cart', []);
        $request->validate([
            'variante_id' => 'required|exists:variantes,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cantidad = (int) $request->input('quantity', 1);
        $precioFinal = $variante->getPrecioActual();

        $cantidadEnCarrito = isset($cart[$variante->id]) ? $cart[$variante->id]['quantity'] : 0;
        if ($cantidad + $cantidadEnCarrito > $variante->stock) {
            return redirect()->back()->with('error', 'Solo hay ' . $variante->stock . ' unidades disponibles para esta combinación.');
        }
        if(isset($cart[$variante->id])) {
            $cart[$variante->id]['quantity'] += $cantidad;
        } else {
            $cart[$variante->id] = [
                "name"     => $variante->producto?->nombre_comercial ?? 'Producto',
                "quantity" => $cantidad,
                "price"    => $precioFinal,
                "talla"    => $variante->talla?->nombre ?? 'Sin talla',
                "image"    => $variante->producto?->imagenes->first()?->url ?? 'default.jpg'
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('tienda.cart.index')->with('success', 'Producto añadido al carrito.');
    }

    /**
     * Elimina un producto del carrito.
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Producto eliminado.');
    }

    /**
     * Actualiza la cantidad verificando stock disponible.
     */
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        $variante = Variante::find($id);

        if (!$variante) {
            return redirect()->back()->with('error', 'La variante ya no existe.');
        }

        if(isset($cart[$id]) && $request->quantity > 0) {
            // Validamos stock antes de actualizar cantidad en el input
            if ($request->quantity > $variante->stock) {
                return redirect()->back()->with('error', 'Solo hay ' . $variante->stock . ' unidades disponibles.');
            }

            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Carrito actualizado.');
        }
        return redirect()->back()->with('error', 'Cantidad no válida.');
    }

    /**
     * Finaliza la compra y genera la venta con sus detalles.
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('tienda.cart.index')->with('error', 'Tu carrito está vacío.');
        }

        try {
            DB::beginTransaction();

            $total = 0;
            $detalles = [];

            foreach ($cart as $varianteId => $item) {
                $variante = Variante::lockForUpdate()->find($varianteId);

                if (!$variante || !$variante->activo) {
                    throw new \RuntimeException('Una de las variantes del carrito ya no está disponible.');
                }

                $cantidad = (int) ($item['quantity'] ?? 0);
                if ($cantidad <= 0) {
                    throw new \RuntimeException('Cantidad inválida en el carrito.');
                }

                if ($cantidad > $variante->stock) {
                    throw new \RuntimeException('Stock insuficiente para la variante ' . $variante->sku . '.');
                }

                $precio = (float) ($item['price'] ?? $variante->getPrecioActual());
                $subtotal = $precio * $cantidad;
                $total += $subtotal;

                $detalles[] = [
                    'variante_id' => $variante->id,
                    'cantidad' => $cantidad,
                    'precio_cobrado' => $precio,
                ];

                $variante->decrement('stock', $cantidad);
            }

            $venta = Venta::create([
                'usuario_id' => Auth::id(),
                'total' => $total,
                'estado' => Venta::ESTADO_PAGADO,
            ]);

            $usuario = Auth::user();

            DetallesOrden::create([
                'venta_id' => $venta->id,
                'nombre_cliente' => $usuario->nombre_completo ?: $usuario->username,
                'email_cliente' => $usuario->email,
                'telefono_cliente' => $usuario->telefono ?: 'No registrado',
                'direccion_envio' => $usuario->direccion_defecto ?: 'No registrada',
                'ciudad' => $usuario->ciudad_defecto ?: 'No registrada',
                'departamento' => $usuario->departamento_defecto ?: 'No registrado',
            ]);

            foreach ($detalles as $detalle) {
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'variante_id' => $detalle['variante_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_cobrado' => $detalle['precio_cobrado'],
                ]);
            }

            DB::commit();

            session()->forget('cart');

            return redirect()
                ->route('tienda.pedidos')
                ->with('success', 'Compra finalizada correctamente. Pedido #' . $venta->id . ' creado.');

        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()
                ->route('tienda.cart.index')
                ->with('error', $e->getMessage());
        }
    }
}