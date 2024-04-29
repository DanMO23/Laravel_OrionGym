<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\PacoteController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\DashboardController;

Route::get('/alunos', [AlunoController::class, 'index']);


Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


// Rotas para Alunos
Route::get('/alunos', [AlunoController::class, 'index'])->name('alunos.index');
Route::get('/alunos/create', [AlunoController::class, 'create'])->name('alunos.create');
Route::post('/alunos', [AlunoController::class, 'store'])->name('alunos.store');
Route::get('/alunos/{aluno}', [AlunoController::class, 'show'])->name('alunos.show');
Route::get('/alunos/{aluno}/edit', [AlunoController::class, 'edit'])->name('alunos.edit');
Route::put('/alunos/{aluno}', [AlunoController::class, 'update'])->name('alunos.update');
Route::delete('/alunos/{aluno}', [AlunoController::class, 'destroy'])->name('alunos.destroy');

Route::get('/alunos/search', [AlunoController::class, 'search'])->name('alunos.search');

// Rotas para Professores
Route::get('/professores', [ProfessorController::class, 'index'])->name('professores.index');

Route::get('/professores/create', [ProfessorController::class, 'create'])->name('professores.create');
Route::post('/professores', [ProfessorController::class, 'store'])->name('professores.store');
Route::get('/professores/{professor}', [ProfessorController::class, 'show'])->name('professores.show');
Route::get('/professores/{professor}/edit', [ProfessorController::class, 'edit'])->name('professores.edit');
Route::put('/professores/{professor}', [ProfessorController::class, 'update'])->name('professores.update');
Route::delete('/professores/{professor}', [ProfessorController::class, 'destroy'])->name('professores.destroy');

// Rotas para Pacotes
Route::get('/pacotes', [PacoteController::class, 'index'])->name('pacotes.index');
Route::get('/pacotes/create', [PacoteController::class, 'create'])->name('pacotes.create');
Route::post('/pacotes', [PacoteController::class, 'store'])->name('pacotes.store');
Route::get('/pacotes/{pacote}', [PacoteController::class, 'show'])->name('pacotes.show');
Route::get('/pacotes/{pacote}/edit', [PacoteController::class, 'edit'])->name('pacotes.edit');
Route::put('/pacotes/{pacote}', [PacoteController::class, 'update'])->name('pacotes.update');
Route::delete('/pacotes/{pacote}', [PacoteController::class, 'destroy'])->name('pacotes.destroy');

// Rotas para Funcionários
Route::get('/funcionarios', [FuncionarioController::class, 'index'])->name('funcionarios.index');
Route::get('/funcionarios/create', [FuncionarioController::class, 'create'])->name('funcionarios.create');
Route::post('/funcionarios', [FuncionarioController::class, 'store'])->name('funcionarios.store');
Route::get('/funcionarios/{funcionario}', [FuncionarioController::class, 'show'])->name('funcionarios.show');
Route::get('/funcionarios/{funcionario}/edit', [FuncionarioController::class, 'edit'])->name('funcionarios.edit');
Route::put('/funcionarios/{funcionario}', [FuncionarioController::class, 'update'])->name('funcionarios.update');
Route::delete('/funcionarios/{funcionario}', [FuncionarioController::class, 'destroy'])->name('funcionarios.destroy');


// Rotas para Compras

Route::get('/compra/create', [CompraController::class, 'create'])->name('compra.create');

Route::post('/compra', [CompraController::class, 'store'])->name('compra.store');
Route::get('/compras/historicoChart', 'CompraController@historicoCompras')->name('compras.historicoChart');

Route::get('compra/historico', [CompraController::class, 'index'])->name('compra.historico');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');