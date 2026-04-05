
<?php $__env->startSection('title', 'Registrar Venta'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h1 class="h3 mb-4">Registrar Nueva Venta</h1>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="<?php echo e(route('admin.ventas.store')); ?>">
                <?php echo csrf_field(); ?>
                
                <div class="mb-3">
                    <label for="cliente_id" class="form-label">Cliente</label>
                    <select class="form-select" id="cliente_id" name="cliente_id">
                        
                    </select>
                </div>
                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control" id="fecha" name="fecha">
                </div>
                <div class="mb-3">
                    <label for="total" class="form-label">Total</label>
                    <input type="number" step="0.01" class="form-control" id="total" name="total">
                </div>
                <button type="submit" class="btn btn-success">Guardar Venta</button>
                <a href="<?php echo e(route('admin.ventas.index')); ?>" class="btn btn-secondary ms-2">Cancelar</a>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\resources\views/admin/ventas/create.blade.php ENDPATH**/ ?>