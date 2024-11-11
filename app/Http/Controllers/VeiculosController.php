<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Veiculo;
use App\Models\Fotos;
use App\Models\Marca;
use App\Models\Categoria;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;

class VeiculosController extends Controller
{

    public function view($id){
        $veiculos = Veiculo::with('categoria','marca','antigodono','funcionario','fotos')->paginate(3);
        $veiculo = Veiculo::with('fotos')->find($id);

        if(!$veiculo){
            return redirect()->route('dashboard.veiculos')->with('error', 'Veículo não encontrado!');
        }

        return view('dashboard_veiculos_view', compact('veiculo','veiculos'));

    }

    public function create(Request $request)
    {

        $precoVenda = str_replace('.', '', $request->input('precovenda'));
        $precoCusto = str_replace('.', '', $request->input('precocusto'));
        $quilometragem = str_replace('.', '', $request->input('quilometragem'));

        $request->merge(['precovenda' => $precoVenda, 'precocusto' => $precoCusto, 'quilometragem' => $quilometragem]);        

        $request->validate([
            'nome' => 'required|string|max:255',
            'ano' => 'required|integer',
            'portas' => 'required|integer',
            'cambio' => 'required|string',
            'motor' => 'required|string',
            'quilometragem' => 'required|numeric',
            'combustivel' => 'required|string',
            'categoria' => 'required|integer',
            'marca' => 'required|integer',
            'cor' => 'required|string',
            'precocusto' => 'required|numeric',
            'precovenda' => 'required|numeric',
            'estoque' => 'required|integer',
            'antigodono' => 'nullable|integer',
            'descricao' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'principal' => 'required|integer',
        ]);

        $funcionariologin = Auth::user();

        // Criação do veículo
        $veiculo = new Veiculo();
        $veiculo->Nome = $request->nome;
        $veiculo->Ano = $request->ano;
        $veiculo->Porta = $request->portas;
        $veiculo->Cambio = $request->cambio;
        $veiculo->Motor = $request->motor;
        $veiculo->Quilometragem = $request->quilometragem;
        $veiculo->Combustivel = $request->combustivel;
        $veiculo->Cor = $request->cor;
        $veiculo->PrecoCusto = $precoCusto;
        $veiculo->PrecoVenda = $precoVenda;
        $veiculo->Em_Estoque = $request->estoque;
        $veiculo->Descricao = $request->descricao;
        $veiculo->ID_Categoria = $request->categoria;
        $veiculo->ID_Marca = $request->marca;
        $veiculo->ID_AntigoDono = $request->antigodono;
        $veiculo->ID_Funcionario = $funcionariologin->ID;
        $veiculo->save();

        // Upload das imagens
        if ($request->hasFile('images')) {
            $i=0;
            foreach ($request->file('images') as $index => $image) {
                $i++;
                $nomeimagem = md5($request->nome.date("Y-m-d H:i:s").$i) . '.' . $image->extension();
                $path = 'imagens/veiculos/'.$nomeimagem;
                $image->move(public_path('imagens/veiculos/'), $nomeimagem);

                $foto = new Fotos();
                $foto->Foto = $path;
                $foto->Principal = ($index == $request->principal);
                $foto->ID_Veiculo = $veiculo->ID;
                $foto->save();
            }
        }
        return redirect()->route('dashboard.veiculos')->with('success', 'Veículo cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $veiculos = Veiculo::with('categoria','marca','antigodono','funcionario','fotos')->paginate(3);
        $veiculo = Veiculo::with('fotos')->find($id);

        if(!$veiculo){
            return redirect()->route('dashboard.veiculos')->with('error', 'Veículo não encontrado!');
        }

        $categorias = Categoria::all();
        $marcas = Marca::all();
        $clientes = Cliente::all();

        return view('dashboard_veiculos_edit', compact('veiculo','veiculos', 'categorias', 'marcas', 'clientes'));
        
    }

    public function update(Request $request, $id){


        $precoVenda = str_replace('.', '', $request->input('precovenda'));
        $precoCusto = str_replace('.', '', $request->input('precocusto'));
        $quilometragem = str_replace('.', '', $request->input('quilometragem'));

        $request->merge(['precovenda' => $precoVenda, 'precocusto' => $precoCusto, 'quilometragem' => $quilometragem]);        

        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'ano' => 'required|integer',
            'porta' => 'required|integer',  
            'cambio' => 'required|string',
            'motor' => 'required|string',
            'quilometragem' => 'required|numeric',
            'combustivel' => 'required|string',
            'categoria' => 'required|integer',
            'marca' => 'required|integer',
            'cor' => 'required|string',
            'precocusto' => 'required|numeric',
            'precovenda' => 'required|numeric',
            'estoque' => 'required|integer',
            'antigodono' => 'nullable|integer',
            'descricao' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'principal' => 'required|integer',
        ]);
        
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'image-') === 0) {
                $request->validate([
                    $key => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);
            }
        }

        $funcionariologin = Auth::user();

        $veiculo = Veiculo::with('fotos')->find($id);

        if(!$veiculo){
            return redirect()->route('dashboard.veiculos')->with('error', 'Veículo não encontrado!');
        }

        $veiculo->update([
            'Nome' => $validatedData['nome'],
            'Ano' => $validatedData['ano'],
            'Porta' => $validatedData['porta'],
            'Cambio' => $validatedData['cambio'],
            'Motor' => $validatedData['motor'],
            'Quilometragem' => $validatedData['quilometragem'],
            'Combustivel' => $validatedData['combustivel'],
            'Cor' => $validatedData['cor'],
            'PrecoCusto' => $validatedData['precocusto'],
            'PrecoVenda' => $validatedData['precovenda'],
            'Em_Estoque' => $validatedData['estoque'],
            'Descricao' => $validatedData['descricao'],
            'ID_Categoria' => $validatedData['categoria'],
            'ID_Marca' => $validatedData['marca'],
            'ID_AntigoDono' => $validatedData['antigodono'],
            'ID_Funcionario' => $funcionariologin->ID,
        ]);
    
        // Atualize os dados do veículo
        $veiculo->update($validatedData);

        foreach ($veiculo->fotos as $index => $foto) {
            $imageInputName = 'image-' . $foto->ID;
            if ($request->hasFile($imageInputName)) {
                $nomenovaimagem = md5($request->nome.date("Y-m-d H:i:s").$foto->ID) . '.' .  $request->file($imageInputName)->extension();
                $path = 'imagens/veiculos/'.$nomenovaimagem;
                $request->file($imageInputName)->move(public_path('imagens/veiculos/'), $nomenovaimagem);
                
                $foto = Fotos::find($foto->ID);
                $pathImageDelete = $foto->Foto;
                if (unlink(public_path($pathImageDelete))) {
                    $foto->Foto = $path;
                }
            }
        
            if($foto->ID == $validatedData['principal']){
                $principal = 1;
            }else{
                $principal = 0;
            }

            $foto->Principal = $principal; 
            $foto->save();

        }

        return redirect()->route('dashboard.veiculos')->with('success', 'Veículo alterado com sucesso!');

    }

    public function delete($id){
        $veiculo = Veiculo::with('fotos')->find($id);

        foreach($veiculo->fotos as $foto){
            $fotoPath = public_path($foto->Foto);
            if (file_exists($fotoPath) && unlink($fotoPath)) {
                $foto->delete(); 
            } else {
                return redirect()->route('dashboard.veiculos')->with('error', 'Ocorreu um erro ao deletar o veículo!');
            }
        }

        if($veiculo->delete()){
            return redirect()->route('dashboard.veiculos')->with('success', 'Veículo deletado com sucesso!');
        }else{
            return redirect()->route('dashboard.veiculos')->with('error', 'Ocorreu um erro ao deletar o veículo!');
        
        }
    }

}