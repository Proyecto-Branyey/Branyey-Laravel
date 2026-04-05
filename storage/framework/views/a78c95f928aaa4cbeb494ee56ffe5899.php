<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-stack me-2"></i>Inventario de Branyey</h2>
        <a href="<?php echo e(route('admin.productos.create')); ?>" class="btn btn-dark shadow-sm">
            <i class="bi bi-plus-lg me-2"></i>Nueva Prenda
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 p-3 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                <div>
                    <strong>¡Hecho!</strong> <?php echo e(session('success')); ?>

                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Imagen Principal</th>
                        <th>Producto</th>
                        <th>Estilo</th>
                        <th>Estado</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="ps-4">
                            <?php $img = $producto->imagenes->where('es_principal', true)->first(); ?>
                            <?php if($img): ?>
                                <img src="<?php echo e(asset('storage/' . $img->url)); ?>" class="rounded-3 shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo e(route('admin.productos.show', $producto->id)); ?>" class="d-block p-2 rounded-2 fw-bold text-dark text-decoration-none hover-bg-light position-relative" style="transition:background 0.2s;">
                                <?php echo e($producto->nombre_comercial); ?>

                                <small class="text-muted d-block fw-normal" style="font-size: 0.85em;">ID: #<?php echo e($producto->id); ?></small>
                                <span class="stretched-link"></span>
                            </a>
                        </td>
                        <td><span class="badge bg-secondary-subtle text-secondary border"><?php echo e($producto->estilo?->nombre ?? 'Sin estilo'); ?></span></td>
                        <td>
                            <?php if($producto->activo): ?>
                                <span class="badge bg-success-subtle text-success">Activo</span>
                            <?php else: ?>
                                <span class="badge bg-danger-subtle text-danger">Inactivo</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group shadow-sm">
                                <a href="<?php echo e(route('admin.productos.edit', $producto->id)); ?>" class="btn btn-sm btn-white border" title="Editar producto"><i class="bi bi-pencil"></i></a>
                                <form action="<?php echo e(route('admin.productos.destroy', $producto->id)); ?>" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este producto?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-white border text-danger" title="Eliminar producto"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">No hay productos registrados aún.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\resources\views/admin/productos/index.blade.php ENDPATH**/ ?>