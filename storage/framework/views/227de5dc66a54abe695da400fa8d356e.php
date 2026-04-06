

<?php $__env->startSection('title', 'Nuevo Color - Branyey'); ?>

<?php $__env->startSection('admin-content'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Nuevo Color</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.colores.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="codigo_hex" class="form-label">Código Hex</label>
                            <input type="color" name="codigo_hex" id="codigo_hex" class="form-control form-control-color" value="#000000">
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="<?php echo e(route('admin.colores.index')); ?>" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\resources\views/admin/colores/create.blade.php ENDPATH**/ ?>