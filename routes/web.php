<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ColombiaApiController;
use App\Http\Controllers\Tienda\CartController;
use App\Http\Controllers\Tienda\OrdenController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ReporteController;
use App\Http\Controllers\Admin\ProductoAdminController;
use App\Http\Controllers\Admin\EstiloAdminController;
use Illuminate\Support\Facades\Route;

// Redirección inicial a la tienda
Route::get('/', function () {
    return redirect()->route('tienda.inicio');
});

/**
 * ==========================================
 * API PÚBLICA — Datos de Colombia (Web Service)
 * Fuente: https://api-colombia.com
 * ==========================================
 */
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/departamentos', [ColombiaApiController::class, 'departamentos'])->name('departamentos');
    Route::get('/departamentos/{id}/ciudades', [ColombiaApiController::class, 'ciudades'])->name('ciudades')->whereNumber('id');
});

/**
 * ==========================================
 * ECOSISTEMA TIENDA (Público y Clientes)
 * ==========================================
 */
Route::prefix('tienda')->name('tienda.')->group(function () {
    
    // Rutas Públicas
    Route::get('/', [ProductoController::class, 'inicio'])->name('inicio');
    Route::get('/catalogo', [ProductoController::class, 'index'])->name('catalogo');
    Route::get('/producto/{id}', [ProductoController::class, 'show'])->name('producto.detalle');
    Route::get('/buscar', [ProductoController::class, 'buscar'])->name('buscar');

    // Rutas Protegidas (Requieren Login)
    Route::middleware(['auth'])->group(function () {
        
        // Gestión del Carrito (HU-014)
        Route::prefix('carrito')->name('cart.')->group(function () {
            Route::get('/', [CartController::class, 'index'])->name('index');
            Route::post('/add', [CartController::class, 'add'])->name('add');
            Route::post('/update/{id}', [CartController::class, 'update'])->name('update');
            Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
        });

        // Checkout y Generación de Orden (Transaccional)
        Route::get('/checkout', [OrdenController::class, 'checkout'])->name('checkout');
        Route::post('/confirmar-compra', [OrdenController::class, 'store'])->name('orden.store');
        // Historial de pedidos del usuario (Mis Pedidos)
        Route::get('/pedidos', [\App\Http\Controllers\Tienda\PedidoController::class, 'index'])->name('pedidos');
        // Factura de venta para el usuario autenticado
        Route::get('/pedidos/{venta}/factura', [\App\Http\Controllers\Tienda\PedidoController::class, 'factura'])->name('pedidos.factura');
        // Marcar pedido como recibido
        Route::post('/pedidos/{venta}/recibido', [\App\Http\Controllers\Tienda\PedidoController::class, 'recibido'])->name('pedidos.recibido');
    });
});

