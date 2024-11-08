<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriasController extends Controller
{
    public function create(Request $request)
    {

        Categoria::create([
            'Nome' => $request->nome,
        ]);

        return redirect()->back()->with('success', 'Categoria cadastrado com sucesso!');

    }

    public function edit($id)
    {
        $categorias = Categoria::all();
        $categoria = Categoria::findOrFail($id);

        return view('dashboard_categorias_edit', compact('categorias'), compact('categoria'));
    }

    public function update(Request $request, $id)
    {

        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->all());
    
        return redirect()->route('dashboard.categorias');
    }

    public function delete($id)
    {
        
        $deleted = Categoria::where('ID', $id)->delete();
        
        if ($deleted) {
            return redirect()->back()->with('success', 'Categoria deletado com sucesso!');
        } else {
            return redirect()->back()->withErrors(['Categoria' => 'Categoria não encontrado.']);
        }
    }

}
