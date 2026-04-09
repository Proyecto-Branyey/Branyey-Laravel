<?php $__env->startSection('title', 'Ventas - Branyey'); ?>

<?php $__env->startSection('admin-content'); ?>
<?php
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
?>

<div class="container-fluid px-4 py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <i class="bi bi-cash-coin me-2"></i>Ventas
            </h1>
            <p class="text-muted small mb-0">Gestión completa de transacciones y pedidos</p>
        </div>
        <div class="d-flex gap-2">
            <form method="GET" action="<?php echo e(route('admin.ventas.reporte', ['formato' => 'pdf'])); ?>" class="d-inline">
                <?php $__currentLoopData = request()->except('page'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <button type="submit" class="btn-export-pdf">
                    <i class="bi bi-file-earmark-pdf me-1"></i> PDF
                </button>
            </form>
            <form method="GET" action="<?php echo e(route('admin.ventas.reporte', ['formato' => 'csv'])); ?>" class="d-inline">
                <?php $__currentLoopData = request()->except('page'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <button type="submit" class="btn-export-csv">
                    <i class="bi bi-file-earmark-spreadsheet me-1"></i> CSV
                </button>
            </form>
        </div>
    </div>

    
    <div class="filters-card mb-4">
        <form method="GET" class="row g-3 align-items-end" id="filterForm">
            <div class="col-md-4 col-lg-3">
                <label class="filter-label">
                    <i class="bi bi-person-circle me-1"></i> Cliente
                </label>
                <input type="text" name="cliente" value="<?php echo e(request('cliente')); ?>" class="filter-input" placeholder="Nombre, email o teléfono">
            </div>
            <div class="col-md-4 col-lg-2">
                <label class="filter-label">
                    <i class="bi bi-people-fill me-1"></i> Tipo de cliente
                </label>
                <select name="tipo_cliente" class="filter-select">
                    <option value="">Todos</option>
                    <option value="mayorista" <?php if(request('tipo_cliente')=='mayorista'): ?> selected <?php endif; ?>>Mayorista</option>
                    <option value="minorista" <?php if(request('tipo_cliente')=='minorista'): ?> selected <?php endif; ?>>Minorista</option>
                </select>
            </div>
            <div class="col-md-4 col-lg-2">
                <label class="filter-label">
                    <i class="bi bi-flag me-1"></i> Estado
                </label>
                <select name="estado" class="filter-select">
                    <option value="">Todos</option>
                    <?php $__currentLoopData = $estadoOpciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>" <?php if(request('estado') === $key): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-4 col-lg-2">
                <label class="filter-label">
                    <i class="bi bi-calendar me-1"></i> Fecha desde
                </label>
                <input type="date" name="fecha_desde" value="<?php echo e(request('fecha_desde')); ?>" class="filter-input" id="fecha_desde" max="<?php echo e(request('fecha_hasta')); ?>">
            </div>
            <div class="col-md-4 col-lg-2">
                <label class="filter-label">
                    <i class="bi bi-calendar me-1"></i> Fecha hasta
                </label>
                <input type="date" name="fecha_hasta" value="<?php echo e(request('fecha_hasta')); ?>" class="filter-input" id="fecha_hasta" min="<?php echo e(request('fecha_desde')); ?>">
            </div>
            <div class="col-md-3 col-lg-1">
                <label class="filter-label">
                    <i class="bi bi-currency-dollar me-1"></i> Total min
                </label>
                <input type="number" name="total_min" value="<?php echo e(request('total_min')); ?>" class="filter-input" min="0" step="1000" placeholder="Min">
            </div>
            <div class="col-md-3 col-lg-1">
                <label class="filter-label">
                    <i class="bi bi-currency-dollar me-1"></i> Total max
                </label>
                <input type="number" name="total_max" value="<?php echo e(request('total_max')); ?>" class="filter-input" min="0" step="1000" placeholder="Max">
            </div>
            <div class="col-md-3 col-lg-1">
                <button type="submit" class="btn-filter-apply w-100">
                    <i class="bi bi-funnel me-1"></i> Filtrar
                </button>
            </div>
            <div class="col-md-3 col-lg-2">
                <a href="<?php echo e(route('admin.ventas.index')); ?>" class="btn-filter-clear w-100">
                    <i class="bi bi-x-circle me-1"></i> Borrar filtros
                </a>
            </div>
        </form>
    </div>

    
    <?php if(session('success')): ?>
        <div class="alert-success-card mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert-error-card mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    
    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th class="col-id">ID</th>
                    <th class="col-client">Cliente</th>
                    <th class="col-date">Fecha</th>
                    <th class="col-total">Total</th>
                    <th class="col-status">Estado</th>
                    <th class="col-actions">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $ventas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="col-id">#<?php echo e($venta->id); ?></td>
                        <td class="col-client">
                            <div class="client-cell">
                                <div class="client-avatar">
                                    <?php echo e(substr($venta->usuario->nombre_completo ?? $venta->usuario->username ?? 'U', 0, 2)); ?>

                                </div>
                                <div>
                                    <div class="client-name"><?php echo e($venta->usuario->nombre_completo ?? $venta->usuario->name ?? '-'); ?></div>
                                    <div class="client-email"><?php echo e($venta->usuario->email ?? ''); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="col-date">
                            <div><?php echo e($venta->created_at->format('d/m/Y')); ?></div>
                            <small class="text-muted"><?php echo e($venta->created_at->format('H:i')); ?></small>
                        </td>
                        <td class="col-total">
                            <span class="total-amount">$<?php echo e(number_format($venta->total, 0, ',', '.')); ?> COP</span>
                        </td>
                        <td class="col-status">
                            <form action="<?php echo e(route('admin.ventas.cambiarEstado', $venta)); ?>" method="POST" class="estado-form">
                                <?php echo csrf_field(); ?>
                                <select name="estado" class="status-select status-<?php echo e($estadoClases[$venta->estado] ?? 'secondary'); ?>" onchange="this.form.submit()">
                                    <?php $__currentLoopData = $estadoOpciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>" <?php if($venta->estado === $key): ?> selected <?php endif; ?>><?php echo e($label); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </form>
                        </td>
                        <td class="col-actions">
                            <div class="action-buttons">
                                <a href="<?php echo e(route('admin.ventas.show', $venta)); ?>" class="action-btn view" title="Ver detalles">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?php echo e(route('admin.ventas.factura', $venta)); ?>?pdf=1" class="action-btn invoice" title="Descargar factura" target="_blank">
                                    <i class="bi bi-file-earmark-arrow-down"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="empty-state-cell">
                            <div class="empty-state">
                                <i class="bi bi-cash-stack fs-1 text-muted"></i>
                                <p class="mt-3 mb-0">No hay ventas registradas</p>
                                <small class="text-muted">Las ventas aparecerán aquí cuando los clientes realicen pedidos</small>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
<div class="d-flex justify-content-center mt-5">
    <?php echo e($ventas->links('pagination::bootstrap-5')); ?>

</div>
</div>

<style>
/* ===== FILTROS ===== */
.filters-card {
    background: white;
    border-radius: 20px;
    padding: 1.25rem 1.5rem;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.filter-label {
    display: block;
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.filter-input, .filter-select {
    width: 100%;
    padding: 0.6rem 1rem;
    font-size: 0.85rem;
    border: 1.5px solid #e9ecef;
    border-radius: 12px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.filter-input:focus, .filter-select:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn-filter-apply {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.6rem 1.25rem;
    background: linear-gradient(135deg, #1a1a2e, #16213e);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-filter-apply:hover {
    background: linear-gradient(135deg, #667eea, #764ba2);
    transform: translateY(-1px);
}

.btn-filter-clear {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.6rem 1.25rem;
    background: transparent;
    color: #6c757d;
    border: 1.5px solid #e9ecef;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-filter-clear:hover {
    background: #f8f9fa;
    color: #dc3545;
    border-color: #dc3545;
}

/* ===== BOTONES EXPORTACIÓN ===== */
.btn-export-pdf {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 0.75rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-export-pdf:hover {
    background: #bb2d3b;
    transform: translateY(-1px);
}

.btn-export-csv {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    background: #198754;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 0.75rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-export-csv:hover {
    background: #157347;
    transform: translateY(-1px);
}

/* ===== ALERTAS ===== */
.alert-success-card, .alert-error-card {
    padding: 0.85rem 1rem;
    border-radius: 16px;
    font-size: 0.85rem;
    font-weight: 500;
    display: flex;
    align-items: center;
}

.alert-success-card {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
    border-left: 3px solid #10b981;
}

.alert-error-card {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    border-left: 3px solid #dc3545;
}

/* ===== TABLA ===== */
.table-container {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table th {
    padding: 1rem 1rem;
    text-align: left;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.admin-table td {
    padding: 1rem;
    border-bottom: 1px solid #f0f0f0;
    font-size: 0.85rem;
    vertical-align: middle;
}

.admin-table tr:hover {
    background: #fafbfc;
}

/* Columnas */
.col-id { width: 80px; }
.col-client { width: 220px; }
.col-date { width: 110px; }
.col-total { width: 150px; }
.col-status { width: 160px; }
.col-actions { width: 100px; }

/* Client cell */
.client-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.client-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
}

.client-name {
    font-weight: 700;
    color: #1a1a2e;
}

.client-email {
    font-size: 0.7rem;
    color: #6c757d;
}

.total-amount {
    font-weight: 800;
    color: #1a1a2e;
}

/* Status select */
.status-select {
    padding: 0.4rem 2rem 0.4rem 1rem;
    border-radius: 30px;
    font-size: 0.7rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='white'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.6rem center;
}

.status-select.status-success { background: #10b981; color: white; }
.status-select.status-warning { background: #ffc107; color: #1a1a2e; }
.status-select.status-primary { background: #0d6efd; color: white; }
.status-select.status-info { background: #0dcaf0; color: #1a1a2e; }
.status-select.status-danger { background: #dc3545; color: white; }
.status-select.status-secondary { background: #6c757d; color: white; }

/* Action buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
}

.action-btn.view {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
}

.action-btn.view:hover {
    background: #667eea;
    color: white;
    transform: translateY(-2px);
}

.action-btn.invoice {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.action-btn.invoice:hover {
    background: #10b981;
    color: white;
    transform: translateY(-2px);
}

/* Empty state */
.empty-state-cell {
    text-align: center !important;
    padding: 3rem !important;
}

.empty-state {
    text-align: center;
    padding: 2rem;
    color: #6c757d;
}

.empty-state i {
    font-size: 3rem;
    opacity: 0.5;
}



/* Responsive */
@media (max-width: 992px) {
    .admin-table {
        display: block;
        overflow-x: auto;
    }
    
    .col-id, .col-client, .col-date, .col-total, .col-status, .col-actions {
        min-width: 120px;
    }
}
</style>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fechaDesde = document.getElementById('fecha_desde');
    const fechaHasta = document.getElementById('fecha_hasta');

    if (fechaDesde && fechaHasta) {
        fechaDesde.addEventListener('change', function () {
            fechaHasta.min = fechaDesde.value || '';
        });

        fechaHasta.addEventListener('change', function () {
            fechaDesde.max = fechaHasta.value || '';
        });

        const form = fechaDesde.closest('form');
        if (form) {
            form.addEventListener('submit', function (e) {
                if (fechaDesde.value && fechaHasta.value && fechaHasta.value < fechaDesde.value) {
                    e.preventDefault();
                    alert('La fecha hasta no puede ser anterior a la fecha desde.');
                    fechaHasta.focus();
                }
            });
        }
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\Branyey-Laravel\resources\views/admin/ventas/index.blade.php ENDPATH**/ ?>