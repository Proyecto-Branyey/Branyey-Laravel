<?php $__env->startSection('title', $producto->nombre_comercial . ' - Admin'); ?>

<?php $__env->startSection('admin-content'); ?>
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-dark text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 fw-bold"><?php echo e($producto->nombre_comercial); ?></h3>
                        <a href="<?php echo e(route('admin.productos.index')); ?>" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left me-2"></i>Volver
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Información General -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted fw-bold small text-uppercase">Estilo</h6>
                            <p class="fw-bold"><?php echo e($producto->estilo?->nombre ?? 'N/A'); ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted fw-bold small text-uppercase">Clasificación de Talla</h6>
                            <p class="fw-bold"><?php echo e($producto->clasificacionTalla->nombre ?? 'N/A'); ?></p>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <?php if($producto->descripcion): ?>
                        <div class="mb-4">
                            <h6 class="text-muted fw-bold small text-uppercase">Descripción</h6>
                            <p><?php echo e($producto->descripcion); ?></p>
                        </div>
                    <?php endif; ?>

                    <!-- Imágenes -->
                    <div class="mb-4">
                        <h6 class="text-muted fw-bold small text-uppercase mb-3">Imágenes por Color</h6>
                        <?php if($producto->imagenes->count() > 0): ?>
                            <div class="row g-3">
                                <?php $__currentLoopData = $producto->imagenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imagen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-4">
                                        <div class="border rounded-3 p-2 bg-white h-100 shadow-sm">
                                            <img src="<?php echo e(Storage::url($imagen->url)); ?>" class="img-fluid rounded-3" alt="<?php echo e($producto->nombre_comercial); ?>">
                                            <div class="mt-2 d-flex justify-content-between align-items-center">
                                                <small class="fw-bold text-uppercase text-secondary">
                                                    Color: <?php echo e($imagen->color?->nombre ?? 'Sin color'); ?>

                                                </small>
                                                <?php if($imagen->es_principal): ?>
                                                    <span class="badge bg-dark">Principal</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning mb-0">
                                Este producto no tiene imágenes registradas.
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Variantes (Tallas + Colores) -->
                    <div class="mb-4">
                        <h6 class="text-muted fw-bold small text-uppercase mb-3">Variantes (Talla + Color + Imagen + Precio + Stock)</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Talla</th>
                                        <th>Color</th>
                                        <th>Imagen</th>
                                        <th>Precio Minorista</th>
                                        <th>Precio Mayorista</th>
                                        <th>Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $producto->variantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="fw-bold"><?php echo e($variante->talla?->nombre ?? 'Sin talla'); ?></td>
                                            <td>
                                                <?php if($variante->colores->count() > 0): ?>
                                                    <?php $__currentLoopData = $variante->colores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <span class="badge" style="background-color: <?php echo e($color->codigo_hex); ?>; color: <?php echo e($color->codigo_hex == '#ffffff' || $color->codigo_hex == '#fff' ? '#000' : '#fff'); ?>">
                                                            <?php echo e($color->nombre); ?>

                                                        </span>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Sin color</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($variante->colores->count() > 0): ?>
                                                    <?php
                                                        $imagenesColor = $variante->colores->map(function($color) use ($producto) {
                                                            return $producto->imagenes->firstWhere('color_id', $color->id);
                                                        })->filter();
                                                    ?>

                                                    <?php if($imagenesColor->count() > 0): ?>
                                                        <span class="badge bg-success">Con imagen</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Sin imagen</span>
                                                        <a href="<?php echo e(route('admin.productos.edit', $producto->id)); ?>" class="btn btn-sm btn-outline-primary ms-2">
                                                            Subir imagen
                                                        </a>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Sin imagen</span>
                                                    <a href="<?php echo e(route('admin.productos.edit', $producto->id)); ?>" class="btn btn-sm btn-outline-primary ms-2">
                                                        Subir imagen
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                            <td>$<?php echo e(number_format($variante->precio_minorista, 0, ',', '.')); ?> COP</td>
                                            <td>$<?php echo e(number_format($variante->precio_mayorista, 0, ',', '.')); ?> COP</td>
                                            <td>
                                                <?php if($variante->stock > 0): ?>
                                                    <span class="badge bg-success"><?php echo e($variante->stock); ?> unidades</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Agotado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="d-flex gap-2 justify-content-between border-top pt-4">
                        <div>
                            <a href="<?php echo e(route('admin.productos.edit', $producto->id)); ?>" class="btn btn-primary">
                                <i class="bi bi-pencil me-2"></i>Editar
                            </a>
                            <a href="<?php echo e(route('admin.productos.index')); ?>" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Volver
                            </a>
                        </div>
                        <form action="<?php echo e(route('admin.productos.destroy', $producto->id)); ?>" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este producto?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-2"></i>Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\resources\views/admin/productos/show.blade.php ENDPATH**/ ?>