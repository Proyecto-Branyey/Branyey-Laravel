<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('tienda')->name('tienda.')->group(function () {
    
    Route::get('/', function () {
        return view('tienda.inicio');
    })->name('inicio');
    
    Route::get('/catalogo', function () {
        return view('tienda.catalogo');
    })->name('catalogo');
    
});

Route::prefix('backoffice')->name('backoffice.')->middleware(['auth', 'verified'])->group(function () {
    
Route::get('/dashboard', function () {
        return view('backoffice.dashboard');
    })->name('dashboard');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
