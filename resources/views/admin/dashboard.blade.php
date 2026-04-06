@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse min-vh-100 shadow">
            <div class="position-sticky pt-3">
                <h5 class="text-white px-3 mb-4 italic fw-black text-center">BRANYEY ADMIN</h5>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white active mb-2" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.ventas.index') }}">
                            <i class="bi bi-receipt me-2"></i> Ventas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex justify-content-between align-items-center" 
                           data-bs-toggle="collapse" href="#menuProductos" role="button" aria-expanded="false">
                            <span><i class="bi bi-box-seam me-2"></i> Productos</span>
                            <i class="bi bi-chevron-down small"></i>
                        </a>
                        <div class="collapse" id="menuProductos">
                            <ul class="nav flex-column ms-3 mt-1">
                                <li class="nav-item">
                                    <a class="nav-link text-secondary py-1" href="{{ route('admin.productos.index') }}">
                                        <i class="bi bi-list-ul me-2"></i> Ver Inventario
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-success py-1" href="{{ route('admin.productos.create') }}">
                                        <i class="bi bi-plus-lg me-2"></i> Añadir Nuevo
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white d-flex justify-content-between align-items-center" 
                           data-bs-toggle="collapse" href="#menuUsuarios" role="button" aria-expanded="false">
                            <span><i class="bi bi-people me-2"></i> Usuarios</span>
                            <i class="bi bi-chevron-down small"></i>
                        </a>
                        <div class="collapse" id="menuUsuarios">
                            <ul class="nav flex-column ms-3 mt-1">
                                <li class="nav-item">
                                    <a class="nav-link text-secondary py-1" href="{{ route('admin.usuarios.index') }}">
                                        <i class="bi bi-list-ul me-2"></i> Ver Usuarios
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-success py-1" href="{{ route('admin.usuarios.create') }}">
                                        <i class="bi bi-plus-lg me-2"></i> Añadir Usuario
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white d-flex justify-content-between align-items-center" 
                           data-bs-toggle="collapse" href="#menuCatalogos" role="button" aria-expanded="false">
                            <span><i class="bi bi-tags me-2"></i> Catálogos</span>
                            <i class="bi bi-chevron-down small"></i>
                        </a>
                        <div class="collapse" id="menuCatalogos">
                            <ul class="nav flex-column ms-3 mt-1">
                                <li class="nav-item">
                                    <a class="nav-link text-secondary py-1" href="{{ route('admin.tallas.index') }}">
                                        <i class="bi bi-rulers me-2"></i> Tallas
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-secondary py-1" href="{{ route('admin.colores.index') }}">
                                        <i class="bi bi-palette me-2"></i> Colores
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-secondary py-1" href="{{ route('admin.estilos-camisa.index') }}">
                                        <i class="bi bi-brush me-2"></i> Estilos
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <hr class="text-secondary mx-3">


                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 fw-bold text-uppercase">Gestión Administrativa</h1>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-lg rounded-4 p-4 position-relative overflow-hidden dashboard-card-gradient-primary">
                        <div class="dashboard-icon-bg"><i class="bi bi-bar-chart-line"></i></div>
                        <small class="text-uppercase fw-bold text-primary">Ventas reales</small>
                        <h2 class="fw-black mb-0">{{ $stats['ventas_count'] }}</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-lg rounded-4 p-4 position-relative overflow-hidden dashboard-card-gradient-success">
                        <div class="dashboard-icon-bg"><i class="bi bi-cash-coin"></i></div>
                        <small class="text-uppercase fw-bold text-success">Ingresos totales</small>
                        <h2 class="fw-black mb-0">${{ number_format($stats['ingresos_total'], 0, ',', '.') }} <span class="fs-6">COP</span></h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-lg rounded-4 p-4 position-relative overflow-hidden dashboard-card-gradient-warning">
                        <div class="dashboard-icon-bg"><i class="bi bi-box-seam"></i></div>
                        <small class="text-uppercase fw-bold text-warning">Catálogo</small>
                        <h2 class="fw-black mb-0">{{ $stats['productos_count'] }}</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-lg rounded-4 p-4 position-relative overflow-hidden dashboard-card-gradient-info">
                        <div class="dashboard-icon-bg"><i class="bi bi-people"></i></div>
                        <small class="text-uppercase fw-bold text-info">Clientes</small>
                        <h2 class="fw-black mb-0">{{ $stats['usuarios_count'] }}</h2>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                        <h6 class="fw-bold mb-3 text-warning"><i class="bi bi-exclamation-triangle me-2"></i>Variantes bajas en stock</h6>
                        <ul class="list-group list-group-flush">
                            @forelse($bajo_stock as $variante)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        {{ $variante->producto->nombre_comercial ?? 'Producto eliminado' }}
                                        @if($variante->talla)
                                            <span class="badge bg-secondary ms-2">Talla: {{ $variante->talla->nombre ?? '-' }}</span>
                                        @endif
                                    </span>
                                    <span class="badge bg-warning text-dark">{{ $variante->stock }}</span>
                                </li>
                            @empty
                                <li class="list-group-item text-muted">No hay variantes bajas en stock.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                        <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-clock-history me-2"></i>Ventas recientes</h6>
                        <ul class="list-group list-group-flush">
                            @forelse($ventas_recientes as $venta)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        #{{ $venta->id }} -
                                        {{ $venta->usuario->nombre_completo ?? 'Cliente eliminado' }}
                                        <small class="text-muted">({{ $venta->created_at->format('d/m/Y H:i') }})</small>
                                    </span>
                                    <span class="badge bg-primary">${{ number_format($venta->total, 0, ',', '.') }}</span>
                                </li>
                            @empty
                                <li class="list-group-item text-muted">No hay ventas recientes.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <style>
                .dashboard-card-gradient-primary {
                    background: linear-gradient(135deg, #e3f0ff 0%, #c9e4ff 100%);
                }
                .dashboard-card-gradient-success {
                    background: linear-gradient(135deg, #e6ffed 0%, #c8ffe3 100%);
                }
                .dashboard-card-gradient-warning {
                    background: linear-gradient(135deg, #fffbe6 0%, #fff3c8 100%);
                }
                .dashboard-card-gradient-info {
                    background: linear-gradient(135deg, #e6f7ff 0%, #c8f4ff 100%);
                }
                .dashboard-icon-bg {
                    position: absolute;
                    top: 10px;
                    right: 20px;
                    font-size: 3.5rem;
                    opacity: 0.13;
                    z-index: 0;
                }
                .dashboard-card-gradient-primary .dashboard-icon-bg { color: #007bff; }
                .dashboard-card-gradient-success .dashboard-icon-bg { color: #28a745; }
                .dashboard-card-gradient-warning .dashboard-icon-bg { color: #ffc107; }
                .dashboard-card-gradient-info .dashboard-icon-bg { color: #17a2b8; }
                .fw-black { font-weight: 900; }
                .italic { font-style: italic; }
                .sidebar .nav-link { transition: 0.2s; padding: 12px 20px; border-radius: 10px; margin: 5px 12px; font-size: 0.95rem; }
                .sidebar .nav-link:hover { background: rgba(255,255,255,0.08); color: #fff !important; }
                .nav-link[aria-expanded="true"] { background: rgba(255,255,255,0.05); }
                hr { opacity: 0.2; }
            </style>
@endsection