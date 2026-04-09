<?php $__env->startSection('admin-content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 fw-bold text-uppercase" style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        <i class="bi bi-speedometer2 me-2"></i>Dashboard
    </h1>
    <div class="text-muted small">
        <i class="bi bi-calendar3 me-1"></i> <?php echo e(now()->format('d/m/Y')); ?>

    </div>
</div>


<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-3">
        <a href="<?php echo e(route('admin.ventas.index')); ?>" class="text-decoration-none text-reset d-block dashboard-card-link">
            <div class="card border-0 shadow-sm rounded-4 p-4 position-relative overflow-hidden dashboard-card-gradient-primary">
                <div class="dashboard-icon-bg"><i class="bi bi-bar-chart-line"></i></div>
                <small class="text-uppercase fw-bold text-primary">Ventas reales</small>
                <h2 class="fw-black mb-0"><?php echo e($stats['ventas_count'] ?? 0); ?></h2>
            </div>
        </a>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <a href="<?php echo e(route('admin.ventas.index')); ?>" class="text-decoration-none text-reset d-block dashboard-card-link">
            <div class="card border-0 shadow-sm rounded-4 p-4 position-relative overflow-hidden dashboard-card-gradient-success">
                <div class="dashboard-icon-bg"><i class="bi bi-cash-coin"></i></div>
                <small class="text-uppercase fw-bold text-success">Ingresos totales</small>
                <h2 class="fw-black mb-0">$<?php echo e(number_format($stats['ingresos_total'] ?? 0, 0, ',', '.')); ?> <span class="fs-6">COP</span></h2>
            </div>
        </a>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <a href="<?php echo e(route('admin.productos.index')); ?>" class="text-decoration-none text-reset d-block dashboard-card-link">
            <div class="card border-0 shadow-sm rounded-4 p-4 position-relative overflow-hidden dashboard-card-gradient-warning">
                <div class="dashboard-icon-bg"><i class="bi bi-box-seam"></i></div>
                <small class="text-uppercase fw-bold text-warning">Catálogo</small>
                <h2 class="fw-black mb-0"><?php echo e($stats['productos_count'] ?? 0); ?></h2>
            </div>
        </a>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <a href="<?php echo e(route('admin.usuarios.index')); ?>" class="text-decoration-none text-reset d-block dashboard-card-link">
            <div class="card border-0 shadow-sm rounded-4 p-4 position-relative overflow-hidden dashboard-card-gradient-info">
                <div class="dashboard-icon-bg"><i class="bi bi-people"></i></div>
                <small class="text-uppercase fw-bold text-info">Clientes</small>
                <h2 class="fw-black mb-0"><?php echo e($stats['clientes_count'] ?? 0); ?></h2>
                <small class="text-muted d-block mt-1">Mayoristas: <?php echo e($stats['mayoristas_count'] ?? 0); ?> | Minoristas: <?php echo e($stats['minoristas_count'] ?? 0); ?></small>
            </div>
        </a>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <a href="<?php echo e(route('admin.usuarios.index')); ?>" class="text-decoration-none text-reset d-block dashboard-card-link">
            <div class="card border-0 shadow-sm rounded-4 p-4 position-relative overflow-hidden dashboard-card-gradient-admin">
                <div class="dashboard-icon-bg"><i class="bi bi-shield-lock"></i></div>
                <small class="text-uppercase fw-bold text-dark">Administradores</small>
                <h2 class="fw-black mb-0"><?php echo e($stats['admins_count'] ?? 0); ?></h2>
            </div>
        </a>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <a href="<?php echo e(route('admin.usuarios.papelera')); ?>" class="text-decoration-none text-reset d-block dashboard-card-link">
            <div class="card border-0 shadow-sm rounded-4 p-4 position-relative overflow-hidden dashboard-card-gradient-trash">
                <div class="dashboard-icon-bg"><i class="bi bi-trash3"></i></div>
                <small class="text-uppercase fw-bold text-danger">Usuarios en papelera</small>
                <h2 class="fw-black mb-0"><?php echo e($stats['usuarios_papelera_count'] ?? 0); ?></h2>
                <small class="text-muted d-block mt-1">Incluye administradores</small>
            </div>
        </a>
    </div>
</div>


<div class="row g-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <h6 class="fw-bold mb-3 text-warning">
                <i class="bi bi-exclamation-triangle me-2"></i>Variantes bajas en stock
            </h6>
            <ul class="list-group list-group-flush">
                <?php $__empty_1 = true; $__currentLoopData = $bajo_stock ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <?php echo e($variante->producto->nombre_comercial ?? 'Producto eliminado'); ?>

                            <?php if($variante->talla): ?>
                                <span class="badge bg-secondary ms-2">Talla: <?php echo e($variante->talla->nombre ?? '-'); ?></span>
                            <?php endif; ?>
                        </span>
                        <span class="badge bg-warning text-dark"><?php echo e($variante->stock); ?></span>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <li class="list-group-item text-muted">No hay variantes bajas en stock.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <h6 class="fw-bold mb-3 text-primary">
                <i class="bi bi-clock-history me-2"></i>Ventas recientes
            </h6>
            <ul class="list-group list-group-flush">
                <?php $__empty_1 = true; $__currentLoopData = $ventas_recientes ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            #<?php echo e($venta->id); ?> -
                            <?php echo e($venta->usuario->nombre_completo ?? 'Cliente eliminado'); ?>

                            <small class="text-muted">(<?php echo e($venta->created_at->format('d/m/Y H:i')); ?>)</small>
                        </span>
                        <span class="badge bg-primary">$<?php echo e(number_format($venta->total, 0, ',', '.')); ?></span>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <li class="list-group-item text-muted">No hay ventas recientes.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<style>
    /* Estilos de las tarjetas del dashboard */
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
    .dashboard-card-gradient-admin {
        background: linear-gradient(135deg, #ececec 0%, #d8d8d8 100%);
    }
    .dashboard-card-gradient-trash {
        background: linear-gradient(135deg, #ffe8e8 0%, #ffd4d4 100%);
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
    .dashboard-card-gradient-admin .dashboard-icon-bg { color: #343a40; }
    .dashboard-card-gradient-trash .dashboard-icon-bg { color: #dc3545; }
    
    .dashboard-card-link .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .dashboard-card-link:hover .card {
        transform: translateY(-2px);
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1) !important;
    }
    
    .list-group-item {
        background: transparent;
        border-color: #f0f0f0;
    }
    
    .list-group-item:last-child {
        border-bottom: none;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\Branyey-Laravel\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>