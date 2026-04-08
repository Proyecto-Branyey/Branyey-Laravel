<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Branyey - @yield('title', 'Tienda de Ropa Urbana')</title>
    
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

        footer a[href*="wa.me"]:hover i {
            color: #25D366;
            transform: translateY(-3px);
        }

        footer a i {
            transition: all 0.3s ease;
            display: inline-block;
        }

        /* Botón flotante de WhatsApp */
        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #25D366;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
            z-index: 1000;
            text-decoration: none;
        }

        .whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
        }

        .whatsapp-float i {
            font-size: 2rem;
            color: white;
        }

        /* Tooltip opcional para boton de waz*/
        .whatsapp-float::before {
            content: "WhatsApp";
            position: absolute;
            right: 70px;
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .whatsapp-float:hover::before {
            opacity: 1;
            visibility: visible;
            transform: translateX(-5px);
        }

        /* Responsive para el botón flotante de waz*/
        @media (max-width: 768px) {
            .whatsapp-float {
                width: 50px;
                height: 50px;
                bottom: 20px;
                right: 20px;
            }
            .whatsapp-float i {
                font-size: 1.5rem;
            }
            .whatsapp-float::before {
                display: none;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ auth()->check() && auth()->user()?->rol?->nombre === 'administrador' ? route('admin.dashboard') : route('tienda.inicio') }}">BRANYEY</a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @if(request()->routeIs('admin.*'))
                        @auth
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active fw-bold' : '' }}" href="{{ route('admin.dashboard') }}">Panel Admin</a>
                            </li>
                            <li class="nav-item ms-lg-3">
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="nav-link btn btn-link text-danger p-0">Cerrar Sesión</button>
                                </form>
                            </li>
                        @endauth
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('tienda.inicio') ? 'active fw-bold' : '' }}" href="{{ route('tienda.inicio') }}">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('tienda.catalogo') ? 'active fw-bold' : '' }}" href="{{ route('tienda.catalogo') }}">Catálogo</a>
                        </li>

                        @auth
                            <li class="nav-item dropdown ms-lg-3">
                                <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle me-2 fs-5"></i>
                                    {{ Auth::user()->username }}
                                    <span class="badge bg-primary nav-role-badge">
                                        {{ Auth::user()?->rol?->nombre ?? 'Cliente' }}
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                    @if(Auth::user()?->rol?->nombre === 'administrador')
                                        <li><a class="dropdown-item fw-bold text-primary" href="{{ route('admin.dashboard') }}">Panel Admin</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                    @else
                                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Mi Perfil</a></li>
                                        <li><a class="dropdown-item" href="{{ route('tienda.pedidos') }}">Mis Pedidos</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                    @endif
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">Cerrar Sesión</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item ms-lg-3">
                                <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                            </li>
                            <li class="nav-item ms-lg-2">
                                <a class="btn btn-primary btn-sm rounded-pill px-4 fw-600" href="{{ route('register') }}">Registrarse</a>
                            </li>
                        @endauth

                        @if(!auth()->check() || auth()->user()?->rol?->nombre !== 'administrador')
                            <li class="nav-item ms-lg-4">
                                <a class="btn btn-light position-relative rounded-pill px-3 d-flex align-items-center" href="{{ route('tienda.cart.index') }}">
                                    <i class="bi bi-bag-fill me-2"></i>
                                    <span class="d-none d-lg-inline small fw-bold">CARRITO</span>
                                    @php $count = session('cart') ? count(session('cart')) : 0; @endphp
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-2 border-white" style="font-size: 0.7rem;">
                                        {{ $count }}
                                    </span>
                                </a>
                            </li>
                        @endif
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @if(session('success') || session('error'))
        <div class="container mt-4">
            @if(session('success'))
                <div class="alert alert-dark alert-dismissible fade show border-0 shadow-sm rounded-4 px-4 py-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                        <div><strong>¡Éxito!</strong> {{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 px-4 py-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                        <div><strong>Atención:</strong> {{ session('error') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
    @endif

    <main>
        @yield('content')
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
                    <a href="https://instagram.com/tu_usuario" target="_blank" rel="noopener noreferrer"
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

    <a href="https://wa.me/573213229744" target="_blank" rel="noopener noreferrer"
       class="whatsapp-float"
       aria-label="Contactar por WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        const whatsappBtn = document.querySelector('.whatsapp-float');
        if (whatsappBtn) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    whatsappBtn.style.opacity = '1';
                    whatsappBtn.style.visibility = 'visible';
                } else {
                    whatsappBtn.style.opacity = '0.7';
                    whatsappBtn.style.visibility = 'visible';
                }
            });
        }
    </script>

</body>
</html>