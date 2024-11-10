<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Funcionario;
use App\Models\Marca;
use App\Models\Categoria;
use App\Models\Cliente; 
use App\Models\Veiculo;
use App\Models\Venda;
use App\Models\Site;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
    
        $site = Site::first();

        $vendas = DB::table('vendas')
        ->select(DB::raw('DATE(Data) as data'), DB::raw('COUNT(*) as quantidade_vendas'), DB::raw('SUM(PrecoVenda) as valor_total'))
        ->groupBy(DB::raw('DATE(Data)'))
        ->orderBy('data')
        ->get();

        $datas = [];
        $quantidades = [];
        $valores = [];
    
        foreach ($vendas as $venda) {
            $datas[] = $venda->data;
            $quantidades[] = $venda->quantidade_vendas;
            $valores[] = $venda->valor_total;
        }

        return view('dashboard', compact('site','datas', 'quantidades', 'valores'));
    }
    
    public function funcionarios(){

        $funcionarios = Funcionario::with('cargo')->get();
        
        return view('dashboard_funcionarios', compact('funcionarios'));
    }

    public function marcas(){

        $marcas = Marca::paginate(7);

        return view('dashboard_marcas', compact('marcas'));
    }

    public function categorias(){

        $categorias = Categoria::paginate(7);

        return view('dashboard_categorias', compact('categorias'));
    }

    public function clientes(){

        $clientes = Cliente::all();

        return view('dashboard_clientes', compact('clientes'));
    }

    public function vendas()
    {

        $vendas = Venda::with('veiculo','cliente','funcionario')->get();

        return view('dashboard_vendas', compact('vendas'));
    }
        
    public function veiculos()
    {

        $veiculos = Veiculo::with('categoria','marca','antigodono','funcionario','fotos')->paginate(5);

        $categorias = Categoria::all();
        $marcas = Marca::all();
        $clientes = Cliente::all();

        return view('dashboard_veiculos', compact('veiculos', 'categorias', 'marcas', 'clientes'));

    }
    
    public function site(){

        $site = Site::first();

        return view('dashboard_site', compact('site'));
    }

}
