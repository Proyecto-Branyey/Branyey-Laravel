<?php $__env->startSection('admin-content'); ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-trash3 me-2"></i>Papelera de Variantes</h2>
        <a href="<?php echo e(route('admin.productos.index')); ?>" class="btn btn-outline-dark shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Volver a Inventario
        </a>
    </div>

    <?php if($errors->has('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm rounded-4 p-3 mb-4">
            <?php echo e($errors->first('error')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 p-3 mb-4" role="alert">
            <strong>¡Hecho!</strong> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">SKU</th>
                        <th>Producto</th>
                        <th>Talla</th>
                        <th>Estado</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $variantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $productoBloqueado = !$variante->producto || !$variante->producto->activo || $variante->producto->trashed();
                        ?>
                        <tr>
                            <td class="ps-4 fw-bold"><?php echo e($variante->sku); ?></td>
                            <td><?php echo e($variante->producto?->nombre_comercial ?? 'Producto no disponible'); ?></td>
                            <td><?php echo e($variante->talla?->nombre ?? 'N/A'); ?></td>
                            <td><span class="badge bg-danger-subtle text-danger">En papelera</span></td>
                            <td class="text-end pe-4">
                                <?php if($productoBloqueado): ?>
                                    <span class="badge bg-secondary">Reactivar producto completo primero</span>
                                <?php else: ?>
                                    <form action="<?php echo e(route('admin.variantes.activar', $variante->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <button class="btn btn-sm btn-success" title="Reactivar variante">
                                            <i class="bi bi-arrow-repeat"></i> Reactivar
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No hay variantes en la papelera.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\resources\views/admin/variantes/papelera.blade.php ENDPATH**/ ?>