<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClientesController extends Controller
{

    public function create(Request $request)
    {
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

        return redirect()->back()->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function delete($id)
    {
        $deleted = Cliente::where('ID', $id)->delete();
        
        if ($deleted) {
            return redirect()->back()->with('success', 'Cliente deletado com sucesso!');
        } else {
            return redirect()->back()->withErrors(['funcionario' => 'Cliente não encontrado.']);
        }
    }


    public function edit($id)
    {
        $clientes = Cliente::all();
        $cliente = Cliente::findOrFail($id);

        return view('dashboard_clientes_edit', compact('cliente'), compact('clientes'));
    }

    public function update(Request $request, $id)
    {

        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());
    
        return redirect()->route('dashboard.clientes');
    }
}
