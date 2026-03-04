<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda de Ropa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .hero {
            background:  url('{{ asset('images/fondo.png') }}') center center / cover no-repeat;
            height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: bold;
        }

        .card img {
            height: 300px;
            object-fit: cover;
        }

        footer {
            background-color: #111;
            color: white;
            padding: 20px 0;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">FashionStore</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Catálogo</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Ofertas</a></li>
                <li class="nav-item"><a class="btn btn-outline-light ms-2" href="#">Carrito 🛒</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero -->
<section class="hero">
    <div>
        <h1>Nueva Colección 2026</h1>
        <p class="lead">vivi es muy graciosa</p>
        <a href="#" class="btn btn-light btn-lg mt-3">Branyey es la monda</a>
    </div>
</section>

<!-- Productos -->
<section class="container py-5">
    <h2 class="text-center mb-4">Productos Destacados</h2>
    <div class="row">

        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab" class="card-img-top">
                <div class="card-body text-center">
                    <h5 class="card-title">Camiseta Oversize</h5>
                    <p class="card-text">$25.00</p>
                    <button class="btn btn-dark">Agregar al carrito</button>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <img src="https://images.unsplash.com/photo-1516826957135-700dedea698c" class="card-img-top">
                <div class="card-body text-center">
                    <h5 class="card-title">Chaqueta Moderna</h5>
                    <p class="card-text">$80.00</p>
                    <button class="btn btn-dark">Agregar al carrito</button>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d" class="card-img-top">
                <div class="card-body text-center">
                    <h5 class="card-title">Vestido Elegante</h5>
                    <p class="card-text">$60.00</p>
                    <button class="btn btn-dark">Agregar al carrito</button>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Footer -->
<footer class="text-center">
    <div class="container">
        <p class="mb-0">© 2026 FashionStore - Todos los derechos reservados</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>