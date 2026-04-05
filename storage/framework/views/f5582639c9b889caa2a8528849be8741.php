<?php $__env->startSection('title', 'Catálogo Completo - Branyey'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row">
        
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm p-4 sticky-top" style="top: 100px; border-radius: 15px;">
                <h5 class="fw-bold mb-4 italic">FILTRAR</h5>
                <form action="<?php echo e(route('tienda.catalogo')); ?>" method="GET">
                    
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase text-muted">Estilo de Prenda</label>
                        <div class="list-group list-group-flush rounded-3 overflow-hidden shadow-sm">
                            <label class="list-group-item list-group-item-action border-0 <?php echo e(!request('estilo_id') ? 'active bg-dark text-white' : ''); ?> cursor-pointer">
                                <input type="radio" name="estilo_id" value="" class="d-none" onchange="this.form.submit()" <?php echo e(!request('estilo_id') ? 'checked' : ''); ?>>
                                Todos los estilos
                            </label>
                            <?php $__currentLoopData = $estilos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estilo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="list-group-item list-group-item-action border-0 <?php echo e(request('estilo_id') == $estilo->id ? 'active bg-dark text-white' : ''); ?> cursor-pointer">
                                    <input type="radio" name="estilo_id" value="<?php echo e($estilo->id); ?>" class="d-none" onchange="this.form.submit()" <?php echo e(request('estilo_id') == $estilo->id ? 'checked' : ''); ?>>
                                    <?php echo e($estilo->nombre); ?>

                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase text-muted">Categoría</label>
                        <div class="list-group list-group-flush rounded-3 overflow-hidden shadow-sm">
                            <label class="list-group-item list-group-item-action border-0 <?php echo e(!request('clasificacion_id') ? 'active bg-dark text-white' : ''); ?> cursor-pointer">
                                <input type="radio" name="clasificacion_id" value="" class="d-none" onchange="this.form.submit()" <?php echo e(!request('clasificacion_id') ? 'checked' : ''); ?>>
                                Todas las categorías
                            </label>
                            <?php $__currentLoopData = $clasificaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clasif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="list-group-item list-group-item-action border-0 <?php echo e(request('clasificacion_id') == $clasif->id ? 'active bg-dark text-white' : ''); ?> cursor-pointer">
                                    <input type="radio" name="clasificacion_id" value="<?php echo e($clasif->id); ?>" class="d-none" onchange="this.form.submit()" <?php echo e(request('clasificacion_id') == $clasif->id ? 'checked' : ''); ?>>
                                    <?php echo e($clasif->nombre); ?>

                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <?php if(request()->anyFilled(['estilo_id', 'clasificacion_id'])): ?>
                        <a href="<?php echo e(route('tienda.catalogo')); ?>" class="btn btn-link btn-sm text-decoration-none text-danger p-0 fw-bold mt-2">
                            × LIMPIAR FILTROS
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0 italic text-uppercase">Colección <span class="text-muted">/ Branyey</span></h2>
                <p class="text-muted mb-0 small fw-bold uppercase">Items: <?php echo e($productos->total()); ?></p>
            </div>

            <div class="row g-4">
                <?php $__empty_1 = true; $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm product-hover" style="border-radius: 20px; overflow: hidden;">
                            <div class="position-relative overflow-hidden" style="height: 380px; background-color: #f8f9fa;">
                                <a href="<?php echo e(route('tienda.producto.detalle', $producto->id)); ?>">
                                    <?php $img = $producto->imagenes->first(); ?>
                                    <?php if($img): ?>
                                        <img src="<?php echo e(Storage::url($img->url)); ?>" class="w-100 h-100 img-zoom" style="object-fit: cover; object-position: top;" alt="<?php echo e($producto->nombre_comercial); ?>">
                                    <?php else: ?>
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted small fw-bold italic" style="background: #eee;">NO IMAGE</div>
                                    <?php endif; ?>
                                </a>
                            </div>

                            <div class="card-body text-center">
                                <span class="text-uppercase text-muted fw-bold mb-1 d-block small" style="letter-spacing: 2px;">
                                    <?php echo e($producto->estilo?->nombre ?? 'Colección'); ?>

                                </span>
                                <h6 class="card-title fw-bold text-dark text-uppercase mb-3"><?php echo e($producto->nombre_comercial); ?></h6>
                                <h5 class="fw-bold text-dark mb-3">
                                    <?php
                                        $precios = $producto->variantes->map(function($v) {
                                            return $v->getPrecioActual();
                                        });
                                        $minPrecio = $precios->min();
                                        $maxPrecio = $precios->max();
                                    ?>
                                    $<?php echo e(number_format($minPrecio, 0, ',', '.')); ?> COP
                                    <?php if($minPrecio != $maxPrecio): ?>
                                        - $<?php echo e(number_format($maxPrecio, 0, ',', '.')); ?> COP
                                    <?php endif; ?>
                                </h5>
                                <a href="<?php echo e(route('tienda.producto.detalle', $producto->id)); ?>" class="btn btn-dark w-100 rounded-pill py-2 fw-bold text-uppercase small">
                                    Ver Pieza
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12 text-center py-5">
                        <div class="py-5 border border-2 border-dashed rounded-5">
                            <h4 class="text-muted fw-bold italic mb-0">Sin resultados</h4>
                            <p class="text-muted small uppercase mt-2">Aún no existe este producto.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mt-5 d-flex justify-content-center">
                <?php echo e($productos->appends(request()->query())->links()); ?>

            </div>
        </div>
    </div>
</div>

<style>
.cursor-pointer { cursor: pointer; }
.product-hover { transition: transform 0.3s ease; }
.product-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
.img-zoom { transition: transform 0.5s ease; }
.product-hover:hover .img-zoom { transform: scale(1.05); }
.italic { font-style: italic; }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\resources\views/tienda/catalogo.blade.php ENDPATH**/ ?>