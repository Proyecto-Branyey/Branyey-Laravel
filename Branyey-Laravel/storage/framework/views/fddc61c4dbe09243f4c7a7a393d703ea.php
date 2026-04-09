<?php $__env->startSection('admin-layout'); ?>
<div class="container-fluid">
    <div class="row">
        
        <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar vh-100 sticky-top shadow">
            <div class="position-sticky pt-3">
                <h5 class="text-white px-3 mb-4 italic fw-black text-center">MENÚ</h5>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white mb-2 <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard')); ?>">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo e(request()->routeIs('admin.ventas.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.ventas.index')); ?>">
                            <i class="bi bi-receipt me-2"></i> Ventas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex justify-content-between align-items-center <?php echo e(request()->routeIs('admin.productos.*') ? 'active' : ''); ?>" data-bs-toggle="collapse" href="#menuProductos" role="button" aria-expanded="<?php echo e(request()->routeIs('admin.productos.*') ? 'true' : 'false'); ?>">
                            <span><i class="bi bi-box-seam me-2"></i> Productos</span>
                            <i class="bi bi-chevron-down small"></i>
                        </a>
                        <div class="collapse <?php echo e(request()->routeIs('admin.productos.*') ? 'show' : ''); ?>" id="menuProductos">
                            <ul class="nav flex-column ms-3 mt-1">
                                <li class="nav-item">
                                    <a class="nav-link text-secondary py-1 <?php echo e(request()->routeIs('admin.productos.index') ? 'fw-bold' : ''); ?>" href="<?php echo e(route('admin.productos.index')); ?>">
                                        <i class="bi bi-list-ul me-2"></i> Ver Inventario
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-success py-1 <?php echo e(request()->routeIs('admin.productos.create') ? 'fw-bold' : ''); ?>" href="<?php echo e(route('admin.productos.create')); ?>">
                                        <i class="bi bi-plus-lg me-2"></i> Añadir Nuevo
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-danger py-1 <?php echo e(request()->routeIs('admin.productos.papelera') ? 'fw-bold' : ''); ?>" href="<?php echo e(route('admin.productos.papelera')); ?>">
                                        <i class="bi bi-trash3 me-2"></i> Papelera Productos
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-danger py-1 <?php echo e(request()->routeIs('admin.variantes.papelera') ? 'fw-bold' : ''); ?>" href="<?php echo e(route('admin.variantes.papelera')); ?>">
                                        <i class="bi bi-trash3 me-2"></i> Papelera Variantes
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex justify-content-between align-items-center <?php echo e(request()->routeIs('admin.usuarios.*') ? 'active' : ''); ?>" data-bs-toggle="collapse" href="#menuUsuarios" role="button" aria-expanded="<?php echo e(request()->routeIs('admin.usuarios.*') ? 'true' : 'false'); ?>">
                            <span><i class="bi bi-people me-2"></i> Usuarios</span>
                            <i class="bi bi-chevron-down small"></i>
                        </a>
                        <div class="collapse <?php echo e(request()->routeIs('admin.usuarios.*') ? 'show' : ''); ?>" id="menuUsuarios">
                            <ul class="nav flex-column ms-3 mt-1">
                                <li class="nav-item">
                                    <a class="nav-link text-secondary py-1 <?php echo e(request()->routeIs('admin.usuarios.index') ? 'fw-bold' : ''); ?>" href="<?php echo e(route('admin.usuarios.index')); ?>">
                                        <i class="bi bi-list-ul me-2"></i> Ver Usuarios
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-success py-1 <?php echo e(request()->routeIs('admin.usuarios.create') ? 'fw-bold' : ''); ?>" href="<?php echo e(route('admin.usuarios.create')); ?>">
                                        <i class="bi bi-plus-lg me-2"></i> Añadir Usuario
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex justify-content-between align-items-center <?php echo e(request()->routeIs('admin.tallas.*|admin.colores.*|admin.estilos-camisa.*') ? 'active' : ''); ?>" data-bs-toggle="collapse" href="#menuCatalogos" role="button" aria-expanded="<?php echo e(request()->routeIs('admin.tallas.*|admin.colores.*|admin.estilos-camisa.*') ? 'true' : 'false'); ?>">
                            <span><i class="bi bi-tags me-2"></i> Catálogos</span>
                            <i class="bi bi-chevron-down small"></i>
                        </a>
                        <div class="collapse <?php echo e(request()->routeIs('admin.tallas.*|admin.colores.*|admin.estilos-camisa.*') ? 'show' : ''); ?>" id="menuCatalogos">
                            <ul class="nav flex-column ms-3 mt-1">
                                <li class="nav-item">
                                    <a class="nav-link text-secondary py-1 <?php echo e(request()->routeIs('admin.tallas.index') ? 'fw-bold' : ''); ?>" href="<?php echo e(route('admin.tallas.index')); ?>">
                                        <i class="bi bi-rulers me-2"></i> Tallas
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-secondary py-1 <?php echo e(request()->routeIs('admin.colores.index') ? 'fw-bold' : ''); ?>" href="<?php echo e(route('admin.colores.index')); ?>">
                                        <i class="bi bi-palette me-2"></i> Colores
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-secondary py-1<?php echo e(request()->routeIs('admin.estilos-camisa.*') ? ' fw-bold active' : ''); ?>" href="<?php echo e(route('admin.estilos-camisa.index')); ?>">
                                        <i class="bi bi-brush me-2"></i> Estilos
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item mt-3">
                        <a class="nav-link text-white <?php echo e(request()->routeIs('admin.mail.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.mail.create')); ?>">
                            <i class="bi bi-envelope-paper me-2"></i> Correo masivo
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <?php echo $__env->yieldContent('admin-content'); ?>
        </main>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .sidebar {
            min-height: calc(100vh - 56px);
            background: linear-gradient(180deg, #0a0e27 0%, #111111 100%) !important;
        }
        
        .sidebar .nav-link {
            transition: 0.2s;
            padding: 10px 16px;
            border-radius: 10px;
            margin: 4px 12px;
            font-size: 0.85rem;
        }
        
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.08);
            color: #fff !important;
        }
        
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff !important;
        }
        
        .sidebar .nav-link.text-secondary {
            color: rgba(255,255,255,0.6) !important;
        }
        
        .sidebar .nav-link.text-secondary:hover {
            color: #fff !important;
        }
        
        .sidebar .nav-link.text-success {
            color: #10b981 !important;
        }
        
        .sidebar .nav-link.text-danger {
            color: #ef4444 !important;
        }
        
        /* Scrollbar personalizada para sidebar */
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.05);
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 4px;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin_base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\Branyey-Laravel\resources\views/layouts/admin.blade.php ENDPATH**/ ?>