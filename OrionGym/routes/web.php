<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PreRegistrationController;

use App\Http\Controllers\CatracaController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PacoteController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\dashboardUserController;
use App\Http\Controllers\HomeController;


//Rotas protegidas que requerem autenticação

    Route::group(['middleware' => 'auth'], function () {

        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        // Rotas para Alunos
        //Route::get('/alunos', [AlunoController::class, 'index'])->name('alunos.index');
        Route::get('/alunos/create', [AlunoController::class, 'create'])->name('alunos.create');
        Route::post('/alunos', [AlunoController::class, 'store'])->name('alunos.store');
        Route::get('/alunos', [AlunoController::class, 'index'])->name('alunos.index');

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


        Route::get('/dashboardUser', [dashboardUserController::class, 'index'])->name('dashboardUser.index');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/dashboardUser', [dashboardUserController::class, 'index'])->name('dashboardUser.index');

        Route::get('/compras/{compra}/edit', [CompraController::class, 'edit'])->name('compras.edit');
    Route::put('/compras/{compra}', [CompraController::class, 'update'])->name('compra.update');
    Route::delete('/compras/{id}', [CompraController::class, 'destroy'])->name('compras.destroy');



        //Rotas para trancar
        // Rotas para trancar a matrícula do aluno
        Route::post('/alunos/{aluno}/trancar', [AlunoController::class, 'trancarMatricula'])->name('alunos.trancarMatricula');
        Route::post('/alunos/{id}/confirmar-trancamento', [AlunoController::class, 'confirmarTrancamento'])->name('alunos.confirmarTrancamento');

        Route::post('/alunos/destrancar/{id}', [AlunoController::class, 'destrancarMatricula'])->name('alunos.destrancarMatricula');

Route::get('/pre-registrations', [PreRegistrationController::class, 'index'])->name('pre-registrations.index');

Route::delete('/pre-registrations/{pre_registration}', [PreRegistrationController::class, 'destroy'])->name('pre-registrations.destroy');


    });






// Rotas de autenticação
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);



Route::get('/home', [HomeController::class, 'index'])->name('home.index');

//Rotas do Home

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('home.about-us');
Route::get('/blog-details', [HomeController::class, 'blogDetails'])->name('home.blog-details');
Route::get('/blog', [HomeController::class, 'blog'])->name('home.blog');
Route::get('/bmi', [HomeController::class, 'bmi'])->name('home.bmi');
Route::get('/class-details', [HomeController::class, 'classDetails'])->name('home.class-details');
Route::get('/class-timetable', [HomeController::class, 'classTimetable'])->name('home.class-timetable');
Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('home.gallery');
Route::get('/main', [HomeController::class, 'main'])->name('home.main');
Route::get('/services', [HomeController::class, 'services'])->name('home.services');
Route::get('/team', [HomeController::class, 'team'])->name('home.team');


route::get('/instagram', [HomeController::class, 'instagram'])->name('home.instagram');


//Rotas da Catraca

Route::post('/catraca/abrir', [CatracaController::class, 'abrirCatraca']);
Route::get('/catraca/logs', [CatracaController::class, 'consultarLogs']);



Route::get('/catraca', [CatracaController::class, 'index'])->name('catraca.index');

Route::post('/catraca/abrir', [CatracaController::class, 'abrirCatraca']);


Route::post('/subscribe', [PreRegistrationController::class, 'store'])->name('subscribe');
