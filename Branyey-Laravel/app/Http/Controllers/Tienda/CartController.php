<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use App\Models\DetalleVenta;
use App\Models\DetallesOrden;
use App\Models\User;
use App\Models\Venta;
use App\Models\Variante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CartController extends Controller
{
    /**
     * Calcula el costo de envío según ciudad/departamento.
     */
    private function calculateShippingCost(?string $departamento, ?string $ciudad): int
    {
        $departamentoLimpio = strtolower(trim((string) $departamento));
        $ciudadLimpia = strtolower(trim((string) $ciudad));

        if ($ciudadLimpia === 'bogotá' || $ciudadLimpia === 'bogota') {
            return 0;
        }

        if (in_array($ciudadLimpia, ['soacha', 'chia', 'cota', 'funza', 'mosquera', 'facatativá', 'facatativa', 'zipaquirá', 'zipaquira'])) {
            return 7000;
        }

        if ($departamentoLimpio === 'cundinamarca') {
            return 12000;
        }

        return 18000;
    }

    /**
     * Recalcula y guarda el total del carrito en sesión
     */
    private function recalculateCartTotal()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach($cart as $item) {
            $total += ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
        }
        
        session()->put('cart_total', $total);
        return $total;
    }

    /**
     * Muestra la vista del carrito con el total calculado.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Recalcular total para asegurar consistencia
        $total = $this->recalculateCartTotal();

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
        
        // Recalcular y guardar el total en sesión
        $this->recalculateCartTotal();
        
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
            
            // Recalcular y guardar el total en sesión
            $this->recalculateCartTotal();
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
            
            // Recalcular y guardar el total en sesión
            $this->recalculateCartTotal();
            
            return redirect()->back()->with('success', 'Carrito actualizado.');
        }
        return redirect()->back()->with('error', 'Cantidad no válida.');
    }

    /**
     * Muestra la vista de checkout antes de confirmar la compra.
     */
    public function showCheckout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('tienda.cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $total = $this->recalculateCartTotal();

        $user = Auth::user();

        return view('tienda.checkout', compact('cart', 'total', 'user'));
    }

    /**
     * Finaliza la compra y genera la venta con sus detalles.
     */
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('tienda.cart.index')->with('error', 'Tu carrito está vacío.');
        }

        try {
            DB::beginTransaction();

            $subtotalCarrito = 0;
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
                $subtotalCarrito += $subtotal;

                $detalles[] = [
                    'variante_id' => $variante->id,
                    'cantidad' => $cantidad,
                    'precio_cobrado' => $precio,
                    'producto_nombre' => $item['name'] ?? ('Variante ' . $variante->id),
                    'talla' => $item['talla'] ?? $variante->talla_id,
                ];

                $variante->decrement('stock', $cantidad);
            }

            $usuario = Auth::user();
            $nombreEntrega = trim((string) ($request->input('nombre_completo') ?: $usuario->nombre_completo ?: $usuario->username));
            $telefonoEntrega = trim((string) ($request->input('telefono') ?: $usuario->telefono ?: 'No registrado'));
            $direccionEntrega = trim((string) ($request->input('direccion') ?: $usuario->direccion_defecto ?: 'No registrada'));
            $ciudadEntrega = trim((string) ($request->input('ciudad') ?: $usuario->ciudad_defecto ?: 'No registrada'));
            $departamentoEntrega = trim((string) ($request->input('departamento') ?: $usuario->departamento_defecto ?: 'No registrado'));

            $valorEnvio = $this->calculateShippingCost($departamentoEntrega, $ciudadEntrega);
            $total = $subtotalCarrito + $valorEnvio;

            $venta = Venta::create([
                'usuario_id' => Auth::id(),
                'total' => $total,
                'estado' => Venta::ESTADO_PAGADO,
            ]);

            DetallesOrden::create([
                'venta_id' => $venta->id,
                'nombre_cliente' => $nombreEntrega,
                'email_cliente' => $usuario->email,
                'telefono_cliente' => $telefonoEntrega,
                'direccion_envio' => $direccionEntrega,
                'ciudad' => $ciudadEntrega,
                'departamento' => $departamentoEntrega,
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

            // Enviar correo de confirmación de compra
            try {
                $usuario = Auth::user();
                $detalles_email_rows = "";
                $total_calc = 0;

                foreach ($detalles as $detalle) {
                    $nombre_producto = e($detalle['producto_nombre'] ?? 'Producto');
                    $talla = e((string) ($detalle['talla'] ?? 'N/A'));
                    $cantidad = (int) ($detalle['cantidad'] ?? 0);
                    $precio_unitario = (float) ($detalle['precio_cobrado'] ?? 0);
                    $subtotal = $detalle['precio_cobrado'] * $detalle['cantidad'];

                    $detalles_email_rows .= "
                        <tr>
                            <td style='padding:10px 12px;border-bottom:1px solid #eee;color:#222;'>{$nombre_producto}</td>
                            <td style='padding:10px 12px;border-bottom:1px solid #eee;color:#555;text-align:center;'>{$talla}</td>
                            <td style='padding:10px 12px;border-bottom:1px solid #eee;color:#555;text-align:center;'>{$cantidad}</td>
                            <td style='padding:10px 12px;border-bottom:1px solid #eee;color:#111;text-align:right;'>$" . number_format($precio_unitario, 0, ',', '.') . "</td>
                            <td style='padding:10px 12px;border-bottom:1px solid #eee;color:#111;text-align:right;font-weight:700;'>$" . number_format($subtotal, 0, ',', '.') . "</td>
                        </tr>
                    ";
                    $total_calc += $subtotal;
                }

                $nombre_cliente = e($usuario->nombre_completo ?: $usuario->username ?: 'Cliente');
                $telefono = e($telefonoEntrega ?: 'No registrado');
                $email_cliente = e($usuario->email ?: 'No registrado');
                $ciudad = e($ciudadEntrega ?: 'No especificada');
                $departamento = e($departamentoEntrega ?: 'No especificado');
                $direccion = e($direccionEntrega ?: 'No registrada');
                $pedido_id = (int) $venta->id;
                $subtotal_formatted = '$' . number_format($total_calc, 0, ',', '.');
                $envio_formatted = $valorEnvio === 0 ? 'GRATIS' : ('$' . number_format($valorEnvio, 0, ',', '.'));
                $total_formatted = '$' . number_format($total_calc + $valorEnvio, 0, ',', '.');

                // CORREO AL CLIENTE
                $correo_body = "
                    <div style='margin:0;padding:24px;background:#f5f7fb;font-family:Arial,Helvetica,sans-serif;'>
                        <div style='max-width:680px;margin:0 auto;background:#ffffff;border-radius:14px;overflow:hidden;border:1px solid #e8ecf2;'>
                            <div style='background:#111827;padding:22px 24px;color:#fff;'>
                                <div style='font-size:20px;font-weight:800;letter-spacing:.3px;'>Branyey</div>
                                <div style='opacity:.85;font-size:13px;margin-top:4px;'>Confirmacion de compra</div>
                            </div>
                            <div style='padding:24px;'>
                                <h2 style='margin:0 0 8px;color:#111827;font-size:22px;'>Gracias por tu compra</h2>
                                <p style='margin:0 0 18px;color:#4b5563;'>Tu pedido <strong>#{$pedido_id}</strong> fue registrado correctamente.</p>

                                <h3 style='margin:0 0 10px;color:#111827;font-size:16px;'>Detalle del pedido</h3>
                                <table style='width:100%;border-collapse:collapse;border:1px solid #eee;border-radius:8px;overflow:hidden;'>
                                    <thead>
                                        <tr style='background:#f9fafb;'>
                                            <th style='padding:10px 12px;text-align:left;color:#374151;font-size:12px;'>Producto</th>
                                            <th style='padding:10px 12px;text-align:center;color:#374151;font-size:12px;'>Talla</th>
                                            <th style='padding:10px 12px;text-align:center;color:#374151;font-size:12px;'>Cant.</th>
                                            <th style='padding:10px 12px;text-align:right;color:#374151;font-size:12px;'>Unitario</th>
                                            <th style='padding:10px 12px;text-align:right;color:#374151;font-size:12px;'>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {$detalles_email_rows}
                                    </tbody>
                                </table>

                                <div style='margin-top:14px;border:1px solid #fed7aa;border-radius:10px;overflow:hidden;'>
                                    <div style='display:flex;justify-content:space-between;padding:10px 14px;background:#fff7ed;color:#9a3412;'>
                                        <span>Subtotal productos</span>
                                        <strong>{$subtotal_formatted}</strong>
                                    </div>
                                    <div style='display:flex;justify-content:space-between;padding:10px 14px;background:#fffaf3;color:#9a3412;border-top:1px solid #fed7aa;'>
                                        <span>Envío</span>
                                        <strong>{$envio_formatted}</strong>
                                    </div>
                                    <div style='display:flex;justify-content:space-between;padding:10px 14px;background:#ffedd5;color:#7c2d12;border-top:1px solid #fed7aa;font-weight:800;'>
                                        <span>Total pagado</span>
                                        <strong>{$total_formatted}</strong>
                                    </div>
                                </div>

                                <h3 style='margin:22px 0 10px;color:#111827;font-size:16px;'>Informacion de entrega</h3>
                                <div style='border:1px solid #eee;border-radius:10px;padding:14px;background:#fcfcfd;'>
                                    <p style='margin:0 0 6px;color:#374151;'><strong>Nombre:</strong> {$nombre_cliente}</p>
                                    <p style='margin:0 0 6px;color:#374151;'><strong>Telefono:</strong> {$telefono}</p>
                                    <p style='margin:0 0 6px;color:#374151;'><strong>Direccion:</strong> {$direccion}</p>
                                    <p style='margin:0 0 6px;color:#374151;'><strong>Ciudad:</strong> {$ciudad}</p>
                                    <p style='margin:0;color:#374151;'><strong>Departamento:</strong> {$departamento}</p>
                                </div>

                                <p style='margin:18px 0 0;color:#4b5563;'>Te notificaremos cuando tu pedido cambie de estado.</p>
                            </div>
                        </div>
                    </div>
                ";

                Http::timeout(5)->post('http://localhost:8080/api/mail/send', [
                    'to' => $usuario->email,
                    'subject' => 'Confirmación de compra - Pedido #' . $venta->id,
                    'body' => $correo_body,
                ]);

                // CORREO A LOS ADMINISTRADORES
                $admins = User::whereHas('rol', function($query) {
                    $query->where('nombre', 'administrador');
                })->get();

                foreach ($admins as $admin) {
                    $correo_admin = "
                        <div style='margin:0;padding:24px;background:#f5f7fb;font-family:Arial,Helvetica,sans-serif;'>
                            <div style='max-width:700px;margin:0 auto;background:#ffffff;border-radius:14px;overflow:hidden;border:1px solid #e8ecf2;'>
                                <div style='background:#7f1d1d;padding:20px 24px;color:#fff;'>
                                    <div style='font-size:19px;font-weight:800;'>Alerta de nueva compra</div>
                                    <div style='font-size:13px;opacity:.9;'>Pedido #{$pedido_id}</div>
                                </div>
                                <div style='padding:22px 24px;'>
                                    <h3 style='margin:0 0 10px;color:#111827;font-size:16px;'>Datos del cliente</h3>
                                    <p style='margin:0 0 6px;color:#374151;'><strong>Nombre:</strong> {$nombre_cliente}</p>
                                    <p style='margin:0 0 6px;color:#374151;'><strong>Email:</strong> {$email_cliente}</p>
                                    <p style='margin:0 0 12px;color:#374151;'><strong>Telefono:</strong> {$telefono}</p>

                                    <h3 style='margin:14px 0 10px;color:#111827;font-size:16px;'>Direccion de envio</h3>
                                    <p style='margin:0 0 6px;color:#374151;'><strong>Direccion:</strong> {$direccion}</p>
                                    <p style='margin:0 0 6px;color:#374151;'><strong>Ciudad:</strong> {$ciudad}</p>
                                    <p style='margin:0 0 12px;color:#374151;'><strong>Departamento:</strong> {$departamento}</p>

                                    <h3 style='margin:14px 0 10px;color:#111827;font-size:16px;'>Detalle del pedido</h3>
                                    <table style='width:100%;border-collapse:collapse;border:1px solid #eee;'>
                                        <thead>
                                            <tr style='background:#f9fafb;'>
                                                <th style='padding:10px 12px;text-align:left;color:#374151;font-size:12px;'>Producto</th>
                                                <th style='padding:10px 12px;text-align:center;color:#374151;font-size:12px;'>Talla</th>
                                                <th style='padding:10px 12px;text-align:center;color:#374151;font-size:12px;'>Cant.</th>
                                                <th style='padding:10px 12px;text-align:right;color:#374151;font-size:12px;'>Unitario</th>
                                                <th style='padding:10px 12px;text-align:right;color:#374151;font-size:12px;'>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {$detalles_email_rows}
                                        </tbody>
                                    </table>

                                    <div style='margin-top:14px;border:1px solid #fecaca;border-radius:10px;overflow:hidden;'>
                                        <div style='display:flex;justify-content:space-between;padding:10px 14px;background:#fef2f2;color:#991b1b;'>
                                            <span>Subtotal productos</span>
                                            <strong>{$subtotal_formatted}</strong>
                                        </div>
                                        <div style='display:flex;justify-content:space-between;padding:10px 14px;background:#fff7f7;color:#991b1b;border-top:1px solid #fecaca;'>
                                            <span>Envío</span>
                                            <strong>{$envio_formatted}</strong>
                                        </div>
                                        <div style='display:flex;justify-content:space-between;padding:10px 14px;background:#fee2e2;color:#7f1d1d;border-top:1px solid #fecaca;font-weight:800;'>
                                            <span>Total | Estado</span>
                                            <strong>{$total_formatted} | PAGADO</strong>
                                        </div>
                                    </div>

                                    <div style='margin-top:16px;'>
                                        <a href='http://127.0.0.1:8000/admin/dashboard' style='display:inline-block;background:#111827;color:#fff;text-decoration:none;padding:10px 14px;border-radius:8px;font-weight:700;'>
                                            Ir al panel de administracion
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";

                    Http::timeout(5)->post('http://localhost:8080/api/mail/send', [
                        'to' => $admin->email,
                        'subject' => '[ALERTA] Nueva compra - Pedido #' . $venta->id,
                        'body' => $correo_admin,
                    ]);
                }

            } catch (\Exception $e) {
                // Log error pero continúa sin fallar
                \Log::error('Error enviando correos de compra: ' . $e->getMessage());
                \Log::error('Stack trace: ' . $e->getTraceAsString());
            }

            // Limpiar carrito y total de sesión
            session()->forget('cart');
            session()->forget('cart_total');

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

    /**
     * Cotización de envío AJAX
     */
    public function shippingQuote(Request $request)
    {
        $departamento = $request->input('departamento');
        $ciudad = $request->input('ciudad');
        $valor_envio = $this->calculateShippingCost($departamento, $ciudad);
        return response()->json([
            'success' => true,
            'valor_envio' => $valor_envio
        ]);
    }
}