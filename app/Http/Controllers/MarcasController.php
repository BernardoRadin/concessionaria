<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;

class MarcasController extends Controller
{

    public function create(Request $request)
    {

        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $nomeimagem = md5($request->nome.date("Y-m-d H:i:s")) . '.' . $request->logo->extension();
        $path = 'imagens/marcas/'.$nomeimagem;

        if($request->logo->move(public_path('imagens/marcas/'), $nomeimagem)){

            Marca::create([
                'Nome' => $request->nome,
                'Logo' => $path,
            ]);

            return redirect()->back()->with('success', 'Marca cadastrado com sucesso!');

        }
        
    }

    public function delete($id)
    {
        $marca = Marca::where('ID', $id)->first();
        $pathImage = $marca->Logo;
        $deleted = Marca::where('ID', $id)->delete();
        
        if ($deleted && unlink($pathImage)) {
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

        $request->validate([
            'logo' => 'image|mimes:jpeg,png,jpg',
        ]);

        $marca = Marca::findOrFail($id);
        
        $pathImagem = $marca->Logo;

        if ($request->hasFile('logo')) {

            if (file_exists(public_path($pathImagem))) {
                unlink(public_path($pathImagem));
            }    

            $nomeimagem = md5($request->nome.date("Y-m-d H:i:s")) . '.' . $request->logo->extension();
            $pathNovaImagem = 'imagens/marcas/'.$nomeimagem;    
            
            if($request->logo->move(public_path('imagens/marcas/'), $nomeimagem)){
                $marca->Logo = $pathNovaImagem;
            }
        }

        $marca->Nome = $request->nome;

        $marca->update($request->except('logo')); 
    
        return redirect()->route('dashboard.marcas');
    }
}
