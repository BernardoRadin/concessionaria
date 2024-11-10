<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;

class SiteController extends Controller
{
    public function update(Request $request){

        $site = Site::first();

        $pathImagem = $site->Logo;

        $request->validate([
            'email' => 'required|email',
            'telefone' => 'required|string|size:15',
            'whatsapp' => 'required|string|size:14',
            'instagram' => 'nullable|string|url',
            'facebook' => 'nullable|string|url',
            'endereco' => 'required|string|max:255',
            'sobre' => 'nullable|string|max:1000',
            'logo' => 'image|mimes:jpeg,png,jpg',
        ]);

        if ($request->hasFile('logo')) {

            if (file_exists(public_path($pathImagem))) {
                unlink(public_path($pathImagem));
            }    

            $nomeimagem = md5($request->nome.date("Y-m-d H:i:s")) . '.' . $request->logo->extension();
            $pathNovaImagem = 'imagens/logo/'.$nomeimagem;    
            
            if($request->logo->move(public_path('imagens/logo/'), $nomeimagem)){
                $site->Logo = $pathNovaImagem;
            }
        }

        $site->Email = $request->email;
        $site->Telefone = $request->telefone;
        $site->Whatsapp = $request->whatsapp;
        $site->Instagram = $request->instagram;
        $site->Facebook = $request->facebook;
        $site->Endereco = $request->endereco;
        $site->Sobre = $request->sobre;

        if($site->update($request->except('logo'))){
            return redirect()->route('dashboard.site')->with('success', 'Informações do site alteradas com sucesso!');
        }else{
            return redirect()->route('dashboard.site')->with('error', 'Ocorreu um erro ao salvar as informações!');
        }
    }
}
