<?php $__env->startSection('title', 'Editar Talla - Branyey'); ?>

<?php $__env->startSection('admin-content'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Editar Talla</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.tallas.update', $talla)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo e($talla->nombre); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="clasificacion_id" class="form-label">Clasificación</label>
                            <select name="clasificacion_id" id="clasificacion_id" class="form-select" required>
                                <option value="">Seleccione</option>
                                <?php $__currentLoopData = $clasificaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($clas->id); ?>" <?php echo e($talla->clasificacion_id == $clas->id ? 'selected' : ''); ?>><?php echo e($clas->nombre); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                            <a href="<?php echo e(route('admin.tallas.index')); ?>" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\resources\views/admin/tallas/edit.blade.php ENDPATH**/ ?>