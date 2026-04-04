<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Branyey - @yield('title', 'Tienda de Ropa')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero { 
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('images/fondo.png') }}') center/cover no-repeat; 
            height: 90vh; display: flex; align-items: center; justify-content: center; color: white;
        }
        .navbar-brand { font-weight: 800; letter-spacing: 1px; }
        footer { background: #111; color: white; padding: 30px 0; margin-top: 40px; }
        .nav-role-badge { font-size: 0.7rem; padding: 2px 6px; border-radius: 10px; vertical-align: middle; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('tienda.inicio') }}">BRANYEY</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tienda.inicio') ? 'active fw-bold' : '' }}" href="{{ route('tienda.inicio') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tienda.catalogo') ? 'active fw-bold' : '' }}" href="{{ route('tienda.catalogo') }}">Catálogo</a>
                </li>

                @auth
                    <li class="nav-item dropdown ms-lg-3">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->username }} 
                            <span class="badge bg-primary nav-role-badge uppercase">{{ Auth::user()->rol->nombre ?? 'Cliente' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Mi Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
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
                    <li class="nav-item">
                        <a class="btn btn-sm btn-outline-light ms-lg-2" href="{{ route('register') }}">Registrarse</a>
                    </li>
                @endauth

                <li class="nav-item ms-lg-3">
                    <a class="btn btn-outline-light position-relative" href="#">
                        Carrito 🛒
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

@yield('content')

<footer class="text-center">
    <div class="container">
        <p class="mb-0">© 2026 Branyey - Todos los derechos reservados</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>