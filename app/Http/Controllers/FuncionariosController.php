<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionario;
use Illuminate\Support\Facades\DB;

class FuncionariosController extends Controller
{
    public function create(Request $request){

        $dataFormatada = date('Y-m-d', strtotime($request->dataNasc));

        Funcionario::create([
            'Nome' => $request->nome,
            'Senha' => $request->senha,
            'CPF' => $request->cpf,
            'Email' => $request->email,
            'Sexo' => $request->sexo,
            'DataNasc' => $dataFormatada,
            'Telefone' => $request->telefone,
            // 'Endereco' => $request->endereco,
            'ID_Cargo' => $request->id_cargo,
        ]);

        return redirect()->back()->with('success', 'Funcionário cadastrado com sucesso!');

    }

    public function delete($id){
        $deleted = DB::table('funcionarios')->where('ID', $id)->delete();
        
        if ($deleted) {
            return redirect()->back()->with('success', 'Funcionário deletado com sucesso!');
        } else {
            return redirect()->back()->withErrors(['funcionario' => 'Funcionário não encontrado.']);
        }

    }

}
