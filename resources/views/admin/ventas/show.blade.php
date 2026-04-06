@extends('layouts.admin')
@section('title', 'Detalle de Venta')
@section('admin-content')
@php
    $estadoOpciones = [
        'pagado' => 'Pagado',
        'en_proceso' => 'En proceso',
        'enviado' => 'Enviado',
        'entregado' => 'Entregado',
        'cancelado' => 'Cancelado',
    ];

    $estadoClases = [
        'pagado' => 'success',
        'en_proceso' => 'warning',
        'enviado' => 'primary',
        'entregado' => 'info',
        'cancelado' => 'danger',
    ];

    $estadoClase = $estadoClases[$venta->estado] ?? 'secondary';
@endphp
<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <h1 class="h3 mb-0 me-3">
            <i class="bi bi-receipt me-2"></i> Detalle de Venta
        </h1>
        <span class="badge bg-{{ $estadoClase }} text-capitalize px-3 py-2">{{ $venta->estado_label }}</span>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-light fw-bold">Datos de la Venta</div>
                <div class="card-body py-2">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">ID</dt>
                        <dd class="col-sm-8">{{ $venta->id ?? '' }}</dd>
                        <dt class="col-sm-4">Cliente</dt>
                        <dd class="col-sm-8">{{ $venta->usuario->nombre_completo ?? $venta->usuario->name ?? '' }}</dd>
                        <dt class="col-sm-4">Fecha</dt>
                        <dd class="col-sm-8">{{ $venta->created_at ? $venta->created_at->format('Y-m-d H:i') : '' }}</dd>
                        <dt class="col-sm-4">Total</dt>
                        <dd class="col-sm-8 fw-semibold">${{ number_format($venta->total, 0, ',', '.') }}</dd>
                        <dt class="col-sm-4">Estado</dt>
                        <dd class="col-sm-8">
                            <form action="{{ route('admin.ventas.cambiarEstado', $venta) }}" method="POST" class="d-inline align-middle estado-form">
                                @csrf
                                <div class="position-relative d-inline-block">
                                    <select name="estado" class="form-select form-select-sm estado-select fw-semibold text-capitalize bg-{{ $estadoClase }} text-white border-0 px-2 py-1 pe-4 shadow-sm" onchange="this.form.submit()" style="min-width: 125px; cursor:pointer; transition: background 0.2s;">
                                        @foreach($estadoOpciones as $key => $label)
                                            <option value="{{ $key }}" @if($venta->estado === $key) selected @endif>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <span class="estado-caret position-absolute end-0 top-50 translate-middle-y pe-2"><i class="bi bi-chevron-down"></i></span>
                                </div>
                            </form>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        @if($venta->detallesOrden)
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">Datos de Envío</div>
                <div class="card-body py-2">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Nombre</dt>
                        <dd class="col-sm-8">{{ $venta->detallesOrden->nombre_cliente }}</dd>
                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $venta->detallesOrden->email_cliente }}</dd>
                        <dt class="col-sm-4">Teléfono</dt>
                        <dd class="col-sm-8">{{ $venta->detallesOrden->telefono_cliente }}</dd>
                        <dt class="col-sm-4">Dirección</dt>
                        <dd class="col-sm-8">{{ $venta->detallesOrden->direccion_envio }}</dd>
                        <dt class="col-sm-4">Ciudad</dt>
                        <dd class="col-sm-8">{{ $venta->detallesOrden->ciudad }}</dd>
                        <dt class="col-sm-4">Departamento</dt>
                        <dd class="col-sm-8">{{ $venta->detallesOrden->departamento }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        @endif
    </div>

    @if($venta->detallesOrden)
    <div class="card mb-3">
        <div class="card-header bg-primary text-white">Datos de Envío</div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Nombre</dt>
                <dd class="col-sm-9">{{ $venta->detallesOrden->nombre_cliente }}</dd>
                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $venta->detallesOrden->email_cliente }}</dd>
                <dt class="col-sm-3">Teléfono</dt>
                <dd class="col-sm-9">{{ $venta->detallesOrden->telefono_cliente }}</dd>
                <dt class="col-sm-3">Dirección</dt>
                <dd class="col-sm-9">{{ $venta->detallesOrden->direccion_envio }}</dd>
                <dt class="col-sm-3">Ciudad</dt>
                <dd class="col-sm-9">{{ $venta->detallesOrden->ciudad }}</dd>
                <dt class="col-sm-3">Departamento</dt>
                <dd class="col-sm-9">{{ $venta->detallesOrden->departamento }}</dd>
            </dl>
        </div>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header bg-secondary text-white fw-semibold"><i class="bi bi-box-seam me-2"></i>Productos Vendidos</div>
        <div class="card-body p-0">
            <table class="table table-bordered table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th>Variante</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-end">Precio</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                                        @foreach($venta->detallesVenta as $i => $detalle)
                                                <tr>
                                                        <td>
                                                                {{ $detalle->variante->producto->nombre_comercial ?? '-' }}
                                                                <button type="button" class="btn btn-link btn-sm p-0 ms-2 align-baseline" data-bs-toggle="modal" data-bs-target="#detalleProductoModal{{ $i }}">
                                                                        <i class="bi bi-info-circle"></i> Ver detalles
                                                                </button>
                                                                <!-- Modal Detalle Producto -->
                                                                <div class="modal fade" id="detalleProductoModal{{ $i }}" tabindex="-1" aria-labelledby="detalleProductoModalLabel{{ $i }}" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="detalleProductoModalLabel{{ $i }}">Detalles de la Prenda</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <ul class="list-group list-group-flush">
                                                                                    <li class="list-group-item"><strong>Nombre comercial:</strong> {{ $detalle->variante->producto->nombre_comercial ?? '-' }}</li>
                                                                                    <li class="list-group-item"><strong>SKU:</strong> {{ $detalle->variante->sku ?? '-' }}</li>
                                                                                    <li class="list-group-item"><strong>Talla:</strong> {{ $detalle->variante->talla->nombre ?? '-' }}</li>
                                                                                      <li class="list-group-item"><strong>Color:</strong>
                                                                                        @php $colores = $detalle->variante->colores; @endphp
                                                                                        @if($colores && $colores->count())
                                                                                            @foreach($colores as $color)
                                                                                                <span class="d-inline-flex align-items-center me-2">
                                                                                                    @if(!empty($color->codigo_hex))
                                                                                                        <span style="display:inline-block;width:16px;height:16px;border-radius:50%;background:{{ $color->codigo_hex }};border:1px solid #ccc;margin-right:4px;"></span>
                                                                                                    @endif
                                                                                                    {{ $color->nombre }}
                                                                                                </span>
                                                                                            @endforeach
                                                                                        @else
                                                                                            <span class="text-muted">-</span>
                                                                                        @endif
                                                                                      </li>
                                                                                    <!-- Otros atributos -->
                                                                                    @if(!empty($detalle->variante->atributos))
                                                                                        @foreach($detalle->variante->atributos as $atributo => $valor)
                                                                                            <li class="list-group-item"><strong>{{ ucfirst($atributo) }}:</strong> {{ $valor }}</li>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </td>
                                                        <td>
                                                                <span class="d-block small text-muted">SKU: {{ $detalle->variante->sku ?? '-' }}</span>
                                                                <span class="d-block">Talla: <span class="fw-semibold">{{ $detalle->variante->talla->nombre ?? '-' }}</span></span>
                                                        </td>
                                                        <td class="text-center">{{ $detalle->cantidad }}</td>
                                                        <td class="text-end">${{ number_format($detalle->precio_cobrado, 2) }}</td>
                                                        <td class="text-end">${{ number_format($detalle->cantidad * $detalle->precio_cobrado, 0) }}</td>
                                                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <a href="{{ route('admin.ventas.index') }}" class="btn btn-outline-primary px-4 py-2 fw-semibold"><i class="bi bi-arrow-left me-1"></i> Volver al listado</a>
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
        .estado-form .estado-select.bg-primary { background: #0d6efd !important; }
        .estado-form .estado-select.bg-info { background: #0dcaf0 !important; color: #0b2f3a !important; }
        .estado-form .estado-select.bg-danger { background: #dc3545 !important; }
        .estado-form .estado-select.bg-secondary { background: #6c757d !important; }
        .estado-form .estado-select:focus { outline: 2px solid #0d6efd; box-shadow: 0 0 0 0.15rem #0d6efd33; }
        .estado-form { margin-bottom: 0; }
    </style>
@endpush
@endsection
