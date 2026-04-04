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

// ECOSISTEMA TIENDA (Público/Clientes)
Route::prefix('tienda')->name('tienda.')->group(function () {
    
    Route::get('/', [ProductoController::class, 'inicio'])->name('inicio');
    
    // Ruta destino para Clientes (Minoristas/Mayoristas) tras el login
    Route::get('/catalogo', [ProductoController::class, 'index'])->name('catalogo');

    Route::get('/producto/{id}', [ProductoController::class, 'show'])->name('producto.detalle');
    
    Route::get('/buscar', [ProductoController::class, 'buscar'])->name('buscar');
});

// ECOSISTEMA ADMINISTRATIVO (Protegido por Rol)
// Agregamos 'role:administrador' al middleware para bloquear intrusos
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'role:administrador'])->group(function () {
    
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); 
    })->name('dashboard');

    // Aquí irán tus recursos de inventario más adelante
});

// PERFIL DE USUARIO (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';