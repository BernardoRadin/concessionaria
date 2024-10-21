<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionario;
use App\Models\Cargo;

class FuncionariosController extends Controller
{
    public function index()
    {
        // Carrega todos os funcionários com os cargos
        $funcionarios = Funcionario::with('cargo')->get();
        
        // Retorna a view passando os funcionários
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
        // Carrega o funcionário com o cargo
        $funcionario = Funcionario::with('cargo')->findOrFail($id);


        return view('funcionarios.edit', compact('funcionario', 'cargos')); // Retorna a view de edição
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email',
            'telefone' => 'required|string|max:15',
        ]);

        $funcionario = Funcionario::findOrFail($id);
        $funcionario->update($request->all()); // Atualiza todos os campos

        return redirect()->route('funcionarios.index')->with('success', 'Funcionário atualizado com sucesso!');
    }
}