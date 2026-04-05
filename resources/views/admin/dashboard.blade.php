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

                    <li class="nav-item">
                        <a class="nav-link text-warning fw-bold" href="{{ route('admin.reportes.ventas') }}">
                            <i class="bi bi-file-earmark-pdf me-2"></i> Reporte de Ventas
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 fw-bold text-uppercase">Gestión Administrativa</h1>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-primary border-4">
                        <small class="text-muted fw-bold">VENTAS REALES</small>
                        <h3 class="fw-black">{{ $stats['ventas_count'] }}</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-success border-4">
                        <small class="text-muted fw-bold">INGRESOS TOTALES</small>
                        <h3 class="fw-black">${{ number_format($stats['ingresos_total'], 0, ',', '.') }} COP</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-warning border-4">
                        <small class="text-muted fw-bold">CATÁLOGO</small>
                        <h3 class="fw-black">{{ $stats['productos_count'] }}</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-info border-4">
                        <small class="text-muted fw-bold">CLIENTES</small>
                        <h3 class="fw-black">{{ $stats['usuarios_count'] }}</h3>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4 bg-light">
                <h5 class="fw-bold"><i class="bi bi-rocket-takeoff me-2"></i>¡Bienvenido al Panel de Branyey!</h5>
                <p class="text-muted">Utiliza el menú de la izquierda para gestionar tus prendas, actualizar stock o generar los reportes PDF para tu entrega.</p>
            </div>
        </main>
    </div>
</div>

<style>
    .fw-black { font-weight: 900; }
    .italic { font-style: italic; }
    .sidebar .nav-link { transition: 0.2s; padding: 12px 20px; border-radius: 10px; margin: 5px 12px; font-size: 0.95rem; }
    .sidebar .nav-link:hover { background: rgba(255,255,255,0.08); color: #fff !important; }
    .nav-link[aria-expanded="true"] { background: rgba(255,255,255,0.05); }
    hr { opacity: 0.2; }
</style>
@endsection 