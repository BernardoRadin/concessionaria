@extends('home')

@section('content_site')

<h1 class="titulo-veiculos">Encontre seu Veículo</h1>

<div class="filtros">
    <form action="#" method="get" class="filtro-formulario">
        <div class="filtro-campos">
            <div class="campo">
                <label for="modelo">Modelo</label>
                <input type="text" id="modelo" placeholder="Ex: Sedan" name="modelo" class="campo-modelo">
            </div>
            <div class="campo">
                <label for="quilometragem">Quilometragem Máxima</label>
                <input type="number" id="quilometragem" placeholder="Digite a Quilometragem" name="quilometragem" class="campo-quilometragem">
            </div>
            <div class="campo">
                <label for="preco-maximo">Preço Máximo</label>
                <input type="number" id="preco-maximo" placeholder="Digite o Valor Maximo" name="preco-maximo" class="campo-preco-maximo">
            </div>
            <div class="campo">
                <label for="ano-de">Ano De:</label>
                <input type="number" id="ano-de" placeholder="Digite o Ano" name="ano-de" class="campo-ano-de campo-menor">
            </div>
            <div class="campo">
                <label for="ano-de">Ano Até:</label>
                <input type="number" id="ano-ate" placeholder="Digite o Ano" name="ano-ate" class="campo-ano-ate campo-menor">
            </div>
            <div class="campo">
                <label for="condicao">Condição</label>
                <select id="condicao" name="condicao" class="campo-condicao campo-menor">
                    <option value="" disabled selected></option>
                    <option value="novo">Novo</option>
                    <option value="usado">Usado</option>
                </select>
            </div>
        </div>        
        <div class="filtro-marcas">
            <img src="{{ asset('imagens/site/logo-mitsubishi-512.png') }} " alt="Mitsubishi">
            <img src="{{ asset('imagens/site/logo-volkswagen-512.png') }} " alt="Volkswagen">
            <img src="{{ asset('imagens/site/logo-bmw-512.png') }}" alt="BMW">
            <img src="{{ asset('imagens/site/logo-ford-512.png') }}" alt="Ford">
            <img src="{{ asset('imagens/site/logo-porsche-512.png') }}" alt="Porsche">
            <img src="{{ asset('imagens/site/chevrolet-512.png') }}" alt="Chevrolet">
            <img src="{{ asset('imagens/site/logo-fiat-512.png') }}" alt="Fiat">
            <img src="{{ asset('imagens/site/logo-peugeot-512.png') }}" alt="Pegeout">
        </div>
        <button type="submit" class="botao-buscar">Buscar</button>
    </form>
</div>


@endsection