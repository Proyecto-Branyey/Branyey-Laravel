<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura de Venta #{{ $venta->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; }
        .header { margin-bottom: 20px; }
        .datos { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
        .total { font-weight: bold; font-size: 1.1em; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Factura de Venta #{{ $venta->id }}</h2>
        <div class="datos">
            <strong>Cliente:</strong> {{ $venta->usuario->nombre_completo ?? $venta->usuario->name ?? '-' }}<br>
            <strong>Email:</strong> {{ $venta->usuario->email ?? '-' }}<br>
            <strong>Teléfono:</strong> {{ $venta->usuario->telefono ?? '-' }}<br>
            <strong>Fecha:</strong> {{ $venta->created_at->format('Y-m-d H:i') }}<br>
            <strong>Estado:</strong> {{ $venta->estado_label }}<br>
            @if($venta->detallesOrden)
                <strong>Dirección de envío:</strong> {{ $venta->detallesOrden->direccion ?? '-' }}<br>
                <strong>Ciudad:</strong> {{ $venta->detallesOrden->ciudad ?? '-' }}<br>
            @endif
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->detallesVenta as $detalle)
                <tr>
                    <td>{{ $detalle->variante && $detalle->variante->producto ? $detalle->variante->producto->nombre_comercial ?? $detalle->variante->producto->nombre ?? '-' : '-' }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>${{ number_format($detalle->precio_cobrado, 0, ',', '.') }}</td>
                    <td>${{ number_format($detalle->cantidad * $detalle->precio_cobrado, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">TOTAL</td>
                <td class="total">${{ number_format($venta->total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
