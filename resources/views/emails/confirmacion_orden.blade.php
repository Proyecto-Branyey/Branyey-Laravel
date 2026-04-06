<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pedido</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; color: #222; }
        .wrapper { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.08); }
        .header { background: #111; padding: 30px 40px; text-align: center; }
        .header h1 { color: #fff; margin: 0; font-size: 28px; letter-spacing: 2px; text-transform: uppercase; font-style: italic; }
        .header p { color: #aaa; margin: 6px 0 0; font-size: 13px; }
        .body { padding: 36px 40px; }
        .body h2 { font-size: 20px; margin-bottom: 6px; }
        .body p { font-size: 15px; line-height: 1.6; color: #555; }
        .order-box { background: #f9f9f9; border: 1px solid #eee; border-radius: 8px; padding: 20px 24px; margin: 24px 0; }
        .order-box .row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee; font-size: 14px; }
        .order-box .row:last-child { border-bottom: none; font-weight: bold; font-size: 16px; color: #111; }
        .badge { display: inline-block; background: #28a745; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .items-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 14px; }
        .items-table th { background: #111; color: #fff; padding: 10px 14px; text-align: left; }
        .items-table td { padding: 10px 14px; border-bottom: 1px solid #eee; }
        .items-table tr:last-child td { border-bottom: none; }
        .footer { background: #111; padding: 24px 40px; text-align: center; }
        .footer p { color: #888; font-size: 12px; margin: 0; }
        .footer a { color: #ffca2c; text-decoration: none; }
    </style>
</head>
<body>
<div class="wrapper">

    <div class="header">
        <h1>Branyey</h1>
        <p>Moda que te define</p>
    </div>

    <div class="body">
        <h2>¡Gracias por tu compra, {{ $venta->detallesOrden->nombre_cliente ?? $venta->usuario->nombre_completo }}! 🎉</h2>
        <p>Tu pedido ha sido confirmado y está siendo preparado con cuidado. Te avisaremos cuando sea enviado.</p>

        <div class="order-box">
            <div class="row">
                <span>N° de Pedido</span>
                <span><strong>#{{ $venta->id }}</strong></span>
            </div>
            <div class="row">
                <span>Estado</span>
                <span><span class="badge">Confirmado</span></span>
            </div>
            @if($venta->detallesOrden)
            <div class="row">
                <span>Dirección de Entrega</span>
                <span>{{ $venta->detallesOrden->direccion_envio }}, {{ $venta->detallesOrden->ciudad }}</span>
            </div>
            <div class="row">
                <span>Departamento</span>
                <span>{{ $venta->detallesOrden->departamento }}</span>
            </div>
            @endif
        </div>

        <h3 style="font-size:16px; margin-bottom:12px;">Productos que compraste</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cant.</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($venta->detallesVenta as $detalle)
                <tr>
                    <td>{{ $detalle->variante->producto->nombre_comercial ?? $detalle->variante->producto->nombre ?? 'Producto' }}
                        @if($detalle->variante->talla)
                            <br><small style="color:#888">Talla: {{ $detalle->variante->talla->nombre }}</small>
                        @endif
                    </td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>${{ number_format($detalle->precio_cobrado, 0, ',', '.') }}</td>
                    <td>${{ number_format($detalle->precio_cobrado * $detalle->cantidad, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="order-box">
            <div class="row">
                <span>TOTAL PAGADO</span>
                <span>${{ number_format($venta->total, 0, ',', '.') }} COP</span>
            </div>
        </div>

        <p style="margin-top:24px;">Si tienes alguna pregunta sobre tu pedido, puedes consultarnos directamente.</p>
    </div>

    <div class="footer">
        <p>Este correo fue enviado automáticamente por <strong style="color:#fff;">Branyey</strong>.<br>
        &copy; {{ date('Y') }} Branyey — Todos los derechos reservados.</p>
    </div>

</div>
</body>
</html>
