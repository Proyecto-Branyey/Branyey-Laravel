<?php $__env->startSection('title', 'Catálogo Completo - Branyey'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row g-4">
        
        <div class="col-lg-3">
            <div class="filters-card">
                <div class="filters-header">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-funnel-fill me-2"></i>FILTRAR
                    </h5>
                    <?php if(request()->anyFilled(['estilo_id', 'clasificacion_id'])): ?>
                        <a href="<?php echo e(route('tienda.catalogo')); ?>" class="btn-clear-filters">
                            <i class="bi bi-x-circle me-1"></i>Limpiar
                        </a>
                    <?php endif; ?>
                </div>
                
                <form action="<?php echo e(route('tienda.catalogo')); ?>" method="GET" id="filterForm">
                    
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="bi bi-tag me-2"></i>Estilo de Prenda
                        </label>
                        <div class="filter-options">
                            <button type="button" 
                                    class="filter-option <?php echo e(!request('estilo_id') ? 'active' : ''); ?>"
                                    onclick="submitFilter('estilo_id', '')">
                                Todos
                            </button>
                            <?php $__currentLoopData = $estilos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estilo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button type="button" 
                                        class="filter-option <?php echo e(request('estilo_id') == $estilo->id ? 'active' : ''); ?>"
                                        onclick="submitFilter('estilo_id', '<?php echo e($estilo->id); ?>')">
                                    <?php echo e($estilo->nombre); ?>

                                </button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="bi bi-person-standing me-2"></i>Categoría
                        </label>
                        <div class="filter-options">
                            <button type="button" 
                                    class="filter-option <?php echo e(!request('clasificacion_id') ? 'active' : ''); ?>"
                                    onclick="submitFilter('clasificacion_id', '')">
                                Todas
                            </button>
                            <?php $__currentLoopData = $clasificaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clasif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button type="button" 
                                        class="filter-option <?php echo e(request('clasificacion_id') == $clasif->id ? 'active' : ''); ?>"
                                        onclick="submitFilter('clasificacion_id', '<?php echo e($clasif->id); ?>')">
                                    <?php echo e($clasif->nombre); ?>

                                </button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    
                    <input type="hidden" name="estilo_id" id="estilo_id" value="<?php echo e(request('estilo_id')); ?>">
                    <input type="hidden" name="clasificacion_id" id="clasificacion_id" value="<?php echo e(request('clasificacion_id')); ?>">
                </form>
            </div>
        </div>

        
        <div class="col-lg-9">
            <div class="catalog-header">
                <div>
                    <h2 class="fw-bold mb-1">
                        Colección <span class="text-gradient">/ Branyey</span>
                    </h2>
                    <p class="text-muted small mb-0">
                        <i class="bi bi-grid-3x3-gap-fill me-1"></i><?php echo e($productos->total()); ?> productos encontrados
                    </p>
                </div>
            </div>

            <div class="row g-4 mt-1">
                <?php $__empty_1 = true; $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-sm-6 col-xl-4">
                        <div class="product-card-catalog">
                            <div class="product-image-catalog">
                                <a href="<?php echo e(route('tienda.producto.detalle', $producto->id)); ?>">
                                    <?php $img = $producto->imagenes->first(); ?>
                                    <?php if($img): ?>
                                        <img src="<?php echo e(Storage::url($img->url)); ?>" alt="<?php echo e($producto->nombre_comercial); ?>">
                                    <?php else: ?>
                                        <div class="no-image-placeholder">
                                            <i class="bi bi-image fs-1"></i>
                                            <span>Sin imagen</span>
                                        </div>
                                    <?php endif; ?>
                                </a>
                                <?php if($producto->variantes->sum('stock') > 0): ?>
                                    <span class="stock-badge-catalog">Disponible</span>
                                <?php else: ?>
                                    <span class="stock-badge-catalog out">Agotado</span>
                                <?php endif; ?>
                            </div>
                            <div class="product-info-catalog">
                                <span class="product-category-catalog">
                                    <?php echo e($producto->estilo?->nombre ?? 'Premium'); ?>

                                </span>
                                <h6 class="product-title-catalog">
                                    <?php echo e(Str::limit($producto->nombre_comercial, 40)); ?>

                                </h6>
                                <div class="product-price-catalog">
                                    <?php
                                        $precios = $producto->variantes->map(function($v) {
                                            return $v->getPrecioActual();
                                        });
                                        $minPrecio = $precios->min();
                                        $maxPrecio = $precios->max();
                                    ?>
                                    <span class="current-price-catalog">
                                        $<?php echo e(number_format($minPrecio, 0, ',', '.')); ?>

                                    </span>
                                    <?php if($minPrecio != $maxPrecio): ?>
                                        <span class="price-range">- $<?php echo e(number_format($maxPrecio, 0, ',', '.')); ?></span>
                                    <?php endif; ?>
                                </div>
                                <a href="<?php echo e(route('tienda.producto.detalle', $producto->id)); ?>" class="btn-catalog-detail">
                                    Ver detalles <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="bi bi-emoji-frown fs-1 mb-3 d-block"></i>
                            <h4 class="fw-bold mb-2">No encontramos productos</h4>
                            <p class="text-muted mb-4">Intenta con otros filtros o revisa luego nuestra colección</p>
                            <a href="<?php echo e(route('tienda.catalogo')); ?>" class="btn btn-dark rounded-pill px-4">
                                Ver todos los productos
                            </a>
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
/* ===== FILTROS MEJORADOS ===== */
.filters-card {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(0, 0, 0, 0.05);
    position: sticky;
    top: 90px;
    transition: all 0.3s ease;
}

.filters-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f0f0f0;
}

