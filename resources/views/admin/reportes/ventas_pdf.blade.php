<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas - Branyey</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { width: 100%; padding: 40px; }
        .header { text-align: center; margin-bottom: 40px; border-bottom: 3px solid #000; padding-bottom: 20px; }
        .header h1 { font-size: 24px; font-weight: bold; margin-bottom: 5px; }
        .header p { font-size: 12px; color: #666; }
        .stats { display: flex; justify-content: space-around; margin: 30px 0; }
        .stat-box { text-align: center; padding: 15px; border: 1px solid #ddd; border-radius: 5px; flex: 1; margin: 0 10px; }
        .stat-box h3 { font-size: 14px; color: #666; margin-bottom: 10px; }
        .stat-box .value { font-size: 24px; font-weight: bold; color: #000; }
        table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        table thead { background-color: #f5f5f5; }
        table th { padding: 12px; text-align: left; border: 1px solid #ddd; font-weight: bold; font-size: 12px; }
        table td { padding: 10px 12px; border: 1px solid #ddd; font-size: 11px; }
        table tr:nth-child(even) { background-color: #fafafa; }
        .footer { margin-top: 40px; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #ddd; padding-top: 20px; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Encabezado -->
        <div class="header">
            <h1>📊 REPORTE DE VENTAS</h1>
            <p>{{ $empresa }}</p>
            <p>Generado: {{ $fecha_reporte }}</p>
        </div>

        <!-- Estadísticas -->
        <div class="stats">
            <div class="stat-box">
                <h3>Total de Ventas</h3>
                <div class="value">{{ $cantidad }}</div>
            </div>
            <div class="stat-box">
                <h3>Ingreso Total</h3>
                <div class="value">${{ number_format($total_ingresos, 0, ',', '.') }} COP</div>
            </div>
            <div class="stat-box">
                <h3>Promedio por Venta</h3>
                <div class="value">${{ number_format($promedio_venta, 0, ',', '.') }} COP</div>
            </div>
        </div>

        <!-- Tabla de Ventas -->
        <h2 style="margin-top: 30px; font-size: 16px; font-weight: bold;">Detalle de Ventas</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ventas as $venta)
                    <tr>
                        <td><strong>#{{ $venta->id }}</strong></td>
                        <td>{{ $venta->usuario->name ?? 'N/A' }}</td>
                        <td>{{ $venta->usuario->email ?? 'N/A' }}</td>
                        <td><strong>${{ number_format($venta->total, 0, ',', '.') }} COP</strong></td>
                        <td>
                            @if($venta->estado === 'completada')
                                <strong style="color: green;">✓ Completada</strong>
                            @elseif($venta->estado === 'pendiente')
                                <strong style="color: orange;">⏱ Pendiente</strong>
                            @else
                                <strong style="color: red;">✗ Cancelada</strong>
                            @endif
                        </td>
                        <td>{{ $venta->fecha ? $venta->fecha->format('d/m/Y H:i') : 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #999;">No hay ventas registradas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pie de página -->
        <div class="footer">
            <p>Este es un documento oficial de BRANYEY - Urban Style</p>
            <p>Generado automáticamente por el sistema de administración</p>
        </div>
    </div>
</body>
</html>
