<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branyey - @yield('title', 'Tienda de Ropa Urbana')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root { --primary-black: #111111; }
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        
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

        footer { background: var(--primary-black); color: rgba(255,255,255,0.6); padding: 40px 0; margin-top: 60px; }
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
            <h5 class="fw-black text-white mb-3">BRANYEY</h5>
            <p class="small mb-4">Streetwear & Urban Culture - Bogotá, CO</p>
            <div class="d-flex justify-content-center gap-3 mb-4">
                <a href="#" class="text-white-50 fs-5"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-white-50 fs-5"><i class="bi bi-tiktok"></i></a>
                <a href="#" class="text-white-50 fs-5"><i class="bi bi-facebook"></i></a>
            </div>
            <div class="border-top border-secondary pt-4">
                <p class="small mb-0">© 2026 Branyey. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Alpine.js para modales y componentes interactivos -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    {{-- Notificaciones eliminadas --}}

</body>
</html>