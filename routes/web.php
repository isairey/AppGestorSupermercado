<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\ReporteController;

// ─────────────────────────────────────────
// Rutas públicas (sin login)
// ─────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register'])->name('register.post');

// ─────────────────────────────────────────
// Rutas de cliente (requieren login)
// ─────────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Catálogo
    Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo');

    // Carrito
    Route::get('/carrito',                  [CarritoController::class, 'index'])->name('carrito');
    Route::post('/carrito/agregar',         [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::post('/carrito/actualizar',      [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
    Route::post('/carrito/eliminar/{id}',   [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::post('/carrito/finalizar',       [CarritoController::class, 'finalizar'])->name('carrito.finalizar');

    // Perfil y pedidos
    Route::get('/perfil',           [PerfilController::class, 'index'])->name('perfil');
    Route::post('/perfil/actualizar',[PerfilController::class, 'actualizar'])->name('perfil.actualizar');
    Route::get('/pedidos',          [PerfilController::class, 'pedidos'])->name('pedidos');
});

// ─────────────────────────────────────────
// Rutas de administrador
// ─────────────────────────────────────────
Route::middleware(['auth', 'es.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',    [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Productos
    Route::get('/productos',            [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/crear',      [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos',           [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{id}/editar',[ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{id}',       [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{id}',    [ProductoController::class, 'destroy'])->name('productos.destroy');

    // Reportes
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes');
});