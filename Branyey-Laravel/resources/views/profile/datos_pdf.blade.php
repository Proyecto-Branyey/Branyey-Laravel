<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Informe de Usuario - Branyey</title>
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
            font-size: 16pt;
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
        
        /* Secciones */
        .section {
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            background: #e8e8e8;
            padding: 4px 8px;
            margin-bottom: 12px;
        }
        
        /* Tabla de datos */
        .info-block {
            margin-bottom: 15px;
        }
        
        .info-row {
            display: flex;
            padding: 4px 0;
            border-bottom: 0.5px dotted #ccc;
        }
        
        .info-label {
            width: 160px;
            font-weight: 600;
        }
        
        .info-value {
            flex: 1;
        }
        
        /* Tabla de compras */
        .purchase-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }
        
        .purchase-table th {
            border: 1px solid #000;
            padding: 6px;
            background: #e8e8e8;
            font-weight: bold;
            text-align: center;
        }
        
        .purchase-table td {
            border: 1px solid #000;
            padding: 5px;
        }
        
        .purchase-table td:first-child,
        .purchase-table td:nth-child(2),
        .purchase-table td:nth-child(4),
        .purchase-table td:nth-child(5) {
            text-align: center;
        }
        
        /* Estado en texto plano */
        .estado-text {
            text-transform: capitalize;
            font-weight: normal;
        }
        
        /* Total general */
        .total-row {
            margin-top: 12px;
            padding-top: 8px;
            border-top: 1px solid #000;
            text-align: right;
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
        
        hr { margin: 15px 0; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    @php $ventas = $user->ventas; @endphp
    
    <div class="doc-id">
        Folio: USR-{{ str_pad($user->id, 8, '0', STR_PAD_LEFT) }} | Emisión: {{ now()->format('Y-m-d H:i') }}
    </div>

    <div class="header">
        <div class="title">BRANYEY</div>
        <div class="subtitle">INFORME DE USUARIO</div>
    </div>

    <div class="section">
        <div class="section-title">DATOS DEL TITULAR</div>
        <div class="info-block">
            <div class="info-row"><span class="info-label">Identificador de usuario:</span><span class="info-value">{{ $user->username ?? 'N/A' }}</span></div>
            <div class="info-row"><span class="info-label">Nombre legal:</span><span class="info-value">{{ $user->nombre_completo ?: 'No especificado' }}</span></div>
            <div class="info-row"><span class="info-label">Correo electrónico:</span><span class="info-value">{{ $user->email ?? 'N/A' }}</span></div>
            <div class="info-row"><span class="info-label">Línea de contacto:</span><span class="info-value">{{ $user->telefono ?: 'No especificado' }}</span></div>
            <div class="info-row"><span class="info-label">Fecha de registro:</span><span class="info-value">{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</span></div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">DOMICILIO DE ENVÍO</div>
        <div class="info-block">
            <div class="info-row"><span class="info-label">Dirección fiscal:</span><span class="info-value">{{ $user->direccion_defecto ?: 'No registrada' }}</span></div>
            <div class="info-row"><span class="info-label">Ubicación geográfica:</span><span class="info-value">{{ $user->ciudad_defecto ?: 'No registrada' }}, {{ $user->departamento_defecto ?: 'No registrado' }}</span></div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">MOVIMIENTOS COMERCIALES</div>
        @if($ventas->isEmpty())
            <p>El usuario no presenta transacciones registradas en el sistema.</p>
        @else
            <table class="purchase-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>N° Transacción</th>
                        <th>Fecha</th>
                        <th>Valor</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventas as $index => $venta)
                        <tr>
                            <td>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ str_pad($venta->id, 7, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $venta->created_at->format('d/m/Y') }}</td>
                            <td>${{ number_format($venta->total, 0, ',', '.') }}</td>
                            <td><span class="estado-text">{{ str_replace('_', ' ', $venta->estado) }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="total-row">
                <span>Total acumulado: ${{ number_format($ventas->sum('total'), 0, ',', '.') }} COP</span>
            </div>
            <div style="margin-top: 8px; font-size: 9pt;">
                Operaciones registradas: {{ $ventas->count() }}
            </div>
        @endif
    </div>

    <div class="footer">
        <p>Este documento es una representación fiel de los datos almacenados en el sistema Branyey.</p>
        <p>Para cualquier inconsistencia, comunicarse con soporte@branyey.com</p>
    </div>
</body>
</html>