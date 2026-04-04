<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Branyey Web Routes
|--------------------------------------------------------------------------
*/

// Raíz: Redirigir siempre a la experiencia de usuario
Route::get('/', function () {
    return redirect()->route('tienda.inicio');
});

// ECOSISTEMA TIENDA (Público)
Route::prefix('tienda')->name('tienda.')->group(function () {
    
    // Home con destacados
    Route::get('/', [ProductoController::class, 'inicio'])->name('inicio');
    
    // Catálogo con filtros y paginación
    Route::get('/catalogo', [ProductoController::class, 'index'])->name('catalogo');

    // Perfil detallado de la prenda
    Route::get('/producto/{id}', [ProductoController::class, 'show'])->name('producto.detalle');
    
    // API de búsqueda rápida
    Route::get('/buscar', [ProductoController::class, 'buscar'])->name('buscar');
});

// ECOSISTEMA ADMINISTRATIVO (Privado)
Route::prefix('backoffice')->name('backoffice.')->middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () {
        return view('backoffice.dashboard');
    })->name('dashboard');

    // Aquí irán tus rutas de gestión de inventario, ventas, etc.
});

// PERFIL DE USUARIO (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';