<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Productos - Branyey</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 10pt;
            margin: 2cm;
            color: #1a1a2e;
            line-height: 1.4;
        }
        
        /* ===== HEADER ===== */
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #667eea;
        }
        
        .logo {
            font-size: 22pt;
            font-weight: 900;
            letter-spacing: 3px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .title {
            font-size: 14pt;
            font-weight: 700;
            margin-top: 8px;
        }
        
        .subtitle {
            font-size: 9pt;
            color: #6c757d;
            margin-top: 4px;
        }
        
        /* ===== FILTROS ===== */
        .filters-info {
            background: #f8f9fa;
            padding: 10px 15px;
            border-radius: 10px;
            font-size: 8pt;
            margin-bottom: 25px;
            border-left: 4px solid #667eea;
        }
        
        /* ===== TARJETA DE PRODUCTO ===== */
        .product-card {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 16px;
            margin-bottom: 20px;
            overflow: hidden;
            page-break-inside: avoid;
        }
        
        .product-header {
            background: linear-gradient(135deg, #f8f9fa, #f0f2f5);
            padding: 12px 20px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .product-title-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .product-image-small {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 10px;
            background: #f8f9fa;
        }
        
        .product-image-placeholder-small {
            width: 50px;
            height: 50px;
            background: #f8f9fa;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #adb5bd;
        }
        
        .product-name {
            font-size: 12pt;
            font-weight: 800;
            color: #1a1a2e;
        }
        
        .product-id {
            font-size: 8pt;
            color: #6c757d;
        }
        
        .product-badges {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .style-badge {
            display: inline-block;
            padding: 4px 12px;
            background: rgba(102, 126, 234, 0.12);
            color: #667eea;
            border-radius: 20px;
            font-size: 8pt;
            font-weight: 600;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 8pt;
            font-weight: 600;
        }
        
        .status-active {
            background: rgba(16, 185, 129, 0.12);
            color: #10b981;
        }
        
        .status-inactive {
            background: rgba(108, 117, 125, 0.12);
            color: #6c757d;
        }
        
        /* ===== CUERPO DEL PRODUCTO ===== */
        .product-body {
            padding: 16px 20px;
        }
        
        .description-section {
            background: #fafbfc;
            padding: 12px 15px;
            border-radius: 12px;
            margin-bottom: 16px;
        }
        
        .description-title {
            font-size: 8pt;
            font-weight: 700;
            text-transform: uppercase;
            color: #6c757d;
            margin-bottom: 6px;
        }
        
        .description-text {
            font-size: 9pt;
            color: #495057;
            line-height: 1.5;
        }
        
        /* ===== TABLA DE VARIANTES ===== */
        .variants-title {
            font-size: 9pt;
            font-weight: 700;
            margin-bottom: 10px;
            color: #1a1a2e;
        }
        
        .variants-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
        }
        
        .variants-table th {
            background: #e9ecef;
            padding: 8px 10px;
            text-align: center;
            font-weight: 700;
            color: #495057;
        }
        
        .variants-table td {
            padding: 8px 10px;
            text-align: center;
            border-bottom: 1px solid #e9ecef;
        }
        
        .color-circle {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 4px;
            vertical-align: middle;
        }
        
        /* ===== FOOTER ===== */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e9ecef;
            font-size: 8pt;
            text-align: center;
            color: #adb5bd;
        }
        
        .summary {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 9pt;
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: 700; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">BRANYEY</div>
        <div class="title">Reporte de Inventario</div>
        <div class="subtitle">Generado el {{ now()->format('d/m/Y H:i:s') }}</div>
    </div>

    {{-- Filtros aplicados --}}
    @if(request('search') || request('estilo_id') || request('estado'))
    <div class="filters-info">
        <strong>Filtros aplicados:</strong>
        @if(request('search')) [Busqueda] "{{ request('search') }}" @endif
        @if(request('estilo_id') && isset($estilos))
            @php $estiloNombre = $estilos->firstWhere('id', request('estilo_id'))?->nombre; @endphp
            [Estilo] {{ $estiloNombre ?? request('estilo_id') }}
        @endif
        @if(request('estado')) [Estado] {{ ucfirst(request('estado')) }} @endif
    </div>
    @endif

    {{-- Resumen --}}
    <div class="summary">
        <span>Total de productos: <strong>{{ $productos->count() }}</strong></span>
        <span>Total de variantes: <strong>{{ $productos->sum(fn($p) => $p->variantes->count()) }}</strong></span>
    </div>

    {{-- Tarjetas de productos --}}
    @forelse($productos as $producto)
    <div class="product-card">
        {{-- Cabecera del producto --}}
        <div class="product-header">
            <div class="product-title-section">
                @php 
                    $img = $producto->imagenes->where('es_principal', true)->first() ?? $producto->imagenes->first();
                @endphp
                @if($img)
                    <img src="{{ public_path('storage/' . $img->url) }}" class="product-image-small" alt="{{ $producto->nombre_comercial }}">
                @else
                    <div class="product-image-placeholder-small">
                        <span>[IMG]</span>
                    </div>
                @endif
                <div>
                    <div class="product-name">{{ $producto->nombre_comercial }}</div>
                    <div class="product-id">ID: #{{ $producto->id }}</div>
                </div>
            </div>
            <div class="product-badges">
                <span class="style-badge">{{ $producto->estilo?->nombre ?? 'Sin estilo' }}</span>
                <span class="status-badge {{ $producto->activo ? 'status-active' : 'status-inactive' }}">
                    {{ $producto->activo ? 'Activo' : 'Inactivo' }}
                </span>
            </div>
        </div>

        {{-- Cuerpo del producto --}}
        <div class="product-body">
            {{-- Descripción --}}
            @if($producto->descripcion)
            <div class="description-section">
                <div class="description-title">
                    Descripcion
                </div>
                <div class="description-text">
                    {{ $producto->descripcion }}
                </div>
            </div>
            @endif

            {{-- Variantes --}}
            @if($producto->variantes && $producto->variantes->count() > 0)
            <div class="variants-title">
                Variantes disponibles ({{ $producto->variantes->count() }})
            </div>
            <table class="variants-table">
                <thead>
                    <tr>
                        <th>Talla</th>
                        <th>Color(es)</th>
                        <th>Stock</th>
                        <th>Precio Minorista</th>
                        <th>Precio Mayorista</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($producto->variantes as $variante)
                    <tr>
                        <td><strong>{{ $variante->talla?->nombre ?? 'N/A' }}</strong></td>
                        <td>
                            @foreach($variante->colores as $color)
                                <span class="color-circle" style="background: {{ $color->codigo_hex ?? '#000' }};"></span>
                                {{ $color->nombre }}{{ !$loop->last ? ',' : '' }}
                            @endforeach
                        </td>
                        <td class="text-center">{{ $variante->stock }}</td>
                        <td class="text-right">${{ number_format($variante->precio_minorista, 0, ',', '.') }}</td>
                        <td class="text-right">${{ number_format($variante->precio_mayorista, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div style="font-size: 8pt; color: #999; text-align: center; padding: 10px;">
                Sin variantes registradas para este producto
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="product-card">
        <div class="product-body text-center" style="padding: 40px;">
            <div style="margin-top: 10px;">No hay productos registrados</div>
            <div style="font-size: 8pt; color: #6c757d;">Prueba con otros filtros o crea un nuevo producto</div>
        </div>
    </div>
    @endforelse

    {{-- Footer --}}
    <div class="footer">
        <p>Documento generado automaticamente desde el sistema Branyey</p>
        <p>Branyey - Elegancia que se siente, calidad que se vive</p>
    </div>
</body>
</html>