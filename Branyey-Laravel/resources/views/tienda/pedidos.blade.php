@extends('layouts.app')

@section('title', 'Mis Pedidos - Branyey')

@section('content')
<div class="container py-5">
    {{-- Header con estilo --}}
    <div class="text-center mb-5">
        <span class="badge bg-danger mb-2 px-3 py-2" style="background: linear-gradient(135deg, #dc3545, #ff6b6b) !important;">
            📦 MIS COMPRAS
        </span>
        <h1 class="fw-black display-5 mb-2">Mis Pedidos</h1>
        <p class="text-muted">Historial y seguimiento de tus compras</p>
    </div>

    {{-- Filtros mejorados --}}
    <div class="filters-pedidos mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="filter-label-pedido">
                    <i class="bi bi-funnel-fill me-1"></i> Filtrar por estado
                </label>
                <select id="filterEstado" class="form-select rounded-pill border-0 shadow-sm">
                    <option value="todos">Todos los pedidos</option>
                    <option value="pagado">Pagados</option>
                    <option value="en_proceso">En Proceso</option>
                    <option value="enviado">Enviados</option>
                    <option value="entregado">Entregados</option>
                    <option value="cancelado">Cancelados</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="filter-label-pedido">
                    <i class="bi bi-calendar3 me-1"></i> Periodo
                </label>
                <select id="filterPeriodo" class="form-select rounded-pill border-0 shadow-sm">
                    <option value="todos">Todos los periodos</option>
                    <option value="30">Últimos 30 días</option>
                    <option value="90">Últimos 90 días</option>
                    <option value="365">Último año</option>
                </select>
            </div>
            <div class="col-md-4">
                <div class="search-box-pedido">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchPedido" class="form-control rounded-pill border-0 shadow-sm" 
                           placeholder="Buscar por # pedido...">
                </div>
            </div>
        </div>
    </div>

    @if($ventas->isEmpty())
        <div class="empty-state-pedidos text-center py-5">
            <div class="empty-state-icon">
                <i class="bi bi-inbox fs-1"></i>
            </div>
            <h4 class="fw-bold mt-3">Aún no tienes pedidos</h4>
            <p class="text-muted mb-4">Explora nuestro catálogo y haz tu primera compra</p>
            <a href="{{ route('tienda.catalogo') }}" class="btn btn-dark rounded-pill px-5 py-2">
                <i class="bi bi-shop me-2"></i>Ir al Catálogo
            </a>
        </div>
    @else
        <div class="pedidos-container">
            @foreach($ventas as $venta)
                <div class="pedido-card" data-estado="{{ $venta->estado }}" data-id="{{ $venta->id }}" data-fecha="{{ $venta->created_at->timestamp }}">
                    {{-- Cabecera del pedido --}}
                    <div class="pedido-header" onclick="togglePedidoDetails(this)">
                        <div class="pedido-header-left">
                            <div class="pedido-number">
                                <i class="bi bi-receipt"></i>
                                <span>Pedido #{{ $venta->id }}</span>
                            </div>
                            <div class="pedido-date">
                                <i class="bi bi-calendar"></i>
                                <span>{{ $venta->created_at->format('d/m/Y') }}</span>
                                <small class="text-muted ms-2">{{ $venta->created_at->format('H:i') }} hrs</small>
                            </div>
                        </div>
                        <div class="pedido-header-right">
                            <div class="pedido-total">
                                <span class="total-label">Total</span>
                                <span class="total-value">${{ number_format($venta->total, 0, ',', '.') }} COP</span>
                            </div>
                            <div class="pedido-status">
                                {!! $venta->estado_badge !!}
                            </div>
                            <div class="pedido-toggle">
                                <i class="bi bi-chevron-down"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Detalles del pedido (colapsable) --}}
                    <div class="pedido-body" style="display: none;">
                        <div class="row g-4">
                            <div class="col-md-8">
                                <h6 class="details-title">
                                    <i class="bi bi-box-seam me-2"></i>Productos
                                </h6>
                                <div class="table-responsive">
                                    <table class="pedido-items-table">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Talla</th>
                                                <th>Cantidad</th>
                                                <th>Precio</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($venta->detallesVenta && $venta->detallesVenta->count() > 0)
                                                @foreach($venta->detallesVenta as $detalle)
                                                    <tr>
                                                        <td>
                                                            <div class="product-info-pedido">
                                                                @php
                                                                    $imagen = $detalle->variante?->producto?->imagenes->first()?->url;
                                                                @endphp
                                                                @if($imagen)
                                                                    <img src="{{ Storage::url($imagen) }}" alt="Producto" class="product-img-pedido">
                                                                @else
                                                                    <div class="product-img-placeholder">
                                                                        <i class="bi bi-image"></i>
                                                                    </div>
                                                                @endif
                                                                <span class="product-name-pedido">{{ $detalle->variante?->producto?->nombre_comercial ?? 'Producto' }}</span>
                                                            </div>
                                                        </td>
                                                        <td>{{ $detalle->variante?->talla?->nombre ?? 'N/A' }}</td>
                                                        <td>{{ $detalle->cantidad }}</td>
                                                        <td>${{ number_format($detalle->precio_cobrado, 0, ',', '.') }} COP</td>
                                                        <td class="fw-bold">${{ number_format($detalle->precio_cobrado * $detalle->cantidad, 0, ',', '.') }} COP</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center py-4 text-muted">
                                                        <i class="bi bi-box-seam me-2"></i>
                                                        No se encontraron productos para este pedido
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="pedido-summary">
                                    <h6 class="details-title">
                                        <i class="bi bi-info-circle me-2"></i>Información
                                    </h6>
                                    <div class="summary-item">
                                        <span>Subtotal:</span>
                                        <span>${{ number_format($venta->total, 0, ',', '.') }} COP</span>
                                    </div>
                                    <div class="summary-item">
                                        <span>Envío:</span>
                                        <span class="text-success">Gratis</span>
                                    </div>
                                    <div class="summary-item total">
                                        <span>Total pagado:</span>
                                        <span class="fw-bold">${{ number_format($venta->total, 0, ',', '.') }} COP</span>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="summary-item">
                                        <span>Fecha compra:</span>
                                        <span>{{ $venta->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <div class="summary-item">
                                        <span>Estado actual:</span>
                                        <span>{!! $venta->estado_badge !!}</span>
                                    </div>
                                    
                                    @if($venta->detallesOrden)
                                        <hr>
                                        <div class="summary-item">
                                            <span>Envío a:</span>
                                            <span class="text-muted small">{{ $venta->detallesOrden->direccion_envio ?? 'No especificada' }}</span>
                                        </div>
                                    @endif
                                </div>
                                
                                {{-- Acciones del pedido --}}
                                <div class="pedido-actions mt-3">
                                    <a href="{{ route('tienda.pedidos.factura', $venta->id) }}" 
                                       class="btn-action" target="_blank">
                                        <i class="bi bi-file-earmark-pdf"></i> Descargar Factura
                                    </a>
                                    
                                    @if($venta->estado === App\Models\Venta::ESTADO_ENVIADO)
                                        <form action="{{ route('tienda.pedidos.recibido', $venta->id) }}" method="POST" class="d-inline w-100">
                                            @csrf
                                            <button type="submit" class="btn-action success w-100">
                                                <i class="bi bi-check2-circle"></i> Marcar como Recibido
                                            </button>
                                        </form>
                                    @elseif($venta->estado === App\Models\Venta::ESTADO_ENTREGADO)
                                        <div class="btn-action delivered">
                                            <i class="bi bi-check2-all"></i> Pedido Recibido
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $ventas->links() }}
        </div>
    @endif
