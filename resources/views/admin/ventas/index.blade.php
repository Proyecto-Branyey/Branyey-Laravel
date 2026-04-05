@extends('layouts.admin')
@section('title', 'Ventas')
@section('admin-content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="bi bi-cash-coin me-2"></i> Listado de Ventas
        </h1>
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
