

<?php $__env->startSection('title', 'Gestión de Tallas - Branyey'); ?>

<?php $__env->startSection('admin-content'); ?>
<div class="container py-4">
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-rulers me-2"></i>Gestión de Tallas</h2>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.tallas.papelera')); ?>" class="btn btn-outline-danger">
                <i class="bi bi-trash3 me-1"></i> Papelera
            </a>
            <a href="<?php echo e(route('admin.tallas.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Nueva Talla
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Clasificación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $tallas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $talla): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($talla->id); ?></td>
                                <td><?php echo e($talla->nombre); ?></td>
                                <td><?php echo e($talla->clasificacion?->nombre ?? 'Sin clasificación'); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.tallas.edit', $talla)); ?>" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                    <form action="<?php echo e(route('admin.tallas.destroy', $talla)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta talla?')">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center">No hay tallas registradas.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\resources\views/admin/tallas/index.blade.php ENDPATH**/ ?>