</div>

<style>
/* ===== FILTROS ===== */
.filters-pedidos {
    background: white;
    padding: 1.5rem;
    border-radius: 20px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.filter-label-pedido {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
    margin-bottom: 0.5rem;
    display: block;
}

.form-select, .search-box-pedido input {
    background: #f8f9fa;
    font-size: 0.85rem;
}

.search-box-pedido {
    position: relative;
}

.search-box-pedido i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    z-index: 1;
}

.search-box-pedido input {
    padding-left: 40px;
}

/* ===== PEDIDO CARD ===== */
.pedidos-container {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.pedido-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.pedido-card:hover {
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.12);
    border-color: rgba(102, 126, 234, 0.2);
}

.pedido-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem 1.5rem;
    cursor: pointer;
    background: white;
    transition: background 0.3s ease;
}

.pedido-header:hover {
    background: #f8f9fa;
}

.pedido-header-left {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.pedido-number {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 700;
    color: #1a1a2e;
}

.pedido-number i {
    color: #667eea;
    font-size: 1.1rem;
}

.pedido-number span {
    font-size: 0.9rem;
}

.pedido-date {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.75rem;
    color: #6c757d;
}

.pedido-date i {
    font-size: 0.75rem;
}

.pedido-header-right {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.pedido-total {
    text-align: right;
}

.total-label {
    display: block;
    font-size: 0.65rem;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.total-value {
    font-size: 1rem;
    font-weight: 800;
    color: #1a1a2e;
}

.pedido-toggle i {
    font-size: 1.2rem;
    color: #6c757d;
    transition: transform 0.3s ease;
}

.pedido-card.open .pedido-toggle i {
    transform: rotate(180deg);
}

/* ===== PEDIDO BODY ===== */
.pedido-body {
    border-top: 1px solid #f0f0f0;
    padding: 1.5rem;
    background: #fafbfc;
}

.details-title {
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #1a1a2e;
    margin-bottom: 1rem;
}

.pedido-items-table {
    width: 100%;
    font-size: 0.8rem;
}

.pedido-items-table thead th {
    text-align: left;
    padding: 0.75rem 0.5rem;
    color: #6c757d;
    font-weight: 600;
    border-bottom: 1px solid #e9ecef;
}

.pedido-items-table tbody td {
    padding: 0.75rem 0.5rem;
    border-bottom: 1px solid #f0f0f0;
}

.product-info-pedido {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.product-img-pedido {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 10px;
}

.product-img-placeholder {
    width: 50px;
    height: 50px;
    background: #e9ecef;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #adb5bd;
}

.product-name-pedido {
    font-weight: 600;
    color: #1a1a2e;
}

/* ===== SUMMARY ===== */
.pedido-summary {
    background: white;
    border-radius: 16px;
    padding: 1rem;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    font-size: 0.8rem;
}

.summary-item.total {
    font-size: 1rem;
    border-top: 1px solid #e9ecef;
    margin-top: 0.5rem;
    padding-top: 0.75rem;
}

/* ===== ACCIONES ===== */
.pedido-actions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    background: white;
    border: 1px solid #e9ecef;
    color: #1a1a2e;
    padding: 0.6rem 1rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-action:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: transparent;
    transform: translateY(-1px);
}

.btn-action.success {
    background: #10b981;
    color: white;
    border-color: transparent;
}

.btn-action.success:hover {
    background: #059669;
}

.btn-action.delivered {
    background: #e9ecef;
    color: #6c757d;
    cursor: default;
}

/* ===== EMPTY STATE ===== */
.empty-state-pedidos {
    background: white;
    border-radius: 20px;
    padding: 3rem;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.empty-state-icon i {
    font-size: 2rem;
    color: #667eea;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .pedido-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .pedido-header-right {
        width: 100%;
        justify-content: space-between;
    }
    
    .pedido-body {
        padding: 1rem;
    }
    
    .product-info-pedido {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .pedido-items-table {
        font-size: 0.7rem;
    }
}

/* ===== ANIMACIONES ===== */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.pedido-body {
    animation: slideDown 0.3s ease;
}
</style>

<script>
// Toggle detalles del pedido
function togglePedidoDetails(element) {
    const card = element.closest('.pedido-card');
    const body = card.querySelector('.pedido-body');
    const isOpen = body.style.display === 'block';
    
    body.style.display = isOpen ? 'none' : 'block';
    card.classList.toggle('open', !isOpen);
}

// Filtros
document.addEventListener('DOMContentLoaded', function() {
    const filterEstado = document.getElementById('filterEstado');
    const filterPeriodo = document.getElementById('filterPeriodo');
    const searchInput = document.getElementById('searchPedido');
    const pedidos = document.querySelectorAll('.pedido-card');
    
    function filterPedidos() {
        const estadoValue = filterEstado?.value || 'todos';
        const periodoValue = filterPeriodo?.value || 'todos';
        const searchValue = searchInput?.value.toLowerCase() || '';
        
        const ahora = Date.now() / 1000;
        const diasLimite = periodoValue !== 'todos' ? parseInt(periodoValue) : null;
        const fechaLimite = diasLimite ? ahora - (diasLimite * 24 * 60 * 60) : null;
        
        pedidos.forEach(pedido => {
            const estado = pedido.dataset.estado;
            const pedidoId = pedido.dataset.id;
            const fechaPedido = parseInt(pedido.dataset.fecha);
            
            let mostrar = true;
            
            // Filtrar por estado
            if (estadoValue !== 'todos' && estado !== estadoValue) {
                mostrar = false;
            }
            
            // Filtrar por periodo
            if (mostrar && fechaLimite && fechaPedido < fechaLimite) {
                mostrar = false;
            }
            
            // Filtrar por búsqueda
            if (mostrar && searchValue && !pedidoId.includes(searchValue)) {
                mostrar = false;
            }
            
            pedido.style.display = mostrar ? 'block' : 'none';
        });
    }
    
    if (filterEstado) filterEstado.addEventListener('change', filterPedidos);
    if (filterPeriodo) filterPeriodo.addEventListener('change', filterPedidos);
    if (searchInput) searchInput.addEventListener('keyup', filterPedidos);
});
</script>
@endsection