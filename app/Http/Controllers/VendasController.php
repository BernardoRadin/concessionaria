<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use App\Models\Funcionario;
use App\Models\Cliente;
use App\Models\Venda;
use Illuminate\Http\Request;

class VendasController extends Controller
{

    public function viewcadastro($idcarro){
        $funcionarios = Funcionario::all();
        $clientes = Cliente::all();
        $veiculo = Veiculo::find($idcarro);

        if(!$veiculo){
            return redirect()->route('dashboard.veiculos')->with('error', 'Veículo não encontrado!');
        }

        $veiculos = Veiculo::with('categoria','marca','antigodono','funcionario','fotos')->paginate(5);

        return view('dashboard_vendas_cadastro', compact('veiculo','veiculos','clientes', 'funcionarios'));
    }

    public function create(Request $request){

        $precoVenda = str_replace('.', '', $request->input('precoVenda'));

        $request->merge(['precoVenda' => $precoVenda]);

        $request->validate([
            'veiculo' => 'required|integer',
            'cliente' => 'required|integer',
            'funcionario' => 'required|integer',
            'data' => 'required|date',
            'precoVenda' => 'required|numeric',
            'descricao' => 'nullable|string',
        ]);

        Venda::create([
            'ID_Veiculo' => $request->veiculo,
            'ID_Cliente' => $request->cliente,
            'ID_Funcionario' => $request->funcionario,
            'Data' => $request->data,
            'PrecoVenda' => $request->precoVenda,
            'Descricao' => $request->descricao ?: null,
        ]);

        $veiculo = Veiculo::where('ID', $request->veiculo)->update(['Em_Estoque'=>0]);

        return redirect()->route('dashboard.veiculos')->with('success', 'Venda realizada com sucesso!');

    }

    public function delete($id){
        $venda = Venda::find($id);

        $idveiculo = $venda->ID_Veiculo;

        $veiculo = Veiculo::find($idveiculo);

        if($veiculo){
            $veiculo->update(['Em_Estoque'=>1]);
        }

        $deleted = $venda->delete();
        
        if ($deleted) {
            return redirect()->route('dashboard.veiculos')->with('success', 'Venda deletada com sucesso!');
        } else {
            return redirect()->route('dashboard.veiculos')->with('error', 'Ocorreu um erro ao deletar a venda.');
        }
    }

}