

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3"><?php echo e($estilo->nombre); ?></h1>
                <div>
                    <a href="<?php echo e(route('admin.estilos-camisa.edit', $estilo->id)); ?>" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Editar
                    </a>
                    <a href="<?php echo e(route('admin.estilos-camisa.index')); ?>" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="text-muted">Información del Estilo</h5>
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Nombre:</strong></td>
                            <td><?php echo e($estilo->nombre); ?></td>
                        </tr>
                        <tr>
                            <td><strong>ID:</strong></td>
                            <td><?php echo e($estilo->id); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Creado:</strong></td>
                            <td><?php echo e($estilo->created_at->format('d/m/Y H:i')); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Actualizado:</strong></td>
                            <td><?php echo e($estilo->updated_at->format('d/m/Y H:i')); ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <?php if($estilo->productos->count() > 0): ?>
                <h5 class="text-muted mt-4">Productos con este Estilo (<?php echo e($estilo->productos->count()); ?>)</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $estilo->productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($producto->id); ?></td>
                                    <td><?php echo e($producto->nombre); ?></td>
                                    <td><?php echo e(Str::limit($producto->descripcion, 50)); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.productos.show', $producto->id)); ?>" class="btn btn-primary btn-sm">
                                            <i class="bi bi-eye"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info mt-4">
                    <i class="bi bi-info-circle"></i> No hay productos con este estilo.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\resources\views/admin/estilos-camisa/show.blade.php ENDPATH**/ ?>