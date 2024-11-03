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
    public function index()
    {
        return view('dashboard_veiculos');
    }

    public function create(Request $request)
    {

        $request->validate([
            'nome' => 'required|string|max:255',
            'ano' => 'required|integer',
            'portas' => 'required|integer',
            'cambio' => 'required|string',
            'motor' => 'required|string',
            'quilometragem' => 'required|integer',
            'combustivel' => 'required|string',
            'categoria' => 'required|integer',
            'marca' => 'required|integer',
            'cor' => 'required|string',
            'precocusto' => 'required|numeric',
            'precovenda' => 'required|numeric',
            'estoque' => 'required|integer',
            'antigodono' => 'nullable|integer',
            'descricao' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validação para imagens
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
        $veiculo->PrecoCusto = $request->precocusto;
        $veiculo->PrecoVenda = $request->precovenda;
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

                // Criação da entrada na tabela Fotos
                $foto = new Fotos(); // Certifique-se de que você importou o modelo Foto
                $foto->Foto = $path; // Define o caminho da foto
                $foto->Principal = ($index == $request->principal); // Define se é a foto principal
                $foto->ID_Veiculo = $veiculo->ID; // Associa a foto ao veículo
                $foto->save(); // Salva a foto
            }
        }
        return redirect()->route('dashboard.veiculos')->with('success', 'Veículo cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $veiculos = Veiculo::with('categoria','marca','antigodono','funcionario','fotos')->get();
        $veiculo = Veiculo::with('fotos')->find($id);

        $categorias = Categoria::all();
        $marcas = Marca::all();
        $clientes = Cliente::all();

        return view('dashboard_veiculos_edit', compact('veiculo','veiculos', 'categorias', 'marcas', 'clientes'));
        
    }

    public function update(Request $request, $id){

        $validatedData = $request->validate([
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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validação para imagens
            'principal' => 'required|integer',
        ]);
    
        // Encontre o veículo pelo ID
    
        foreach ($request->all() as $key => $value) {
            // Verifica se o nome do input começa com 'image-' e se é um arquivo
            if (strpos($key, 'image-') === 0) {
                $request->validate([
                    $key => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
                ]);
            }
        }

        $funcionariologin = Auth::user();

        $veiculo = Veiculo::with('fotos')->findOrFail($id);

        $veiculo->update([
            'Nome' => $validatedData['nome'],
            'Ano' => $validatedData['ano'],
            'Porta' => $validatedData['portas'],
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
                
                $deleted = Fotos::where('ID', $foto->ID)->delete();
                $pathImageDelete = $foto->Foto;
                if ($deleted && unlink($pathImageDelete)) {
                    // Criação da entrada na tabela Fotos
                    $foto = new Fotos(); // Certifique-se de que você importou o modelo Foto
                    $foto->Foto = $path; // Define o caminho da foto
                }
            }

            $foto->Principal = ($index + 1 == $validatedData['principal']); 
            $foto->save(); // Salva as alterações

        }


    }

}