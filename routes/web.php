<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\FacturaProductoController;
use App\Http\Controllers\RespaldoController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\EstadisticasController;
use App\Http\Controllers\DashboardController;
// Ruta raíz, redirige según sesión
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Mostrar formulario de login
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');

// Procesar login (POST)
Route::post('login', [AuthController::class, 'login'])->name('login.submit');

// Logout por POST
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard protegido por middleware auth

Route::get('/dashboard', [TiendaController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');


Route::get('/splash', function () {
        return view('splash');
    })->name('splash');

// USUARIOS
Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
Route::get('usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
Route::post('usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');

Route::get('usuarios/{usuario}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
Route::put('usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
Route::delete('usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

// ROLES
Route::get('roles', [RolController::class, 'index'])->name('roles.index');
Route::get('roles/create', [RolController::class, 'create'])->name('roles.create');
Route::post('roles', [RolController::class, 'store'])->name('roles.store');
Route::get('roles/{rol}', [RolController::class, 'show'])->name('roles.show');
Route::get('roles/{rol}/edit', [RolController::class, 'edit'])->name('roles.edit');
Route::put('roles/{rol}', [RolController::class, 'update'])->name('roles.update');
Route::delete('roles/{rol}', [RolController::class, 'destroy'])->name('roles.destroy');

// PRODUCTOS
Route::get('productos', [ProductoController::class, 'index'])->name('productos.index');
Route::get('productos/create', [ProductoController::class, 'create'])->name('productos.create');
Route::post('productos', [ProductoController::class, 'store'])->name('productos.store');
Route::get('productos/{producto}', [ProductoController::class, 'show'])->name('productos.show');
Route::get('productos/{producto}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
Route::put('productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');
Route::delete('productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');

// CLIENTES
Route::get('clientes', [ClienteController::class, 'index'])->name('clientes.index');
Route::get('clientes/create', [ClienteController::class, 'create'])->name('clientes.create');
Route::post('clientes', [ClienteController::class, 'store'])->name('clientes.store');

Route::get('clientes/{cliente}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
Route::put('clientes/{cliente}', [ClienteController::class, 'update'])->name('clientes.update');
Route::delete('clientes/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

// FACTURAS
Route::resource('facturas', FacturaController::class);

Route::get('facturas', [FacturaController::class, 'index'])->name('facturas.index');
Route::get('facturas/create', [FacturaController::class, 'create'])->name('facturas.create');
Route::post('facturas', [FacturaController::class, 'store'])->name('facturas.store');
Route::get('facturas/{factura}', [FacturaController::class, 'show'])->name('facturas.show');
Route::get('facturas/{factura}/edit', [FacturaController::class, 'edit'])->name('facturas.edit');
Route::put('facturas/{factura}', [FacturaController::class, 'update'])->name('facturas.update');
Route::delete('facturas/{factura}', [FacturaController::class, 'destroy'])->name('facturas.destroy');
Route::get('facturas/{id}/pdf', [FacturaController::class, 'exportarPDF'])->name('facturas.pdf');

// Nuevas rutas para búsqueda dinámica
Route::get('/facturas/clientes', [FacturaController::class, 'getClientes'])->name('facturas.clientes');
Route::get('/facturas/productos', [FacturaController::class, 'getProductos'])->name('facturas.productos');

Route::get('/respaldar', [RespaldoController::class, 'descargar'])->name('respaldar');
    Route::get('/descargar-respaldo/{filename}', [RespaldoController::class, 'descargarArchivo'])->name('descargar.archivo');
    Route::get('/restaurar', [RespaldoController::class, 'vistaRestaurar'])->name('vista.restaurar');
    Route::post('/restaurar', [RespaldoController::class, 'restaurar'])->name('restaurar');

// Ruta para las estadisticas
Route::get('/estadisticas', [EstadisticasController::class, 'index'])->name('estadisticas.index');

// Ruta para el dashbord
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


