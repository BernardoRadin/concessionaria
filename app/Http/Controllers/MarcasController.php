<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarcasController extends Controller
{

    public function create(Request $request)
    {
        Funcionario::create([
            'Nome' => $request->nome,
            'Logo' => $request->senha,
        ]);
        
        return redirect()->back()->with('success', 'Funcionário cadastrado com sucesso!');
    }

    public function delete($id)
    {
        $deleted = Marca::where('ID', $id)->delete();
        
        if ($deleted) {
            return redirect()->back()->with('success', 'Funcionário deletado com sucesso!');
        } else {
            return redirect()->back()->withErrors(['funcionario' => 'Funcionário não encontrado.']);
        }
    }


    public function edit($id)
    {
        $marcas = Marca::all();
        $marca = Marca::findOrFail($id);

        return view('dashboard_marcas_edit', compact('marca'), compact('marcas'));
    }

    public function update(Request $request, $id)
    {

        $marca = Funcionario::findOrFail($id);
        $marca->update($request->all());
    
        return redirect()->route('dashboard.marcas');
    }
}
