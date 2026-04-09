<?php $__env->startSection('admin-content'); ?>
<div class="container-fluid px-0">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <i class="bi bi-box-seam-fill me-2"></i>Inventario
            </h1>
            <p class="text-muted small mb-0">Gestiona los productos y variantes de Branyey</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.productos.exportar.pdf', request()->query())); ?>" class="btn-export-pdf" target="_blank">
                <i class="bi bi-file-pdf me-1"></i> Exportar PDF
            </a>
            <a href="<?php echo e(route('admin.productos.papelera')); ?>" class="btn-action-outline">
                <i class="bi bi-trash3 me-1"></i> Papelera
            </a>
            <a href="<?php echo e(route('admin.variantes.papelera')); ?>" class="btn-action-outline">
                <i class="bi bi-layers me-1"></i> Variantes
            </a>
            <a href="<?php echo e(route('admin.productos.create')); ?>" class="btn-action-primary">
                <i class="bi bi-plus-lg me-1"></i> Nueva Prenda
            </a>
        </div>
    </div>

    
    <div class="filters-card mb-4">
        <form method="GET" action="<?php echo e(route('admin.productos.index')); ?>" id="filterForm">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="filter-label">
                        <i class="bi bi-search me-1"></i> Buscar
                    </label>
                    <input type="text" name="search" class="filter-input" 
                           placeholder="Nombre comercial o ID..." 
                           value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-3">
                    <label class="filter-label">
                        <i class="bi bi-tag me-1"></i> Estilo
                    </label>
                    <select name="estilo_id" class="filter-select">
                        <option value="">Todos los estilos</option>
                        <?php $__currentLoopData = $estilos ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estilo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($estilo->id); ?>" <?php echo e(request('estilo_id') == $estilo->id ? 'selected' : ''); ?>>
                                <?php echo e($estilo->nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="filter-label">
                        <i class="bi bi-toggle-on me-1"></i> Estado
                    </label>
                    <select name="estado" class="filter-select">
                        <option value="">Todos</option>
                        <option value="activo" <?php echo e(request('estado') == 'activo' ? 'selected' : ''); ?>>Activos</option>
                        <option value="inactivo" <?php echo e(request('estado') == 'inactivo' ? 'selected' : ''); ?>>Inactivos</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="d-flex flex-column gap-2">
                        <button type="submit" class="btn-filter-apply w-100">
                            <i class="bi bi-funnel me-1"></i> Filtrar
                        </button>
                        <div class="d-flex gap-2">
                            <?php if(request()->anyFilled(['search', 'estilo_id', 'estado'])): ?>
                                <a href="<?php echo e(route('admin.productos.index')); ?>" class="btn-filter-clear flex-grow-1 text-center">
                                    <i class="bi bi-x-circle me-1"></i> Limpiar
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    
    <?php if(session('success')): ?>
        <div class="alert-success-card mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert-error-card mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    
    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th class="col-image">Imagen</th>
                    <th class="col-product">Producto</th>
                    <th class="col-style">Estilo</th>
                    <th class="col-status">Estado</th>
                    <th class="col-actions">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="col-image">
                            <?php 
                                $img = $producto->imagenes->where('es_principal', true)->first() ?? $producto->imagenes->first();
                            ?>
                            <?php if($img): ?>
                                <img src="<?php echo e(Storage::url($img->url)); ?>" class="product-image" alt="<?php echo e($producto->nombre_comercial); ?>">
                            <?php else: ?>
                                <div class="product-image-placeholder">
                                    <i class="bi bi-image"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="col-product">
                            <div class="product-cell">
                                <div>
                                    <a href="<?php echo e(route('admin.productos.show', $producto->id)); ?>" class="product-title">
                                        <?php echo e($producto->nombre_comercial); ?>

                                    </a>
                                    <div class="product-id">ID: #<?php echo e($producto->id); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="col-style">
                            <span class="style-badge"><?php echo e($producto->estilo?->nombre ?? 'Sin estilo'); ?></span>
                        </td>
                        <td class="col-status">
                            <?php if($producto->activo): ?>
                                <span class="status-badge active">
                                    <i class="bi bi-check-circle-fill me-1"></i> Activo
                                </span>
                            <?php else: ?>
                                <span class="status-badge inactive">
                                    <i class="bi bi-x-circle-fill me-1"></i> Inactivo
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="col-actions">
                            <div class="action-buttons">
                                <a href="<?php echo e(route('admin.productos.edit', $producto->id)); ?>" class="action-btn edit" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <?php if(!$producto->activo): ?>
                                    <form action="<?php echo e(route('admin.productos.activar', $producto->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <button type="submit" class="action-btn restore" title="Reactivar">
                                            <i class="bi bi-arrow-repeat"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                                <form action="<?php echo e(route('admin.productos.destroy', $producto->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar este producto?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="action-btn delete" title="Eliminar">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="empty-state-cell">
                            <div class="empty-state">
                                <i class="bi bi-box-seam fs-1 text-muted"></i>
                                <p class="mt-3 mb-0">No se encontraron productos</p>
                                <small class="text-muted">Prueba con otros filtros o crea un nuevo producto</small>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <div class="pagination-wrapper mt-4">
        <?php echo e($productos->appends(request()->query())->links()); ?>

    </div>
</div>

<style>
/* ===== FILTROS ===== */
.filters-card {
    background: white;
    border-radius: 20px;
    padding: 1.25rem 1.5rem;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.filter-label {
    display: block;
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.filter-input, .filter-select {
    width: 100%;
    padding: 0.6rem 1rem;
    font-size: 0.85rem;
    border: 1.5px solid #e9ecef;
    border-radius: 12px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.filter-input:focus, .filter-select:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn-filter-apply {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.6rem 1.25rem;
    background: linear-gradient(135deg, #1a1a2e, #16213e);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-filter-apply:hover {
    background: linear-gradient(135deg, #667eea, #764ba2);
    transform: translateY(-1px);
}

.btn-filter-clear {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.6rem 1.25rem;
    background: transparent;
    color: #6c757d;
    border: 1.5px solid #e9ecef;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-filter-clear:hover {
    background: #f8f9fa;
    color: #dc3545;
    border-color: #dc3545;
}

/* ===== BOTONES PRINCIPALES ===== */
.btn-action-primary {
    display: inline-flex;
    align-items: center;
    padding: 0.6rem 1.25rem;
    background: linear-gradient(135deg, #1a1a2e, #16213e);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-action-primary:hover {
    background: linear-gradient(135deg, #667eea, #764ba2);
    transform: translateY(-1px);
    color: white;
}

.btn-action-outline {
    display: inline-flex;
    align-items: center;
    padding: 0.6rem 1.25rem;
    background: transparent;
    color: #6c757d;
    border: 1.5px solid #e9ecef;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-action-outline:hover {
    background: #f8f9fa;
    color: #dc3545;
    border-color: #dc3545;
}

.btn-export-pdf {
    display: inline-flex;
    align-items: center;
    padding: 0.6rem 1.25rem;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-export-pdf:hover {
    background: #bb2d3b;
    transform: translateY(-1px);
    color: white;
}

/* ===== ALERTAS ===== */
.alert-success-card, .alert-error-card {
    padding: 0.85rem 1rem;
    border-radius: 16px;
    font-size: 0.85rem;
    font-weight: 500;
    display: flex;
    align-items: center;
}

.alert-success-card {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
    border-left: 3px solid #10b981;
}

.alert-error-card {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    border-left: 3px solid #dc3545;
}

/* ===== TABLA ===== */
.table-container {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table th {
    padding: 1rem 1rem;
    text-align: left;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.admin-table td {
    padding: 1rem;
    border-bottom: 1px solid #f0f0f0;
    font-size: 0.85rem;
}

.admin-table tr:hover {
    background: #fafbfc;
}

/* Columnas específicas */
.col-image { width: 80px; }
.col-product { width: auto; }
.col-style { width: 120px; }
.col-status { width: 100px; }
.col-actions { width: 120px; }

/* Imagen producto */
.product-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.product-image-placeholder {
    width: 60px;
    height: 60px;
    background: #f8f9fa;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #adb5bd;
    border: 1px solid #e9ecef;
}

.product-image-placeholder i {
    font-size: 1.5rem;
}

/* Product cell */
.product-cell {
    display: flex;
    flex-direction: column;
}

.product-title {
    font-weight: 700;
    color: #1a1a2e;
    text-decoration: none;
    transition: color 0.2s ease;
}

.product-title:hover {
    color: #667eea;
}

.product-id {
    font-size: 0.7rem;
    color: #6c757d;
    margin-top: 4px;
}

/* Style badge */
.style-badge {
    display: inline-block;
    padding: 4px 10px;
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
}

/* Status badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
}

.status-badge.active {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.status-badge.inactive {
    background: rgba(108, 117, 125, 0.1);
    color: #6c757d;
}

/* Action buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.action-btn {
    width: 32px;
    height: 32px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.action-btn.edit {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
}

.action-btn.edit:hover {
    background: #667eea;
    color: white;
    transform: translateY(-2px);
}

.action-btn.delete {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.action-btn.delete:hover {
    background: #dc3545;
    color: white;
    transform: translateY(-2px);
}

.action-btn.restore {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.action-btn.restore:hover {
    background: #10b981;
    color: white;
    transform: translateY(-2px);
}

/* Empty state */
.empty-state-cell {
    text-align: center !important;
    padding: 3rem !important;
}

.empty-state {
    text-align: center;
    padding: 2rem;
    color: #6c757d;
}

.empty-state i {
    font-size: 3rem;
    opacity: 0.5;
}

/* Paginación */
.pagination-wrapper {
    display: flex;
    justify-content: center;
}

.pagination-wrapper .pagination {
    margin-bottom: 0;
}

/* Responsive */
@media (max-width: 992px) {
    .admin-table {
        display: block;
        overflow-x: auto;
    }
    
    .col-image, .col-product, .col-style, .col-status, .col-actions {
        min-width: 100px;
    }
}

@media (max-width: 768px) {
    .filters-card .row > div {
        margin-bottom: 0.75rem;
    }
    
    .btn-filter-apply, .btn-filter-clear {
        width: 100%;
        justify-content: center;
    }
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\Branyey-Laravel\resources\views/admin/productos/index.blade.php ENDPATH**/ ?>