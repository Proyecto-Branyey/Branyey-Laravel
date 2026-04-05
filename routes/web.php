<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
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
    });
});

/**
 * ==========================================
 * ECOSISTEMA ADMINISTRATIVO (Backoffice)
 * ==========================================
 * Cumple con Ítem 2 (Carga Inicial) e Ítem 4 (PDF) del SENA
 */
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'role:administrador'])->group(function () {
    
    // Panel Principal (Estadísticas)
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Reportes (Requerimiento Técnico SENA - Ítem 4)
    Route::get('/reporte-ventas', [ReporteController::class, 'ventasPdf'])->name('reportes.ventas');
    
    // CRUD DE PRODUCTOS (Gestión de Catálogo e Imágenes - Ítem 8)
    Route::prefix('productos')->name('productos.')->group(function () {
        Route::get('/', [ProductoAdminController::class, 'index'])->name('index');
        Route::get('/crear', [ProductoAdminController::class, 'create'])->name('create');
        Route::post('/guardar', [ProductoAdminController::class, 'store'])->name('store');
        Route::get('/{id}', [ProductoAdminController::class, 'show'])->name('show');
        Route::get('/{id}/editar', [ProductoAdminController::class, 'edit'])->name('edit');
        Route::put('/{id}/actualizar', [ProductoAdminController::class, 'update'])->name('update');
        Route::delete('/{id}/eliminar', [ProductoAdminController::class, 'destroy'])->name('destroy');
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
    Route::resource('tallas', App\Http\Controllers\Admin\TallaController::class);

    // CRUD DE COLORES
    Route::resource('colores', App\Http\Controllers\Admin\ColorController::class);

    // CRUD DE ESTILOS CAMISA
    Route::resource('estilos-camisa', App\Http\Controllers\Admin\EstiloCamisaController::class);
});

/**
 * ==========================================
 * PERFIL DE USUARIO Y AUTENTICACIÓN
 * ==========================================
 */
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('tienda.catalogo');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';