/**
 * ==========================================
 * ECOSISTEMA ADMINISTRATIVO (Backoffice)
 * ==========================================
 * Cumple con Ítem 2 (Carga Inicial) e Ítem 4 (PDF) del SENA
 */
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'role:administrador'])->group(function () {
    // Factura de venta (ver y descargar PDF)
    Route::get('ventas/{venta}/factura', [\App\Http\Controllers\Admin\VentaAdminController::class, 'factura'])
        ->name('ventas.factura');

        // Reportes de ventas PDF/CSV
        Route::get('ventas/reporte/{formato?}', [\App\Http\Controllers\Admin\ReporteVentasController::class, 'descargar'])
            ->where('formato', 'pdf|csv')
            ->name('ventas.reporte');
    
    // Panel Principal (Estadísticas)
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    
    // CRUD DE PRODUCTOS (Gestión de Catálogo e Imágenes - Ítem 8)
    Route::prefix('productos')->name('productos.')->group(function () {
        Route::get('/', [ProductoAdminController::class, 'index'])->name('index');
        Route::get('/papelera', [ProductoAdminController::class, 'papelera'])->name('papelera');
        Route::get('/crear', [ProductoAdminController::class, 'create'])->name('create');
        Route::post('/guardar', [ProductoAdminController::class, 'store'])->name('store');
        Route::get('/{id}', [ProductoAdminController::class, 'show'])->whereNumber('id')->name('show');
        Route::get('/{id}/editar', [ProductoAdminController::class, 'edit'])->whereNumber('id')->name('edit');
        Route::put('/{id}/actualizar', [ProductoAdminController::class, 'update'])->whereNumber('id')->name('update');
        Route::delete('/{id}/eliminar', [ProductoAdminController::class, 'destroy'])->whereNumber('id')->name('destroy');
        Route::put('/{id}/activar', [ProductoAdminController::class, 'activar'])->whereNumber('id')->name('activar');
    });

    // GESTION DE VARIANTES
    Route::prefix('variantes')->name('variantes.')->group(function () {
        Route::get('/papelera', [\App\Http\Controllers\Admin\VarianteAdminController::class, 'papelera'])->name('papelera');
        Route::delete('/{id}/eliminar', [\App\Http\Controllers\Admin\VarianteAdminController::class, 'destroy'])->whereNumber('id')->name('destroy');
        Route::put('/{id}/activar', [\App\Http\Controllers\Admin\VarianteAdminController::class, 'activar'])->whereNumber('id')->name('activar');
    });

    // CRUD DE ESTILOS
    Route::prefix('estilos')->name('estilos.')->group(function () {
        Route::get('/', [EstiloAdminController::class, 'index'])->name('index');
        Route::get('/crear', [EstiloAdminController::class, 'create'])->name('create');
        Route::post('/guardar', [EstiloAdminController::class, 'store'])->name('store');
        Route::get('/{id}/editar', [EstiloAdminController::class, 'edit'])->name('edit');
        Route::put('/{id}/actualizar', [EstiloAdminController::class, 'update'])->name('update');
        Route::delete('/{id}/eliminar', [EstiloAdminController::class, 'destroy'])->name('destroy');
    });

    // CRUD DE TALLAS
    Route::get('tallas/papelera', [App\Http\Controllers\Admin\TallaController::class, 'papelera'])->name('tallas.papelera');
    Route::put('tallas/{id}/activar', [App\Http\Controllers\Admin\TallaController::class, 'activar'])->name('tallas.activar');
    Route::resource('tallas', App\Http\Controllers\Admin\TallaController::class);

    // CRUD DE COLORES
    Route::get('colores/papelera', [App\Http\Controllers\Admin\ColorController::class, 'papelera'])->name('colores.papelera');
    Route::put('colores/{id}/activar', [App\Http\Controllers\Admin\ColorController::class, 'activar'])->name('colores.activar');
    Route::resource('colores', App\Http\Controllers\Admin\ColorController::class);

    // CRUD DE ESTILOS CAMISA
    Route::get('estilos-camisa/papelera', [App\Http\Controllers\Admin\EstiloCamisaController::class, 'papelera'])->name('estilos-camisa.papelera');
    Route::put('estilos-camisa/{id}/activar', [App\Http\Controllers\Admin\EstiloCamisaController::class, 'activar'])->name('estilos-camisa.activar');
    Route::resource('estilos-camisa', App\Http\Controllers\Admin\EstiloCamisaController::class);

    // CRUD DE USUARIOS
    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\UserAdminController::class, 'index'])->name('index');
        Route::get('/crear', [\App\Http\Controllers\Admin\UserAdminController::class, 'create'])->name('create');
        Route::post('/guardar', [\App\Http\Controllers\Admin\UserAdminController::class, 'store'])->name('store');
        Route::get('/{id}/editar', [\App\Http\Controllers\Admin\UserAdminController::class, 'edit'])->name('edit');
        Route::put('/{id}/actualizar', [\App\Http\Controllers\Admin\UserAdminController::class, 'update'])->name('update');
        Route::delete('/{id}/eliminar', [\App\Http\Controllers\Admin\UserAdminController::class, 'destroy'])->name('destroy');
    });
    Route::get('usuarios/papelera', [App\Http\Controllers\Admin\UserAdminController::class, 'papelera'])->name('usuarios.papelera');
    Route::put('usuarios/{id}/activar', [App\Http\Controllers\Admin\UserAdminController::class, 'activar'])->name('usuarios.activar');

    // Solo consulta de ventas (no CRUD)
    Route::get('ventas', [App\Http\Controllers\Admin\VentaAdminController::class, 'index'])->name('ventas.index');
    Route::get('ventas/{venta}', [App\Http\Controllers\Admin\VentaAdminController::class, 'show'])->name('ventas.show');

    // Cambiar estado de venta
    Route::post('ventas/{venta}/estado', [App\Http\Controllers\Admin\VentaAdminController::class, 'cambiarEstado'])->name('ventas.cambiarEstado');

    // CRUD DE ÓRDENES
    Route::resource('ordenes', App\Http\Controllers\Admin\OrdenAdminController::class);

    // Notificaciones eliminadas
});

/**
 * ==========================================
 * PERFIL DE USUARIO Y AUTENTICACIÓN
 * ==========================================
 */
Route::middleware('auth')->group(function () {
        Route::get('/profile/datos/pdf', [ProfileController::class, 'descargarDatosPdf'])->name('profile.datos.pdf');
    Route::get('/dashboard', function () {
        return redirect()->route('tienda.catalogo');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';