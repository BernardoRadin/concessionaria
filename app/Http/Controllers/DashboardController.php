<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Funcionario;
use App\Models\Marca;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard');
    }
    
    public function funcionarios(){

        // Carrega todos os funcionários com os cargos
        $funcionarios = Funcionario::with('cargo')->get();
        
        // Retorna a view passando os funcionários
        return view('dashboard_funcionarios', compact('funcionarios'));
    }

    public function marcas(){

        // Carrega todos os funcionários com os cargos
        $marcas = Marca::all();

        // Retorna a view passando os funcionários
        return view('dashboard_marcas', compact('marcas'));
    }

    public function categorias(){

        // Carrega todos os funcionários com os cargos
        $categorias = Categoria::all();

        // Retorna a view passando os funcionários
        return view('dashboard_categorias', compact('categorias'));
    }

}
