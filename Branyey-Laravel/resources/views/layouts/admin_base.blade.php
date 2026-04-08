<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Branyey Admin - @yield('title', 'Panel de Control')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    @stack('styles')
    
    <style>
        :root { --primary-black: #111111; }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .fw-black { font-weight: 900; }
        .italic { font-style: italic; }
        
        /* Navbar admin (similar al principal pero simplificado) */
        .navbar-admin {
            background: linear-gradient(135deg, #0a0e27 0%, #111111 100%) !important;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .navbar-brand {
            font-weight: 900;
            letter-spacing: -1px;
            font-size: 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .nav-link-admin {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        .nav-link-admin:hover {
            color: #667eea !important;
        }
        
        /* Footer admin */
        .footer-admin {
            background: var(--primary-black);
            color: rgba(255,255,255,0.6);
            padding: 20px 0;
            margin-top: auto;
            font-size: 0.75rem;
        }
        
        /* Contenido principal */
        .main-content {
            flex: 1;
        }
    </style>
</head>
<body>

    {{-- Navbar para admin (similar al principal) --}}
    <nav class="navbar-admin navbar navbar-expand-lg navbar-dark sticky-top shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">BRANYEY ADMIN</a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <span class="nav-link-admin text-white-50 small me-2">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ Auth::user()->username ?? 'Admin' }}
                        </span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link-admin btn btn-link text-danger p-0 text-decoration-none">
                                <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Layout principal de admin (sidebar + content) --}}
    @yield('admin-layout')

    {{-- Footer admin --}}
    <footer class="footer-admin text-center">
        <div class="container-fluid px-4">
            <p class="mb-0">© {{ date('Y') }} Branyey - Panel de Administración</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>