.filters-header h5 {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.btn-clear-filters {
    font-size: 0.75rem;
    color: #dc3545;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-clear-filters:hover {
    color: #bb2d3b;
    transform: translateX(-2px);
}

.filter-group {
    margin-bottom: 1.5rem;
}

.filter-label {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 700;
    color: #6c757d;
    display: block;
    margin-bottom: 0.75rem;
}

.filter-options {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.filter-option {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    color: #495057;
    padding: 0.4rem 1rem;
    border-radius: 30px;
    font-size: 0.75rem;
    font-weight: 500;
    transition: all 0.3s ease;
    cursor: pointer;
}

.filter-option:hover {
    background: #e9ecef;
    transform: translateY(-1px);
}

.filter-option.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: transparent;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
}

/* ===== CATALOG HEADER ===== */
.catalog-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f0f0f0;
}

.text-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* ===== PRODUCT CARDS CATALOG ===== */
.product-card-catalog {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(0, 0, 0, 0.05);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.product-card-catalog:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(102, 126, 234, 0.12);
    border-color: rgba(102, 126, 234, 0.2);
}

.product-image-catalog {
    position: relative;
    aspect-ratio: 3/4;
    overflow: hidden;
    background: linear-gradient(135deg, #f5f7fa 0%, #f0f2f5 100%);
}

.product-image-catalog img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.product-card-catalog:hover .product-image-catalog img {
    transform: scale(1.05);
}

.no-image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #adb5bd;
    background: #f8f9fa;
}

.stock-badge-catalog {
    position: absolute;
    bottom: 12px;
    left: 12px;
    background: #10b981;
    color: white;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.65rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    z-index: 2;
}

.stock-badge-catalog.out {
    background: #6c757d;
}

.product-info-catalog {
    padding: 1rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.product-category-catalog {
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #667eea;
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: inline-block;
}

.product-title-catalog {
    font-size: 0.85rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 0.75rem;
    line-height: 1.4;
    flex: 1;
}

.product-price-catalog {
    margin-bottom: 0.75rem;
}

.current-price-catalog {
    font-size: 1rem;
    font-weight: 800;
    color: #1a1a2e;
    letter-spacing: -0.5px;
}

.price-range {
    font-size: 0.8rem;
    color: #6c757d;
    font-weight: 500;
}

.btn-catalog-detail {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    background: #f8f9fa;
    color: #1a1a2e;
    text-decoration: none;
    padding: 0.5rem;
    border-radius: 30px;
    font-size: 0.7rem;
    font-weight: 600;
    transition: all 0.3s ease;
    width: 100%;
    border: 1px solid #e9ecef;
}

.btn-catalog-detail:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    gap: 0.75rem;
    border-color: transparent;
}

/* ===== EMPTY STATE ===== */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 20px;
    border: 2px dashed #e9ecef;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .filters-card {
        position: relative;
        top: 0;
        margin-bottom: 1rem;
    }
    
    .filter-options {
        gap: 0.4rem;
    }
    
    .filter-option {
        padding: 0.3rem 0.8rem;
        font-size: 0.7rem;
    }
    
    .catalog-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
}

@media (max-width: 576px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}
</style>

<script>
function submitFilter(field, value) {
    document.getElementById(field).value = value;
    document.getElementById('filterForm').submit();
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\Branyey-Laravel\resources\views/tienda/catalogo.blade.php ENDPATH**/ ?>