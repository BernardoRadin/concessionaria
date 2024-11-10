<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionario;
use App\Models\Cargo;
use Illuminate\Support\Facades\DB;

class FuncionariosController extends Controller
{
    public function index()
    {
        $funcionarios = Funcionario::with('cargo')->get();
        
        return view('funcionarios.index', compact('funcionarios'));
    }

    public function create(Request $request)
    {
        
        $request->validate([
            'nome' => 'required|string|max:50',
            'senha' => 'required|string|min:8|max:14',
            'cpf' => 'required|size:14',
            'email' => 'required|email|max:50',
            'sexo' => 'required|in:M,F',
            'dataNasc' => 'required|date_format:Y-m-d',
            'telefone' => 'required|max:15',
            'id_cargo' => 'nullable|integer',
            'endereco' => 'nullable|string|max:200',
        ]);

        $dataFormatada = date('Y-m-d', strtotime($request->dataNasc));

        Funcionario::create([
            'Nome' => $request->nome,
            'Senha' => $request->senha,
            'CPF' => $request->cpf,
            'Email' => $request->email,
            'Sexo' => $request->sexo,
            'DataNasc' => $dataFormatada,
            'Telefone' => $request->telefone,
            'ID_Cargo' => $request->id_cargo,
            'Endereco' => $request->endereco,
        ]);
        
        return redirect()->route('dashboard.funcionarios')->with('success', 'Funcionário cadastrado com sucesso!');
    }

    public function delete($id)
    {
        $deleted = Funcionario::find($id);
        
        if ($deleted) {
            return redirect()->route('dashboard.funcionarios')->with('success', 'Funcionário deletado com sucesso!');
        } else {
            return redirect()->route('dashboard.funcionarios')->with('error', 'Ocorreu um erro ao deletar o funcionário.');
        }
    }


    public function edit($id)
    {
        $funcionarios = Funcionario::with('cargo')->get();
        $funcionario = Funcionario::find($id);

        if(!$funcionario){
            return redirect()->route('dashboard.funcionarios')->with('error', 'Funcionário não encontrado.');
        }

        return view('dashboard_funcionarios_edit', compact('funcionario'), compact('funcionarios'));
    }

    public function update(Request $request, $id)
    {

        $funcionario = Funcionario::find($id);

        if(!$funcionario){
            return redirect()->route('dashboard.funcionarios')->with('error', 'Funcionário não encontrado.');
        }

        $request->validate([
            'Nome' => 'required|string|max:50',
            'Senha' => 'required|string|min:8|max:14',
            'CPF' => 'required|size:14',
            'Email' => 'required|email|max:50',
            'Sexo' => 'required|in:M,F',
            'DataNasc' => 'required|date_format:Y-m-d',
            'Telefone' => 'required|size:15',
            'ID_Cargo' => 'nullable|integer',
            'Endereco' => 'nullable|string|max:200',
        ]);

        $funcionario->update($request->all());
    
        return redirect()->route('dashboard.funcionarios')->with('success', 'Funcionário alterado com sucesso!');;
    }
}