<?php $__env->startSection('title', 'Ventas'); ?>
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
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="bi bi-cash-coin me-2"></i> Listado de Ventas
        </h1>
        <div>
            <form method="GET" action="<?php echo e(route('admin.ventas.reporte', ['formato' => 'pdf'])); ?>" class="d-inline">
                <?php $__currentLoopData = request()->except('page'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <button type="submit" class="btn btn-outline-danger btn-sm me-2"><i class="bi bi-file-earmark-pdf"></i> PDF</button>
            </form>
            <form method="GET" action="<?php echo e(route('admin.ventas.reporte', ['formato' => 'csv'])); ?>" class="d-inline">
                <?php $__currentLoopData = request()->except('page'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <button type="submit" class="btn btn-outline-success btn-sm"><i class="bi bi-file-earmark-spreadsheet"></i> CSV</button>
            </form>
        </div>
    </div>

    <div class="card mb-4 border-0 shadow-sm bg-light">
        <div class="card-body py-3">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4 col-lg-3">
                    <label class="form-label mb-1"><i class="bi bi-person-circle me-1"></i>Cliente</label>
                    <input type="text" name="cliente" value="<?php echo e(request('cliente')); ?>" class="form-control" placeholder="Nombre, email o teléfono">
                </div>
                <div class="col-md-4 col-lg-2">
                    <label class="form-label mb-1"><i class="bi bi-people-fill me-1"></i>Tipo de cliente</label>
                    <select name="tipo_cliente" class="form-select">
                        <option value="">Todos</option>
                        <option value="mayorista" <?php if(request('tipo_cliente')=='mayorista'): ?> selected <?php endif; ?>>Mayorista</option>
                        <option value="minorista" <?php if(request('tipo_cliente')=='minorista'): ?> selected <?php endif; ?>>Minorista</option>
                    </select>
                </div>
                <div class="col-md-4 col-lg-2">
                    <label class="form-label mb-1"><i class="bi bi-flag me-1"></i>Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos</option>
                        <?php $__currentLoopData = $estadoOpciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>" <?php if(request('estado') === $key): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4 col-lg-2">
                    <label class="form-label mb-1"><i class="bi bi-calendar me-1"></i>Fecha desde</label>
                    <input type="date" name="fecha_desde" value="<?php echo e(request('fecha_desde')); ?>" class="form-control" max="<?php echo e(request('fecha_hasta')); ?>">
                </div>
                <div class="col-md-4 col-lg-2">
                    <label class="form-label mb-1"><i class="bi bi-calendar me-1"></i>Fecha hasta</label>
                    <input type="date" name="fecha_hasta" value="<?php echo e(request('fecha_hasta')); ?>" class="form-control" min="<?php echo e(request('fecha_desde')); ?>">
                </div>
                <div class="col-md-4 col-lg-1">
                    <label class="form-label mb-1"><i class="bi bi-currency-dollar me-1"></i>Total min</label>
                    <input type="number" name="total_min" value="<?php echo e(request('total_min')); ?>" class="form-control" min="0" step="1000">
                </div>
                <div class="col-md-4 col-lg-1">
                    <label class="form-label mb-1"><i class="bi bi-currency-dollar me-1"></i>Total max</label>
                    <input type="number" name="total_max" value="<?php echo e(request('total_max')); ?>" class="form-control" min="0" step="1000">
                </div>
                <div class="col-12 col-lg-1 d-grid">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-funnel me-1"></i>Filtrar</button>
                </div>
                <div class="col-12 col-lg-2 d-grid">
                    <a href="<?php echo e(route('admin.ventas.index')); ?>" class="btn btn-outline-secondary"><i class="bi bi-x-circle me-1"></i>Borrar filtros</a>
                </div>
            </form>
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
                        <?php $__empty_1 = true; $__currentLoopData = $ventas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($venta->id); ?></td>
                                <td><?php echo e($venta->usuario->nombre_completo ?? $venta->usuario->name ?? '-'); ?></td>
                                <td><?php echo e($venta->created_at->format('Y-m-d H:i')); ?></td>
                                <td class="fw-semibold">$<?php echo e(number_format($venta->total, 0, ',', '.')); ?></td>
                                <td>
                                    <form action="<?php echo e(route('admin.ventas.cambiarEstado', $venta)); ?>" method="POST" class="d-inline align-middle estado-form">
                                        <?php echo csrf_field(); ?>
                                        <?php ($estadoClase = $estadoClases[$venta->estado] ?? 'secondary'); ?>
                                        <div class="position-relative d-inline-block">
                                            <select name="estado" class="form-select form-select-sm estado-select fw-semibold text-capitalize bg-<?php echo e($estadoClase); ?> text-white border-0 px-2 py-1 pe-4 shadow-sm" onchange="this.form.submit()" style="min-width: 125px; cursor:pointer; transition: background 0.2s;">
                                                <?php $__currentLoopData = $estadoOpciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($key); ?>" <?php if($venta->estado === $key): ?> selected <?php endif; ?>><?php echo e($label); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <span class="estado-caret position-absolute end-0 top-50 translate-middle-y pe-2"><i class="bi bi-chevron-down"></i></span>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('admin.ventas.show', $venta)); ?>" class="btn btn-sm btn-primary px-3 shadow-sm">Ver</a>
                                    <a href="<?php echo e(route('admin.ventas.factura', $venta)); ?>?pdf=1" class="btn btn-sm btn-secondary px-3 shadow-sm ms-1"><i class="bi bi-file-earmark-arrow-down"></i> Descargar factura</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No hay ventas registradas.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('styles'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fechaDesde = document.querySelector('input[name="fecha_desde"]');
            const fechaHasta = document.querySelector('input[name="fecha_hasta"]');

            if (!fechaDesde || !fechaHasta) {
                return;
            }

            fechaDesde.addEventListener('change', function () {
                fechaHasta.min = fechaDesde.value || '';
            });

            fechaHasta.addEventListener('change', function () {
                fechaDesde.max = fechaHasta.value || '';
            });

            const form = fechaDesde.closest('form');
            if (!form) {
                return;
            }

            form.addEventListener('submit', function (e) {
                if (fechaDesde.value && fechaHasta.value && fechaHasta.value < fechaDesde.value) {
                    e.preventDefault();
                    alert('La fecha hasta no puede ser anterior a la fecha desde.');
                    fechaHasta.focus();
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\resources\views/admin/ventas/index.blade.php ENDPATH**/ ?>