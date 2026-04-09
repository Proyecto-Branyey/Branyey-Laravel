<?php $__env->startSection('title', 'Gestión de Tallas - Branyey'); ?>

<?php $__env->startSection('admin-content'); ?>
<div class="container py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1 text-dark">
                <i class="bi bi-rulers me-2 text-secondary"></i>Gestión de Tallas
            </h1>
            <p class="text-muted small mb-0">Administra las tallas disponibles en el catálogo</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.tallas.papelera')); ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-trash3 me-1"></i> Papelera
            </a>
            <a href="<?php echo e(route('admin.tallas.create')); ?>" class="btn btn-dark btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Nueva Talla
            </a>
            <!-- Botón Importar -->
            <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#importarTallasForm" aria-expanded="false" aria-controls="importarTallasForm">
                <i class="bi bi-upload me-1"></i> Importar Tallas
            </button>
        </div>
    </div>

    <!-- Formulario de importación (colapsable) -->
    <div class="collapse mb-3" id="importarTallasForm">
        <form action="<?php echo e(route('admin.importar.excel')); ?>" method="POST" enctype="multipart/form-data" class="card card-body border-0 shadow-sm gap-2">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="tabla" value="tallas">
            <div class="mb-2">
                <label for="archivoTallas" class="form-label">Archivo Excel (.xlsx) de tallas</label>
                <input type="file" name="file" id="archivoTallas" class="form-control" accept=".xlsx" required>
            </div>
            <button type="submit" class="btn btn-success btn-sm">
                <i class="bi bi-cloud-arrow-up me-1"></i> Cargar archivo
            </button>
        </form>
    </div>
    </div>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3 p-3 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3 p-3 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small text-uppercase fw-semibold">Listado de tallas</span>
                <span class="badge bg-secondary bg-opacity-10 text-secondary"><?php echo e($tallas->count()); ?> registros</span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 80px;">ID</th>
                        <th>Talla</th>
                        <th>Clasificación</th>
                        <th class="text-end pe-4" style="width: 120px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $tallas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $talla): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4 text-muted">#<?php echo e($talla->id); ?></td>
                            <td class="fw-semibold"><?php echo e($talla->nombre); ?></td>
                            <td>
                                <span class="badge bg-light text-secondary border"><?php echo e($talla->clasificacion?->nombre ?? 'Sin clasificación'); ?></span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="<?php echo e(route('admin.tallas.edit', $talla)); ?>" class="btn btn-sm btn-outline-secondary" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.tallas.destroy', $talla)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar esta talla? Se moverá a la papelera.')" title="Eliminar">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                No hay tallas registradas
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\Branyey-Laravel\resources\views/admin/tallas/index.blade.php ENDPATH**/ ?>