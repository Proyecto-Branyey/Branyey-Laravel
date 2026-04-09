<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

        $venta->loadMissing([
            'usuario',
            'detallesOrden',
        ]);

        $estadoAnterior = $venta->estado;

        $venta->estado = $estado;
        $venta->save();

        try {
            $cliente = $venta->usuario;
            $detallesOrden = $venta->detallesOrden;

            if ($cliente && !empty($cliente->email)) {
                $estadoMap = Venta::estadosDisponibles();
                $estadoNuevoLabel = $estadoMap[$estado] ?? ucfirst(str_replace('_', ' ', $estado));
                $estadoAnteriorLabel = $estadoMap[$estadoAnterior] ?? ucfirst(str_replace('_', ' ', (string) $estadoAnterior));

                $mensajes = [
                    Venta::ESTADO_PAGADO => 'Recibimos tu pago correctamente. Estamos preparando tu pedido.',
                    Venta::ESTADO_EN_PROCESO => 'Tu pedido ya esta en preparacion en nuestro equipo.',
                    Venta::ESTADO_ENVIADO => 'Tu pedido fue despachado y va en camino.',
                    Venta::ESTADO_ENTREGADO => 'Tu pedido figura como entregado. Gracias por comprar en Branyey.',
                    Venta::ESTADO_CANCELADO => 'Tu pedido fue cancelado. Si necesitas ayuda, contacta soporte.',
                ];

                $estadoColor = [
                    Venta::ESTADO_PAGADO => '#16a34a',
                    Venta::ESTADO_EN_PROCESO => '#f59e0b',
                    Venta::ESTADO_ENVIADO => '#2563eb',
                    Venta::ESTADO_ENTREGADO => '#0ea5e9',
                    Venta::ESTADO_CANCELADO => '#dc2626',
                ];

                $nombreCliente = e($cliente->nombre_completo ?: $cliente->username ?: 'Cliente');
                $ciudad = e($detallesOrden->ciudad ?? 'No registrada');
                $departamento = e($detallesOrden->departamento ?? 'No registrado');
                $direccion = e($detallesOrden->direccion_envio ?? 'No registrada');
                $color = $estadoColor[$estado] ?? '#111827';
                $mensajeEstado = $mensajes[$estado] ?? 'Tu pedido ha sido actualizado.';
                $pedidoId = (int) $venta->id;
                $totalFormateado = '$' . number_format((float) $venta->total, 0, ',', '.');

                $body = "
                    <div style='margin:0;padding:24px;background:#f5f7fb;font-family:Arial,Helvetica,sans-serif;'>
                        <div style='max-width:680px;margin:0 auto;background:#ffffff;border-radius:14px;overflow:hidden;border:1px solid #e8ecf2;'>
                            <div style='background:{$color};padding:22px 24px;color:#fff;'>
                                <div style='font-size:20px;font-weight:800;letter-spacing:.3px;'>Actualizacion de tu pedido</div>
                                <div style='opacity:.9;font-size:13px;margin-top:4px;'>Pedido #{$pedidoId}</div>
                            </div>
                            <div style='padding:24px;'>
                                <h2 style='margin:0 0 10px;color:#111827;font-size:22px;'>Hola {$nombreCliente}</h2>
                                <p style='margin:0 0 14px;color:#4b5563;'>{$mensajeEstado}</p>

                                <div style='margin:14px 0;border:1px solid #eee;border-radius:10px;overflow:hidden;'>
                                    <div style='display:flex;justify-content:space-between;padding:10px 14px;background:#f9fafb;color:#374151;'>
                                        <span>Estado anterior</span>
                                        <strong>{$estadoAnteriorLabel}</strong>
                                    </div>
                                    <div style='display:flex;justify-content:space-between;padding:10px 14px;background:#ffffff;color:#111827;border-top:1px solid #eee;'>
                                        <span>Estado actual</span>
                                        <strong style='color:{$color};'>{$estadoNuevoLabel}</strong>
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

                                <p style='margin:18px 0 0;color:#4b5563;'>Si tienes dudas, responde este correo o contacta a nuestro equipo de soporte.</p>
                            </div>
                        </div>
                    </div>
                ";

                Http::timeout(6)->post('http://localhost:8080/api/mail/send', [
                    'to' => $cliente->email,
                    'subject' => 'Actualizacion de pedido #' . $pedidoId . ' - ' . $estadoNuevoLabel,
                    'body' => $body,
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Error enviando correo de cambio de estado: ' . $e->getMessage(), [
                'venta_id' => $venta->id,
                'estado' => $estado,
            ]);
        }

        return back()->with('success', 'Estado de la venta actualizado correctamente.');
    }
}
