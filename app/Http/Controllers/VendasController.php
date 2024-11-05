<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use App\Models\Funcionario;
use App\Models\Fotos;
use App\Models\Marca;
use App\Models\Categoria;
use App\Models\Cliente;
use Illuminate\Http\Request;

class VendasController extends Controller
{

    public function view($idcarro){
        $funcionarios = Funcionario::all();
        $clientes = Cliente::all();
        $veiculo = Veiculo::find($idcarro);
        $veiculos = Veiculo::with('categoria','marca','antigodono','funcionario','fotos')->get();

        return view('dashboard_vendas_cadastro', compact('veiculo','veiculos','clientes', 'funcionarios'));
    }

    public function create(Request $request){

        $request->validate([
            'ID_Veiculo' => 'required|integer',
            'ID_Funcionario' => 'required|integer',
            'ID_Cliente' => 'required|integer',
            'data' => 'required|date',
            'precoVenda' => 'required|numeric',
            'descricao' => 'nullable|string',
        ]);

        Marca::create([
            'ID_Veiculo' => $request->nome,
            'Logo' => $path,
        ]);

    }

}