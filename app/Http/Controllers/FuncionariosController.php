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
        
        return redirect()->back()->with('success', 'Funcionário cadastrado com sucesso!');
    }

    public function delete($id)
    {
        $deleted = Funcionario::where('ID', $id)->delete();
        
        if ($deleted) {
            return redirect()->back()->with('success', 'Funcionário deletado com sucesso!');
        } else {
            return redirect()->back()->withErrors(['funcionario' => 'Funcionário não encontrado.']);
        }
    }


    public function edit($id)
    {
        $funcionarios = Funcionario::with('cargo')->get();
        $funcionario = Funcionario::findOrFail($id);

        return view('dashboard_funcionarios_edit', compact('funcionario'), compact('funcionarios'));
    }

    public function update(Request $request, $id)
    {

        $funcionario = Funcionario::findOrFail($id);
        $funcionario->update($request->all());
    
        return redirect()->route('dashboard.funcionarios');
    }
}