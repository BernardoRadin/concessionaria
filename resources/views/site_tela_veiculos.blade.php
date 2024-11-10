@extends('home')

@section('content_site')

<h1 class="titulo-veiculos">Encontre seu Veículo</h1>

<div class="filtros">
    <form action="#" method="get" class="filtro-formulario">
        <div class="filtro-campos">
            <div class="campo">
                <label for="categoria">Modelo</label>
                <select id="categoria" name="categoria" class="campo-categoria campo-menor">
                    <option value="" disabled selected>Selecione um Modelo</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->ID }}">{{ $categoria->Nome }}</option>
                    @endforeach
                </select>
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
                <label for="cambio">Câmbio</label>
                <select id="cambio" name="cambio" class="campo-condicao campo-menor">
                    <option value="" disabled selected>Selecione o Câmbio</option>
                    <option value="automatico">Automático</option>
                    <option value="manual">Manual</option>
                </select>
            </div>
        </div>        
        <div class="filtro-marcas">
            @foreach($marcas as $marca)
            <img src="{{ asset("$marca->Logo") }} " alt="{{ $marca->Nome }}">
            @endforeach
        </div>
        <button type="submit" class="botao-buscar">Buscar</button>
    </form>
</div>


@endsection