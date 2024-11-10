<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\Veiculo;
use App\Models\Marca;
use App\Models\Categoria;

class HomeController extends Controller
{
    public function index(){
        $site = Site::first();
        $veiculos = Veiculo::with('fotoprincipal')->where('Em_Estoque', 1)->get();

        return view('site_tela_inicial',compact('site','veiculos'));
    }

    public function veiculos(){
        $site = Site::first();
        $veiculos = Veiculo::with('fotoprincipal')->where('Em_Estoque', 1)->get();
        $marcas = Marca::all();
        $categorias = Categoria::all();

        return view('site_tela_veiculos',compact('site','veiculos','marcas','categorias'));
    }

    public function sobre(){
        $site = Site::first();
        return view('site_tela_sobre',compact('site'));
    }

    public function veiculo($id){
        $site = Site::first();
        $veiculo = Veiculo::with('fotoprincipal','fotos','categoria')->find($id);
        return view('site_tela_veiculo',compact('site', 'veiculo'));
    }

}
