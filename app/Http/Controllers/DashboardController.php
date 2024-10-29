<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Funcionario;
use App\Models\Marca;
use App\Models\Categoria;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard');
    }
    
    public function funcionarios(){

        $funcionarios = Funcionario::with('cargo')->get();
        
        return view('dashboard_funcionarios', compact('funcionarios'));
    }

    public function marcas(){

        $marcas = Marca::all();

        return view('dashboard_marcas', compact('marcas'));
    }

    public function categorias(){

        $categorias = Categoria::all();

        return view('dashboard_categorias', compact('categorias'));
    }

    public function clientes(){

        $clientes = Cliente::all();

        return view('dashboard_clientes', compact('clientes'));
    }

    public function vendas()
    {
        return view('dashboard_vendas');
    }
        
    public function veiculos()
    {
        return view('dashboard_veiculos');
    }
    

}
