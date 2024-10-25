<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FuncionariosController;
use App\Http\Controllers\MarcasController;
use App\Http\Controllers\CategoriasController;
use Illuminate\Support\Facades\Route;
use App\Models\Funcionario;

Route::get('/', [HomeController::class,'index']);

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::controller(LoginController::class)->group(function(){
    Route::get('/login','index')->name('login.index');
    Route::post('/login','store')->name('login.store');
    Route::get('/logout','destroy')->name('login.destroy');
});

Route::controller(DashboardController::class)->group(function(){
    Route::get('/dashboard', 'index')->name('dashboard.index');
    Route::get('/dashboard/funcionarios', 'funcionarios')->name('dashboard.funcionarios');
    Route::get('/dashboard/marcas', 'marcas')->name('dashboard.marcas');
    Route::get('/dashboard/categorias', 'categorias')->name('dashboard.categorias');
});

Route::controller(FuncionariosController::class)->group(function(){
    Route::get('/dashboard/funcionarios/edit/{id}', 'edit')->name('funcionarios.edit');
    Route::post('/dashboard/funcionarios/create', 'create')->name('funcionarios.create');
    Route::put('/dashboard/funcionarios/update/{id}', 'update')->name('funcionarios.update');
    Route::delete('/dashboard/funcionarios/delete/{id}', 'delete')->name('funcionarios.delete');
});

Route::controller(MarcasController::class)->group(function(){
    Route::get('/dashboard/marcas/edit/{id}', 'edit')->name('marcas.edit');
    Route::post('/dashboard/marcas/create', 'create')->name('marcas.create');
    Route::put('/dashboard/marcas/update/{id}', 'update')->name('marcas.update');
    Route::delete('/dashboard/marcas/delete/{id}', 'delete')->name('marcas.delete');
});

Route::controller(CategoriasController::class)->group(function(){
    Route::get('/dashboard/categorias/edit/{id}', 'edit')->name('categorias.edit');
    Route::post('/dashboard/categorias/create', 'create')->name('categorias.create');
    Route::put('/dashboard/categorias/update/{id}', 'update')->name('categorias.update');
    Route::delete('/dashboard/categorias/delete/{id}', 'delete')->name('categorias.delete');
});
