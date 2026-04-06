<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualización de tu Pedido</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; color: #222; }
        .wrapper { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.08); }
        .header { background: #111; padding: 30px 40px; text-align: center; }
        .header h1 { color: #fff; margin: 0; font-size: 28px; letter-spacing: 2px; text-transform: uppercase; font-style: italic; }
        .header p { color: #aaa; margin: 6px 0 0; font-size: 13px; }
        .body { padding: 36px 40px; }
        .body h2 { font-size: 20px; margin-bottom: 6px; }
        .body p { font-size: 15px; line-height: 1.6; color: #555; }
        .status-box { text-align: center; padding: 28px 20px; margin: 24px 0; border-radius: 10px; }
        .status-icon { font-size: 48px; margin-bottom: 12px; }
        .status-label { font-size: 22px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        .status-en_proceso { background: #fff8e1; border: 2px solid #ffc107; color: #856404; }
        .status-enviado { background: #e8f0fe; border: 2px solid #4285f4; color: #1a56db; }
        .status-entregado { background: #e6f4ea; border: 2px solid #34a853; color: #1e7e34; }
        .status-cancelado { background: #fce8e6; border: 2px solid #ea4335; color: #c5221f; }
        .order-box { background: #f9f9f9; border: 1px solid #eee; border-radius: 8px; padding: 20px 24px; margin: 20px 0; }
        .order-box .row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee; font-size: 14px; }
        .order-box .row:last-child { border-bottom: none; }
        .footer { background: #111; padding: 24px 40px; text-align: center; }
        .footer p { color: #888; font-size: 12px; margin: 0; }
    </style>
</head>
<body>
<div class="wrapper">

    <div class="header">
        <h1>Branyey</h1>
        <p>Moda que te define</p>
    </div>

    <div class="body">
        @php
            $iconos = [
                'en_proceso' => '⚙️',
                'enviado'    => '🚚',
                'entregado'  => '✅',
                'cancelado'  => '❌',
            ];
            $mensajes = [
                'en_proceso' => 'Estamos preparando tu pedido con cuidado.',
                'enviado'    => '¡Tu pedido ya está en camino! Pronto llegará a tu puerta.',
                'entregado'  => '¡Tu pedido fue entregado! Esperamos que lo disfrutes mucho.',
                'cancelado'  => 'Tu pedido fue cancelado. Si tienes preguntas, contáctanos.',
            ];
            $etiquetas = [
                'en_proceso' => 'En Proceso',
                'enviado'    => 'Enviado',
                'entregado'  => 'Entregado',
                'cancelado'  => 'Cancelado',
            ];
            $icono = $iconos[$venta->estado] ?? '📦';
            $mensaje = $mensajes[$venta->estado] ?? 'El estado de tu pedido fue actualizado.';
            $etiqueta = $etiquetas[$venta->estado] ?? $venta->estado;
        @endphp

        <h2>Actualización de tu pedido #{{ $venta->id }}</h2>
        <p>Hola, {{ $venta->detallesOrden->nombre_cliente ?? $venta->usuario->nombre_completo }}. Hay novedades sobre tu compra:</p>

        <div class="status-box status-{{ $venta->estado }}">
            <div class="status-icon">{{ $icono }}</div>
            <div class="status-label">{{ $etiqueta }}</div>
        </div>

        <p>{{ $mensaje }}</p>

        <div class="order-box">
            <div class="row">
                <span>N° de Pedido</span>
                <span><strong>#{{ $venta->id }}</strong></span>
            </div>
            <div class="row">
                <span>Total del Pedido</span>
                <span>${{ number_format($venta->total, 0, ',', '.') }} COP</span>
            </div>
            @if($venta->detallesOrden)
            <div class="row">
                <span>Dirección</span>
                <span>{{ $venta->detallesOrden->direccion_envio }}, {{ $venta->detallesOrden->ciudad }}</span>
            </div>
            @endif
        </div>

        <p style="margin-top: 24px; font-size: 14px; color: #888;">
            Gracias por confiar en Branyey. ❤️
        </p>
    </div>

    <div class="footer">
        <p>Este correo fue enviado automáticamente por <strong style="color:#fff;">Branyey</strong>.<br>
        &copy; {{ date('Y') }} Branyey — Todos los derechos reservados.</p>
    </div>

</div>
</body>
</html>
