@extends('layouts.admin')
@section('title', 'Ventas')
@section('admin-content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="bi bi-cash-coin me-2"></i> Listado de Ventas
        </h1>
        <div>
            <form method="GET" action="{{ route('admin.ventas.reporte', ['formato' => 'pdf']) }}" class="d-inline">
                @foreach(request()->except('page') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <button type="submit" class="btn btn-outline-danger btn-sm me-2"><i class="bi bi-file-earmark-pdf"></i> PDF</button>
            </form>
            <form method="GET" action="{{ route('admin.ventas.reporte', ['formato' => 'excel']) }}" class="d-inline">
                @foreach(request()->except('page') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <button type="submit" class="btn btn-outline-success btn-sm"><i class="bi bi-file-earmark-excel"></i> Excel</button>
            </form>
        </div>
    </div>
    <!-- Filtros Mejorados -->
    <div class="card mb-4 border-0 shadow-sm bg-light">
        <div class="card-body py-3">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4 col-lg-3">
                    <label class="form-label mb-1"><i class="bi bi-person-circle me-1"></i>Cliente</label>
                    <input type="text" name="cliente" value="{{ request('cliente') }}" class="form-control" placeholder="Nombre, email o teléfono">
                </div>
                <div class="col-md-4 col-lg-2">
                    <label class="form-label mb-1"><i class="bi bi-people-fill me-1"></i>Tipo de cliente</label>
                    <select name="tipo_cliente" class="form-select">
                        <option value="">Todos</option>
                        <option value="mayorista" @if(request('tipo_cliente')=='mayorista') selected @endif>Mayorista</option>
                        <option value="minorista" @if(request('tipo_cliente')=='minorista') selected @endif>Minorista</option>
                    </select>
                </div>
                <div class="col-md-4 col-lg-2">
                    <label class="form-label mb-1"><i class="bi bi-flag me-1"></i>Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos</option>
                        <option value="pendiente" @if(request('estado')=='pendiente') selected @endif>Pendiente</option>
                        <option value="pagado" @if(request('estado')=='pagado') selected @endif>Pagado</option>
                        <option value="enviado" @if(request('estado')=='enviado') selected @endif>Enviado</option>
                        <option value="cancelado" @if(request('estado')=='cancelado') selected @endif>Cancelado</option>
                    </select>
                </div>
                <div class="col-md-4 col-lg-2">
                    <label class="form-label mb-1"><i class="bi bi-calendar me-1"></i>Fecha desde</label>
                    <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" class="form-control">
                </div>
                <div class="col-md-4 col-lg-2">
                    <label class="form-label mb-1"><i class="bi bi-calendar me-1"></i>Fecha hasta</label>
                    <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" class="form-control">
                </div>
                <div class="col-md-4 col-lg-1">
                    <label class="form-label mb-1"><i class="bi bi-currency-dollar me-1"></i>Total min</label>
                    <input type="number" name="total_min" value="{{ request('total_min') }}" class="form-control" min="0" step="1000">
                </div>
                <div class="col-md-4 col-lg-1">
                    <label class="form-label mb-1"><i class="bi bi-currency-dollar me-1"></i>Total max</label>
                    <input type="number" name="total_max" value="{{ request('total_max') }}" class="form-control" min="0" step="1000">
                </div>
                <div class="col-12 col-lg-1 d-grid">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-funnel me-1"></i>Filtrar</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Total</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ventas as $venta)
                            <tr>
                                <td>{{ $venta->id }}</td>
                                <td>{{ $venta->usuario->nombre_completo ?? $venta->usuario->name ?? '-' }}</td>
                                <td>{{ $venta->created_at->format('Y-m-d H:i') }}</td>
                                <td class="fw-semibold">${{ number_format($venta->total, 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('admin.ventas.cambiarEstado', $venta) }}" method="POST" class="d-inline align-middle estado-form">
                                        @csrf
                                        <div class="position-relative d-inline-block">
                                            <select name="estado" class="form-select form-select-sm estado-select fw-semibold text-capitalize bg-{{
                                                $venta->estado === 'pagado' ? 'success' :
                                                ($venta->estado === 'pendiente' ? 'warning' :
                                                ($venta->estado === 'cancelado' ? 'danger' : 'secondary'))
                                            }} text-white border-0 px-2 py-1 pe-4 shadow-sm" onchange="this.form.submit()" style="min-width: 110px; cursor:pointer; transition: background 0.2s;">
                                                @foreach(['pendiente' => 'Pendiente', 'pagado' => 'Pagado', 'enviado' => 'Enviado', 'cancelado' => 'Cancelado'] as $key => $label)
                                                    <option value="{{ $key }}" @if($venta->estado === $key) selected @endif>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                            <span class="estado-caret position-absolute end-0 top-50 translate-middle-y pe-2"><i class="bi bi-chevron-down"></i></span>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('admin.ventas.show', $venta) }}" class="btn btn-sm btn-primary px-3 shadow-sm">Ver</a>
                                    <a href="{{ route('admin.ventas.factura', $venta) }}?pdf=1" class="btn btn-sm btn-secondary px-3 shadow-sm ms-1"><i class="bi bi-file-earmark-arrow-down"></i> Descargar factura</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No hay ventas registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .estado-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            border-radius: 1.5rem;
            padding-right: 2rem !important;
            font-size: 0.95rem;
            background-image: none !important;
        }
        .estado-caret {
            pointer-events: none;
            color: #fff;
            font-size: 1rem;
        }
        .estado-form .estado-select.bg-success { background: #198754 !important; }
        .estado-form .estado-select.bg-warning { background: #ffc107 !important; color: #212529 !important; }
        .estado-form .estado-select.bg-danger { background: #dc3545 !important; }
        .estado-form .estado-select.bg-secondary { background: #6c757d !important; }
        .estado-form .estado-select:focus { outline: 2px solid #0d6efd; box-shadow: 0 0 0 0.15rem #0d6efd33; }
        .estado-form { margin-bottom: 0; }
    </style>
@endpush
@endsection
