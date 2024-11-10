<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;

class MarcasController extends Controller
{

    public function create(Request $request)
    {

        $request->validate([
            'nome' => 'required|max:250',
            'logo' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $nomeimagem = md5($request->nome.date("Y-m-d H:i:s")) . '.' . $request->logo->extension();
        $path = 'imagens/marcas/'.$nomeimagem;

        if($request->logo->move(public_path('imagens/marcas/'), $nomeimagem)){

            Marca::create([
                'Nome' => $request->nome,
                'Logo' => $path,
            ]);

        }

        return redirect()->route('dashboard.marcas')->with('success', 'Marca cadastrado com sucesso!');
    }

    public function delete($id)
    {
        $marca = Marca::find($id);
        $pathImage = $marca->Logo;
        $deleted = $marca->delete();

        if ($deleted && unlink($pathImage)) {
            return redirect()->route('dashboard.marcas')->with('success', 'Marca deletada com sucesso!');
        } else {
            return redirect()->route('dashboard.marcas')->with('error', 'Ocorreu um erro ao deletar a Marca');
        }
    }


    public function edit($id)
    {
        $marcas = Marca::all();
        $marca = Marca::find($id);

        if(!$marca){
            return redirect()->route('dashboard.marcas')->with('error', 'Marca não encontrada');
        }

        return view('dashboard_marcas_edit', compact('marca'), compact('marcas'));
    }

    public function update(Request $request, $id)
    {

        $marca = Marca::find($id);

        if(!$marca){
            return redirect()->route('dashboard.marcas')->with('error', 'Marca não encontrada');
        }

        $request->validate([
            'nome' => 'required|max:250',
            'logo' => 'image|mimes:jpeg,png,jpg',
        ]);

        
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
    
        return redirect()->route('dashboard.marcas')->with('success', 'Marca alterada com sucesso');;
    }
}
