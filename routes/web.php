<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController, EncomendaController, MoradorController, 
    ApartamentoController, DashboardController, CondominioController
};
use App\Http\Controllers\Admin\AdminController;

// Redirecionamento Inicial
Route::get('/', fn() => redirect()->route('login'));

// Rotas Protegidas por Autenticação
Route::middleware(['auth', 'verified'])->group(function () {

    // Rota solta de delete (ajustada para seguir o padrão)
    Route::delete('/condominios/{condominio}', [CondominioController::class, 'destroy'])->name('condominios.destroy');

    // --- DASHBOARD PRINCIPAL ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- ÁREA DO SUPER ADMIN (Role: Admin) ---
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::post('/alternar-condominio', [AdminController::class, 'alternarContexto'])->name('alternar.condominio');
        
        // Gestão de Condomínios e Seus Usuários pelo Admin
        Route::post('/condominio', [AdminController::class, 'store'])->name('store');
        Route::get('/condominio/{condominio}', [AdminController::class, 'show'])->name('show');
        Route::post('/condominio/{condominio}/usuario', [AdminController::class, 'addUser'])->name('user.store');
        Route::get('/usuarios/{user}/edit', [AdminController::class, 'editUser'])->name('user.edit');
        Route::put('/usuarios/{user}', [AdminController::class, 'updateUser'])->name('user.update');
    });

    // --- GESTÃO DO CONDOMÍNIO (Síndico/Admin) ---
    Route::prefix('condominio')->name('condominio.')->group(function () {
        Route::get('/configurar', [CondominioController::class, 'edit'])->name('edit');
        Route::put('/configurar', [CondominioController::class, 'update'])->name('update');
        
        // Importação e Exportação
        Route::get('/exemplo-excel', [CondominioController::class, 'downloadExemplo'])->name('exemplo-excel');
        Route::post('/importar', [CondominioController::class, 'importar'])->name('importar');
        Route::get('/exportar', [CondominioController::class, 'exportar'])->name('exportar');
    });
    
    

    // --- OPERAÇÃO DE PORTARIA (Encomendas) ---
    Route::prefix('encomendas')->name('encomendas.')->group(function () {
        Route::get('/', [EncomendaController::class, 'index'])->name('index');
        Route::post('/', [EncomendaController::class, 'store'])->name('store');
        Route::get('/{encomenda}/notificar/{morador}', [EncomendaController::class, 'notificar'])->name('notificar');
        Route::post('/{encomenda}/entregar', [EncomendaController::class, 'entregar'])->name('entregar');
    });

    // --- CADASTROS BASE (Moradores e Apartamentos) ---
    Route::resource('moradores', MoradorController::class)->except(['show']);
    Route::resource('apartamentos', ApartamentoController::class);

    // --- GESTÃO DE USUÁRIOS DO CONDOMÍNIO (Porteiros) ---
    Route::post('/usuarios/registrar-porteiro', [DashboardController::class, 'storePorteiro'])->name('usuarios.storePorteiro');
    Route::delete('/usuarios/{user}', [DashboardController::class, 'destroy'])->name('usuarios.destroy');

    // --- PERFIL DO USUÁRIO ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';