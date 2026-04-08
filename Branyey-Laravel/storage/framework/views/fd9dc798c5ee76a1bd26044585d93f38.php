<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Branyey - <?php echo $__env->yieldContent('title', 'Tienda de Ropa Urbana'); ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root { --primary-black: #111111; }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1 0 auto;
        }

        .fw-black { font-weight: 900; }
        .italic { font-style: italic; }
        
        .navbar {
            background: linear-gradient(135deg, #0a0e27 0%, #111111 100%) !important;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .navbar-brand {
            font-weight: 900;
            letter-spacing: -1px;
            font-size: 1.8rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .nav-link {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            color: rgba(255, 255, 255, 0.8) !important;
        }
        .nav-link:hover {
            color: #667eea !important;
        }
        .nav-link.active {
            color: #667eea !important;
        }
        
        .nav-role-badge {
            font-size: 0.65rem;
            text-transform: uppercase;
            padding: 3px 8px;
            border-radius: 50px;
            font-weight: 700;
            margin-left: 5px;
        }

        /* Botones en navbar */
        .navbar .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .navbar .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4) !important;
        }

        .fw-600 {
            font-weight: 600 !important;
        }

        footer {
            background: var(--primary-black);
            color: rgba(255,255,255,0.6);
            padding: 40px 0;
            flex-shrink: 0;
            margin-top: auto;
        }

        /* Efectos para redes sociales en footer */
        footer a[href*="instagram"]:hover i {
            color: #E4405F;
            transform: translateY(-3px);
        }

        footer a i {
            transition: all 0.3s ease;
            display: inline-block;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(auth()->check() && auth()->user()?->rol?->nombre === 'administrador' ? route('admin.dashboard') : route('tienda.inicio')); ?>">BRANYEY</a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <?php if(request()->routeIs('admin.*')): ?>
                        <?php if(auth()->guard()->check()): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active fw-bold' : ''); ?>" href="<?php echo e(route('admin.dashboard')); ?>">Panel Admin</a>
                            </li>
                            <li class="nav-item ms-lg-3">
                                <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="nav-link btn btn-link text-danger p-0">Cerrar Sesión</button>
                                </form>
                            </li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('tienda.inicio') ? 'active fw-bold' : ''); ?>" href="<?php echo e(route('tienda.inicio')); ?>">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('tienda.catalogo') ? 'active fw-bold' : ''); ?>" href="<?php echo e(route('tienda.catalogo')); ?>">Catálogo</a>
                        </li>

                        <?php if(auth()->guard()->check()): ?>
                            <li class="nav-item dropdown ms-lg-3">
                                <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle me-2 fs-5"></i>
                                    <?php echo e(Auth::user()->username); ?>

                                    <span class="badge bg-primary nav-role-badge">
                                        <?php echo e(Auth::user()?->rol?->nombre ?? 'Cliente'); ?>

                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                    <?php if(Auth::user()?->rol?->nombre === 'administrador'): ?>
                                        <li><a class="dropdown-item fw-bold text-primary" href="<?php echo e(route('admin.dashboard')); ?>">Panel Admin</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                    <?php else: ?>
                                        <li><a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">Mi Perfil</a></li>
                                        <li><a class="dropdown-item" href="<?php echo e(route('tienda.pedidos')); ?>">Mis Pedidos</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                    <?php endif; ?>
                                    <li>
                                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="dropdown-item text-danger">Cerrar Sesión</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="nav-item ms-lg-3">
                                <a class="nav-link" href="<?php echo e(route('login')); ?>">Iniciar Sesión</a>
                            </li>
                            <li class="nav-item ms-lg-2">
                                <a class="btn btn-primary btn-sm rounded-pill px-4 fw-600" href="<?php echo e(route('register')); ?>">Registrarse</a>
                            </li>
                        <?php endif; ?>

                        <?php if(!auth()->check() || auth()->user()?->rol?->nombre !== 'administrador'): ?>
                            <li class="nav-item ms-lg-4">
                                <a class="btn btn-light position-relative rounded-pill px-3 d-flex align-items-center" href="<?php echo e(route('tienda.cart.index')); ?>">
                                    <i class="bi bi-bag-fill me-2"></i>
                                    <span class="d-none d-lg-inline small fw-bold">CARRITO</span>
                                    <?php $count = session('cart') ? count(session('cart')) : 0; ?>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-2 border-white" style="font-size: 0.7rem;">
                                        <?php echo e($count); ?>

                                    </span>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php if(session('success') || session('error')): ?>
        <div class="container mt-4">
            <?php if(session('success')): ?>
                <div class="alert alert-dark alert-dismissible fade show border-0 shadow-sm rounded-4 px-4 py-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                        <div><strong>¡Éxito!</strong> <?php echo e(session('success')); ?></div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 px-4 py-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                        <div><strong>Atención:</strong> <?php echo e(session('error')); ?></div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="text-center">
        <div class="container">
            <h5 class="fw-black text-white mb-2" style="letter-spacing: 2px;">BRANYEY</h5>
            <p class="small text-white-50 mb-4" style="letter-spacing: 1px; font-style: italic;">
                "Elegancia que se siente, calidad que se vive"
            </p>
            <div class="d-flex justify-content-center align-items-center gap-3 mb-4">
                <div class="flex-grow-1" style="height: 1px; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);"></div>
                
                <div class="d-flex gap-3">
                    <a href="https://www.instagram.com/branyey/" target="_blank" rel="noopener noreferrer"
                       class="text-white-50 text-decoration-none"
                       style="transition: all 0.3s ease;">
                        <i class="bi bi-instagram fs-5"></i>
                    </a>
                    <i class="bi bi-gem text-white-50" style="font-size: 0.9rem;"></i>
                </div>
                
                <div class="flex-grow-1" style="height: 1px; background: linear-gradient(90deg, rgba(255,255,255,0.2), transparent);"></div>
            </div>
            
            <div class="row justify-content-center mb-4">
                <div class="col-md-4 mb-3 mb-md-0">
                    <p class="small mb-1 text-white-50">
                        <i class="bi bi-geo-alt-fill me-2"></i>Bogotá, Colombia
                    </p>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <p class="small mb-1 text-white-50">
                        <i class="bi bi-envelope-fill me-2"></i>info@branyey.com
                    </p>
                </div>
                <div class="col-md-4">
                    <p class="small mb-1 text-white-50">
                        <i class="bi bi-clock-fill me-2"></i>Lun - Vie: 9am a 6pm
                    </p>
                </div>
            </div>
            
            <div class="mb-4">
                <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
                        class="btn btn-link text-white-50 text-decoration-none small d-inline-flex align-items-center gap-2"
                        style="transition: all 0.3s ease;">
                    <i class="bi bi-arrow-up-circle fs-5"></i>
                    Volver arriba
                </button>
            </div>
            
            <div class="border-top border-secondary pt-4" style="border-color: rgba(255,255,255,0.1) !important;">
                <p class="small mb-0 text-white-50">© 2026 Branyey - Hecho con pasión en Colombia</p>
            </div>
        </div>
    </footer>

    <!-- Componente de WhatsApp (solo se mostrará en las rutas configuradas) -->
    <?php if (isset($component)) { $__componentOriginal4378b2eccec4e8470841be6441e66765 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4378b2eccec4e8470841be6441e66765 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.whatsapp-button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('whatsapp-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4378b2eccec4e8470841be6441e66765)): ?>
<?php $attributes = $__attributesOriginal4378b2eccec4e8470841be6441e66765; ?>
<?php unset($__attributesOriginal4378b2eccec4e8470841be6441e66765); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4378b2eccec4e8470841be6441e66765)): ?>
<?php $component = $__componentOriginal4378b2eccec4e8470841be6441e66765; ?>
<?php unset($__componentOriginal4378b2eccec4e8470841be6441e66765); ?>
<?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</body>
</html><?php /**PATH C:\Users\USER\Documents\Branyeygit\resources\views/layouts/app.blade.php ENDPATH**/ ?>