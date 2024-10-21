<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FuncionariosController;
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
});

Route::put('/funcionarios/{id}', [FuncionariosController::class, 'update'])->name('funcionarios.update');

Route::controller(FuncionariosController::class)->group(function(){
    Route::post('/dashboard/funcionarios/create', 'create')->name('funcionarios.create');
    Route::post('/dashboard/funcionarios/update', 'update')->name('funcionarios.update');
    Route::delete('/dashboard/funcionarios/delete/{id}', 'delete')->name('funcionarios.delete');
});
