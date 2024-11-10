<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClientesController extends Controller
{

    public function create(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:50',
            'email' => 'required|email|max:50',
            'dataNasc' => 'required|date_format:Y-m-d',
            'sexo' => 'required|in:M,F',
            'cpf' => 'required|size:14',
            'telefone' => 'required|size:15',
            'endereco' => 'nullable|string|max:200',
            'descricao' => 'nullable|string|max:500',
        ]);

        $dataFormatada = date('Y-m-d', strtotime($request->dataNasc));

        Cliente::create([
            'Nome' => $request->nome,
            'Email' => $request->email,
            'DataNasc' => $dataFormatada,
            'Sexo' => $request->sexo,
            'CPF' => $request->cpf,
            'Telefone' => $request->telefone,
            'Endereco' => $request->endereco,
            'Descricao' => $request->descricao,
        ]);

        return redirect()->route('dashboard.clientes')->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function delete($id)
    {
        $deleted = Cliente::where('ID', $id)->delete();
        
        if ($deleted) {
            return redirect()->route('dashboard.clientes')->with('success', 'Cliente deletado com sucesso!');
        } else {
            return redirect()->route('dashboard.clientes')->with('error', 'Ocorreu um erro ao deletar o cliente!');
        }
    }

    public function edit($id)
    {
        $clientes = Cliente::all();

        $cliente = Cliente::find($id);

        if(!$cliente){
            return redirect()->route('dashboard.clientes')->with('error', 'Cliente não encontrado!');
        }

        return view('dashboard_clientes_edit', compact('cliente'), compact('clientes'));
    }

    public function update(Request $request, $id)
    {

        $cliente = Cliente::find($id);

        if(!$cliente){
            return redirect()->route('dashboard.clientes')->with('error', 'Cliente não encontrado!');
        }

        $request->validate([
            'Nome' => 'required|string|max:50',
            'Email' => 'required|email|max:50',
            'DataNasc' => 'required|date_format:Y-m-d',
            'Sexo' => 'required|in:M,F',
            'CPF' => 'required|size:14',
            'Telefone' => 'required|size:15',
            'Endereco' => 'nullable|string|max:200',
            'Descricao' => 'nullable|string|max:500',
        ]);

        $cliente->update($request->all());
    
        return redirect()->route('dashboard.clientes')->with('success', 'Cliente alterado com sucesso!');;
    }
}
