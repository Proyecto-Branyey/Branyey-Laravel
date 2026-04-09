<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas - Branyey</title>
    <style>
        /* Reset */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Times New Roman', 'Georgia', serif;
            font-size: 11pt;
            margin: 2cm;
            color: #000;
            line-height: 1.3;
        }
        
        /* Tipografía seria */
        h1, h2, h3, .serif { font-family: 'Times New Roman', serif; }
        
        /* Header formal */
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .header .title {
            font-size: 18pt;
            font-weight: bold;
            letter-spacing: 4px;
            margin-bottom: 5px;
        }
        
        .header .subtitle {
            font-size: 10pt;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            display: inline-block;
            padding: 4px 20px;
            margin-top: 5px;
        }
        
        /* Identificación del documento */
        .doc-id {
            text-align: right;
            font-size: 9pt;
            margin-bottom: 25px;
            font-family: monospace;
        }
        
        /* Sección de filtros */
        .filters-section {
            background: #f8f8f8;
            padding: 10px 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }
        
        .filters-title {
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 8px;
        }
        
        .filters-content {
            font-size: 9pt;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .filter-item {
            display: inline-flex;
            gap: 5px;
        }
        
        .filter-label {
            font-weight: 600;
        }
        
        /* Tabla de ventas */
        .sales-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
            margin-top: 20px;
        }
        
        .sales-table th {
            border: 1px solid #000;
            padding: 8px 6px;
            background: #e8e8e8;
            font-weight: bold;
            text-align: center;
        }
        
        .sales-table td {
            border: 1px solid #000;
            padding: 6px;
        }
        
        .sales-table td:first-child,
        .sales-table td:nth-child(2),
        .sales-table td:nth-child(3),
        .sales-table td:nth-child(4),
        .sales-table td:nth-child(6) {
            text-align: center;
        }
        
        .sales-table td:nth-child(5) {
            text-align: right;
        }
        
        /* Resumen de ventas */
        .summary-section {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid #ccc;
        }
        
        .summary-title {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            background: #e8e8e8;
            padding: 4px 8px;
            margin-bottom: 12px;
        }
        
        .summary-grid {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .summary-card {
            flex: 1;
            border: 1px solid #ddd;
            padding: 12px;
            background: #f8f8f8;
        }
        
        .summary-card .label {
            font-size: 9pt;
            color: #666;
            margin-bottom: 5px;
        }
        
        .summary-card .value {
            font-size: 14pt;
            font-weight: bold;
        }
        
        /* Footer */
        .footer {
            margin-top: 35px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            font-size: 8pt;
            text-align: center;
        }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    @php
        $totalVentas = $ventas->sum('total');
        $totalRegistros = $ventas->count();
        $totalMayoristas = $ventas->filter(function($v) { 
            return $v->usuario && $v->usuario->rol && $v->usuario->rol->nombre === 'mayorista'; 
        })->count();
        $totalMinoristas = $ventas->filter(function($v) { 
            return $v->usuario && $v->usuario->rol && $v->usuario->rol->nombre === 'minorista'; 
        })->count();
        $promedioVenta = $totalRegistros > 0 ? $totalVentas / $totalRegistros : 0;
    @endphp
    
    <div class="doc-id">
        Folio: REP-{{ now()->format('YmdHis') }} | Emisión: {{ now()->format('Y-m-d H:i') }}
    </div>

    <div class="header">
        <div class="title">BRANYEY</div>
        <div class="subtitle">REPORTE DE VENTAS</div>
    </div>

    {{-- Filtros aplicados --}}
    @if(request('cliente') || request('tipo_cliente') || request('estado') || request('fecha_desde') || request('fecha_hasta'))
    <div class="filters-section">
        <div class="filters-title">Filtros aplicados al reporte</div>
        <div class="filters-content">
            @if(request('cliente'))
                <div class="filter-item"><span class="filter-label">Cliente:</span> {{ request('cliente') }}</div>
            @endif
            @if(request('tipo_cliente'))
                <div class="filter-item"><span class="filter-label">Tipo:</span> {{ ucfirst(request('tipo_cliente')) }}</div>
            @endif
            @if(request('estado'))
                <div class="filter-item"><span class="filter-label">Estado:</span> {{ ucfirst(str_replace('_', ' ', request('estado'))) }}</div>
            @endif
            @if(request('fecha_desde'))
                <div class="filter-item"><span class="filter-label">Desde:</span> {{ request('fecha_desde') }}</div>
            @endif
            @if(request('fecha_hasta'))
                <div class="filter-item"><span class="filter-label">Hasta:</span> {{ request('fecha_hasta') }}</div>
            @endif
        </div>
    </div>
    @endif

    {{-- Tabla de ventas --}}
    <table class="sales-table">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Cliente</th>
                <th style="width: 100px;">Tipo</th>
                <th style="width: 100px;">Fecha</th>
                <th style="width: 120px;">Total</th>
                <th style="width: 100px;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
                <tr>
                    <td class="text-center">{{ $venta->id }}</td>
                    <td>{{ $venta->usuario->nombre_completo ?? $venta->usuario->name ?? '-' }}</td>
                    <td class="text-center">{{ ucfirst($venta->usuario->rol->nombre ?? '-') }}</td>
                    <td class="text-center">{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-right">${{ number_format($venta->total, 0, ',', '.') }} COP</td>
                    <td class="text-center">{{ ucfirst(str_replace('_', ' ', $venta->estado)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Resumen estadístico --}}
    <div class="summary-section">
        <div class="summary-title">RESUMEN ESTADÍSTICO</div>
        <div class="summary-grid">
            <div class="summary-card">
                <div class="label">Total de ventas</div>
                <div class="value">{{ $totalRegistros }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Ventas mayoristas</div>
                <div class="value">{{ $totalMayoristas }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Ventas minoristas</div>
                <div class="value">{{ $totalMinoristas }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Monto total</div>
                <div class="value">${{ number_format($totalVentas, 0, ',', '.') }} COP</div>
            </div>
            <div class="summary-card">
                <div class="label">Promedio por venta</div>
                <div class="value">${{ number_format($promedioVenta, 0, ',', '.') }} COP</div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>Documento generado automáticamente desde el sistema Branyey.</p>
        <p>Para cualquier inconsistencia, comunicarse con soporte@branyey.com</p>
        <p style="margin-top: 8px;">Este documento es una representación fiel de las transacciones registradas.</p>
    </div>
</body>
</html>