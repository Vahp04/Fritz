<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\TipoEquipoController;
use App\Http\Controllers\StockEquiposController;
use App\Http\Controllers\EquipoAsignadoController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;

// Rutas para Login
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas para Dashboard
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard/estadisticas', [DashboardController::class, 'getEstadisticas']);

// Rutas de Usuario (CRUD) - Protegidas
Route::middleware(['auth'])->group(function () {
    Route::get('/usuario', [UsuarioController::class, 'index'])->name('usuario.index');
    Route::post('/usuario', [UsuarioController::class, 'store'])->name('usuario.store');
    Route::put('/usuario/{id}', [UsuarioController::class, 'update'])->name('usuario.update');
    Route::delete('/usuario/{id}', [UsuarioController::class, 'destroy'])->name('usuario.destroy');
    Route::post('/usuario/{id}/toggle-status', [UsuarioController::class, 'toggleStatus'])->name('usuario.toggle-status');
});

// Rutas para Departamentos
Route::resource('departamentos', DepartamentoController::class);
Route::get('departamentos/{id}/usuarios', [DepartamentoController::class, 'getUsuarios'])->name('departamentos.usuarios');
Route::post('departamentos/{id}/toggle-status', [DepartamentoController::class, 'toggleStatus'])->name('departamentos.toggle-status');

// Rutas para Sedes
Route::resource('sedes', SedeController::class);
Route::get('sedes/{id}/usuarios', [SedeController::class, 'getUsuarios'])->name('sedes.usuarios');
Route::get('sedes/estadisticas/data', [SedeController::class, 'getEstadisticas'])->name('sedes.estadisticas');
Route::get('sedes/search/query', [SedeController::class, 'search'])->name('sedes.search');

// Rutas para Usuarios
Route::get('/usuarios/generar-pdf', [UsuariosController::class, 'generarPdf'])->name('usuarios.generar-pdf');
Route::get('/usuarios/ver-pdf', [UsuariosController::class, 'verPdf'])->name('usuarios.ver-pdf');
Route::resource('usuarios', UsuariosController::class);
Route::get('usuarios/sede/{sedeId}', [UsuariosController::class, 'getBySede'])->name('usuarios.by-sede');
Route::get('usuarios/departamento/{departamentoId}', [UsuariosController::class, 'getByDepartamento'])->name('usuarios.by-departamento');
Route::get('usuarios/search/query', [UsuariosController::class, 'search'])->name('usuarios.search');
Route::get('usuarios/estadisticas/data', [UsuariosController::class, 'getEstadisticas'])->name('usuarios.estadisticas');

//Ruta para Tipo_equipos
Route::resource('tipo_equipo', TipoEquipoController::class);
Route::get('/api/tipo_equipo', [TipoEquipoController::class, 'apiIndex']);
Route::get('/api/tipo_equipo/{id}', [TipoEquipoController::class, 'apiShow']);

//Rustas para Stock_equipos
Route::get('/stock_equipos/generar-pdf', [StockEquiposController::class, 'generarPdfStock'])->name('stock_equipos.generar-pdf');
Route::get('/stock_equipos/ver-pdf', [StockEquiposController::class, 'verPdfStock'])->name('stock_equipos.ver-pdf');
Route::resource('stock_equipos', StockEquiposController::class);
Route::get('/stock_equipos/stock-bajo', [StockEquiposController::class, 'stockBajo'])->name('stock_equipos.stock-bajo');
Route::get('/stock_equipos/resumen', [StockEquiposController::class, 'resumenStock'])->name('stock_equipos.resumen');
Route::get('/stock_equipos/por-tipo/{tipoId}', [StockEquiposController::class, 'porTipo'])->name('stock_equipos.por-tipo');
Route::prefix('api')->group(function () {
    Route::get('/stock_equipos', [StockEquiposController::class, 'apiIndex']);
    Route::get('/stock_equipos/{id}', [StockEquiposController::class, 'apiShow']);
    Route::put('/stock_equipos/{id}/actualizar-cantidades', [StockEquiposController::class, 'actualizarCantidades']);
});


// Rutas para Equipos_asignados
Route::get('/equipos_asignados/generar-pdf', [EquipoAsignadoController::class, 'generarPdfAsignaciones'])->name('equipos_asignados.generar-pdf');
Route::get('/equipos_asignados/ver-pdf', [EquipoAsignadoController::class, 'verPdfAsignaciones'])->name('equipos_asignados.ver-pdf');
Route::get('/equipos_asignados/usuario/{usuarioId}/pdf', [EquipoAsignadoController::class, 'generarPdfPorUsuario'])
    ->name('equipos_asignados.pdf.usuario');
Route::get('/equipos_asignados/usuario/{usuarioId}/ver-pdf', [EquipoAsignadoController::class, 'verPdfPorUsuario'])
    ->name('equipos_asignados.ver-pdf.usuario');
Route::resource('equipos_asignados', EquipoAsignadoController::class);
Route::post('/equipos_asignados/{equipoAsignado}/devolver', [EquipoAsignadoController::class, 'devolver'])
    ->name('equipos_asignados.devolver');
Route::post('/equipos_asignados/{equipoAsignado}/marcar-obsoleto', [EquipoAsignadoController::class, 'marcarObsoleto'])
    ->name('equipos_asignados.marcar-obsoleto'); 
Route::get('/equipos_asignados/reporte', [EquipoAsignadoController::class, 'reporte'])
    ->name('equipos_asignados.reporte');
Route::get('/equipos_asignados/estadisticas', [EquipoAsignadoController::class, 'estadisticas'])
    ->name('equipos_asignados.estadisticas');
Route::get('/equipos_asignados/por-usuario/{usuarioId}', [EquipoAsignadoController::class, 'porUsuario'])
    ->name('equipos_asignados.por-usuario');
Route::get('/equipos_asignados/por-stock/{stockId}', [EquipoAsignadoController::class, 'porStock'])
    ->name('equipos_asignados.por-stock');
Route::prefix('api')->group(function () {
    Route::get('/equipos_asignados', [EquipoAsignadoController::class, 'apiIndex']);
    Route::get('/equipos_asignados/{id}', [EquipoAsignadoController::class, 'apiShow']);
});

Route::get('/debug-routes', function() {
    $routes = [];
    foreach (Route::getRoutes() as $route) {
        if (str_contains($route->uri, 'equipos_asignados')) {
            $routes[] = [
                'method' => implode('|', $route->methods),
                'uri' => $route->uri,
                'name' => $route->getName()
            ];
        }
    }
    return response()->json($routes);
});
