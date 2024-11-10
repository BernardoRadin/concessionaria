<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriasController extends Controller
{
    public function create(Request $request)
    {

        $request->validate([
            'nome' => 'required|string|max:100',
        ]);

        Categoria::create([
            'Nome' => $request->nome,
        ]);

        return redirect()->route('dashboard.categorias')->with('success', 'Categoria cadastrado com sucesso!');

    }

    public function edit($id)
    {
        $categorias = Categoria::paginate(7);

        $categoria = Categoria::find($id);

        if(!$categoria){
            return redirect()->route('dashboard.categorias')->with('error', 'Categoria não encontrada!');
        }

        return view('dashboard_categorias_edit', compact('categorias'), compact('categoria'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'Nome' => 'required|string|max:100',
        ]);

        $categoria = Categoria::find($id);

        if(!$categoria){
            return redirect()->back()->with('error', 'Categoria não encontrada!');
        }

        $categoria->update($request->all());
    
        return redirect()->route('dashboard.categorias')->with('success', 'Categoria alterada com sucesso!');;
    }

    public function delete($id)
    {
        
        $deleted = Categoria::where('ID', $id)->delete();
        
        if ($deleted) {
            return redirect()->route('dashboard.categorias')->with('success', 'Categoria deletado com sucesso!');
        } else {
            return redirect()->route('dashboard.categorias')->withErrors(['Categoria' => 'Categoria não encontrado.']);
        }
    }

}
