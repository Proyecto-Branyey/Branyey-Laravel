<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Usuarios - Branyey</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 10pt;
            margin: 2cm;
            color: #1a1a2e;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #667eea;
        }
        
        .logo {
            font-size: 20pt;
            font-weight: 900;
            letter-spacing: 2px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .title {
            font-size: 14pt;
            font-weight: 700;
            margin-top: 10px;
        }
        
        .subtitle {
            font-size: 9pt;
            color: #6c757d;
            margin-top: 5px;
        }
        
        .filters-info {
            background: #f8f9fa;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 8pt;
            margin-bottom: 20px;
            border-left: 3px solid #667eea;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        th {
            background: #f0f0f0;
            padding: 10px 8px;
            text-align: left;
            font-size: 9pt;
            font-weight: 700;
            border-bottom: 1px solid #ddd;
        }
        
        td {
            padding: 8px;
            border-bottom: 1px solid #eee;
            font-size: 9pt;
        }
        
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 8pt;
            font-weight: 600;
        }
        
        .badge-admin { background: rgba(220, 53, 69, 0.1); color: #dc3545; }
        .badge-mayorista { background: rgba(255, 193, 7, 0.1); color: #ffc107; }
        .badge-minorista { background: rgba(16, 185, 129, 0.1); color: #10b981; }
        
        .status-active { color: #10b981; font-weight: 600; }
        .status-inactive { color: #6c757d; font-weight: 600; }
        
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            font-size: 7pt;
            text-align: center;
            color: #adb5bd;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">BRANYEY</div>
        <div class="title">Reporte de Usuarios</div>
        <div class="subtitle">Generado el {{ now()->format('d/m/Y H:i:s') }}</div>
    </div>

    @if(request('search') || request('rol') || request('estado'))
    <div class="filters-info">
        <strong>Filtros aplicados:</strong>
        @if(request('search')) 🔍 Búsqueda: "{{ request('search') }}" @endif
        @if(request('rol')) 📌 Rol: {{ ucfirst(request('rol')) }} @endif
        @if(request('estado')) 📊 Estado: {{ ucfirst(request('estado')) }} @endif
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($usuarios as $usuario)
            <tr>
                <td>#{{ $usuario->id }}</td>
                <td>{{ $usuario->nombre_completo ?? 'No registrado' }}</td>
                <td>{{ $usuario->username }}</td>
                <td>{{ $usuario->email }}</td>
                <td>
                    @php
                        $rolClass = match($usuario->rol->nombre ?? 'minorista') {
                            'administrador' => 'badge-admin',
                            'mayorista' => 'badge-mayorista',
                            default => 'badge-minorista'
                        };
                    @endphp
                    <span class="badge {{ $rolClass }}">{{ ucfirst($usuario->rol->nombre ?? 'Minorista') }}</span>
                </td>
                <td class="{{ $usuario->activo ? 'status-active' : 'status-inactive' }}">
                    {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No hay usuarios registrados</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Total de usuarios: {{ $usuarios->count() }}</p>
        <p>Branyey - Elegancia que se siente, calidad que se vive</p>
    </div>
</body>
</html>