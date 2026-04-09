<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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

        try {
            if (!empty($user->email)) {
                $nombreCliente = e($user->nombre_completo ?: $user->username ?: 'Cliente');
                $pedidoId = (int) $venta->id;
                $totalFormateado = '$' . number_format((float) $venta->total, 0, ',', '.');
                $adjuntoBase64 = base64_encode($pdf->output());
                $nombreAdjunto = 'factura_pedido_' . $pedidoId . '.pdf';

                $body = "
                    <div style='margin:0;padding:24px;background:#f5f7fb;font-family:Arial,Helvetica,sans-serif;'>
                        <div style='max-width:680px;margin:0 auto;background:#ffffff;border-radius:14px;overflow:hidden;border:1px solid #e8ecf2;'>
                            <div style='background:#111827;padding:22px 24px;color:#fff;'>
                                <div style='font-size:20px;font-weight:800;letter-spacing:.3px;'>Factura de tu pedido</div>
                                <div style='opacity:.9;font-size:13px;margin-top:4px;'>Pedido #{$pedidoId}</div>
                            </div>
                            <div style='padding:24px;'>
                                <h2 style='margin:0 0 10px;color:#111827;font-size:22px;'>Hola {$nombreCliente}</h2>
                                <p style='margin:0 0 14px;color:#4b5563;'>Adjuntamos la factura de tu pedido para que la tengas disponible en tu correo.</p>

                                <div style='margin:14px 0;border:1px solid #eee;border-radius:10px;overflow:hidden;'>
                                    <div style='display:flex;justify-content:space-between;padding:10px 14px;background:#f9fafb;color:#374151;'>
                                        <span>Numero de pedido</span>
                                        <strong>#{$pedidoId}</strong>
                                    </div>
                                    <div style='display:flex;justify-content:space-between;padding:10px 14px;background:#ffffff;color:#111827;border-top:1px solid #eee;'>
                                        <span>Total</span>
                                        <strong>{$totalFormateado}</strong>
                                    </div>
                                </div>

                                <p style='margin:18px 0 0;color:#4b5563;'>Gracias por comprar en Branyey.</p>
                            </div>
                        </div>
                    </div>
                ";

                Http::timeout(20)->post('http://localhost:8080/api/mail/send-with-attachment', [
                    'to' => $user->email,
                    'subject' => 'Factura de pedido #' . $pedidoId . ' - Branyey',
                    'body' => $body,
                    'attachmentBase64' => $adjuntoBase64,
                    'attachmentName' => $nombreAdjunto,
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Error enviando factura por correo: ' . $e->getMessage(), [
                'venta_id' => $venta->id,
                'usuario_id' => $user->id,
            ]);
        }

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

        if ($venta->estado === Venta::ESTADO_ENVIADO) {
            $venta->estado = Venta::ESTADO_ENTREGADO;
            $venta->save();

            try {
                $venta->loadMissing(['detallesOrden']);

                $nombreCliente = e($user->nombre_completo ?: $user->username ?: 'Cliente');
                $pedidoId = (int) $venta->id;
                $totalFormateado = '$' . number_format((float) $venta->total, 0, ',', '.');
                $direccion = e($venta->detallesOrden->direccion_envio ?? ($user->direccion_defecto ?: 'No registrada'));
                $ciudad = e($venta->detallesOrden->ciudad ?? ($user->ciudad_defecto ?: 'No registrada'));
                $departamento = e($venta->detallesOrden->departamento ?? ($user->departamento_defecto ?: 'No registrado'));

                $body = "
                    <div style='margin:0;padding:24px;background:#f5f7fb;font-family:Arial,Helvetica,sans-serif;'>
                        <div style='max-width:680px;margin:0 auto;background:#ffffff;border-radius:14px;overflow:hidden;border:1px solid #e8ecf2;'>
                            <div style='background:#0ea5e9;padding:22px 24px;color:#fff;'>
                                <div style='font-size:20px;font-weight:800;letter-spacing:.3px;'>Pedido entregado</div>
                                <div style='opacity:.9;font-size:13px;margin-top:4px;'>Confirmacion de recepcion</div>
                            </div>
                            <div style='padding:24px;'>
                                <h2 style='margin:0 0 10px;color:#111827;font-size:22px;'>Gracias, {$nombreCliente}</h2>
                                <p style='margin:0 0 14px;color:#4b5563;'>Confirmaste la recepcion de tu pedido <strong>#{$pedidoId}</strong>. Nos alegra que ya lo tengas contigo.</p>

                                <div style='margin:14px 0;border:1px solid #eee;border-radius:10px;overflow:hidden;'>
                                    <div style='display:flex;justify-content:space-between;padding:10px 14px;background:#f9fafb;color:#374151;'>
                                        <span>Estado</span>
                                        <strong style='color:#0ea5e9;'>Entregado</strong>
                                    </div>
                                    <div style='display:flex;justify-content:space-between;padding:10px 14px;background:#ffffff;color:#111827;border-top:1px solid #eee;'>
                                        <span>Total pedido</span>
                                        <strong>{$totalFormateado}</strong>
                                    </div>
                                </div>

                                <h3 style='margin:20px 0 10px;color:#111827;font-size:16px;'>Direccion de entrega</h3>
                                <div style='border:1px solid #eee;border-radius:10px;padding:14px;background:#fcfcfd;'>
                                    <p style='margin:0 0 6px;color:#374151;'><strong>Direccion:</strong> {$direccion}</p>
                                    <p style='margin:0 0 6px;color:#374151;'><strong>Ciudad:</strong> {$ciudad}</p>
                                    <p style='margin:0;color:#374151;'><strong>Departamento:</strong> {$departamento}</p>
                                </div>

                                <p style='margin:18px 0 0;color:#4b5563;'>Gracias por comprar en Branyey.</p>
                            </div>
                        </div>
                    </div>
                ";

                Http::timeout(6)->post('http://localhost:8080/api/mail/send', [
                    'to' => $user->email,
                    'subject' => 'Pedido #' . $pedidoId . ' confirmado como entregado',
                    'body' => $body,
                ]);
            } catch (\Throwable $e) {
                Log::error('Error enviando correo al confirmar entrega por cliente: ' . $e->getMessage(), [
                    'venta_id' => $venta->id,
                    'usuario_id' => $user->id,
                ]);
            }
        }

        return redirect()->route('tienda.pedidos')->with('success', '¡Gracias por confirmar la recepción de tu pedido!');
    }
}