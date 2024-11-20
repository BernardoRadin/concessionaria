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
                <input type="text" id="quilometragem" placeholder="Digite a Quilometragem" name="quilometragem" class="campo-quilometragem">
            </div>
            <div class="campo">
                <label for="preco-maximo">Preço Máximo</label>
                <input type="text" id="preco-maximo" placeholder="Digite o Valor Maximo" name="preco-maximo" class="campo-preco-maximo">
            </div>
            <div class="campo">
                <label for="ano-de">Ano De:</label>
                <input type="text" id="ano-de" placeholder="Digite o Ano" name="ano-de" class="campo-ano-de campo-menor">
            </div>
            <div class="campo">
                <label for="ano-ate">Ano Até:</label>
                <input type="text" id="ano-ate" placeholder="Digite o Ano" name="ano-ate" class="campo-ano-ate campo-menor">
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

<script>
    // Máscara para Quilometragem (com "km" e separação de milhar)
    document.getElementById("quilometragem").addEventListener("input", function(event) {
        let value = this.value.replace(/\D/g, ''); // Remove caracteres não numéricos
        if (value.length > 9) {
            value = value.slice(0, 9); // Limita a 9 dígitos
        }
        if (value.length > 3) {
            value = value.replace(/(\d)(\d{3})$/, '$1.$2'); // Coloca o ponto separador de milhar
        }
        this.value = value ? value + " km" : ""; // Adiciona "km" ao final
    });

    // Máscara para Preço Máximo (moeda, limitado a até 9 dígitos e vírgula para os centavos)
    document.getElementById("preco-maximo").addEventListener("input", function(event) {
        let value = this.value.replace(/\D/g, ''); // Remove caracteres não numéricos
        if (value.length > 9) {
            value = value.slice(0, 9); // Limita a 9 dígitos
        }
        if (value.length > 3) {
            value = value.replace(/(\d)(\d{3})$/, '$1.$2'); // Adiciona o ponto separador de milhar
        }
        if (value.length > 6) {
            value = value.replace(/(\d{2})$/, ',$1'); // Coloca vírgula antes dos dois últimos dígitos
        }
        this.value = value ? 'R$ ' + value : ''; // Adiciona o prefixo 'R$'
    });

    // Máscara para Ano (somente 4 dígitos)
    document.getElementById("ano-de").addEventListener("input", function(event) {
        this.value = this.value.replace(/\D/g, '').slice(0, 4); // Permite apenas 4 dígitos numéricos
    });

    document.getElementById("ano-ate").addEventListener("input", function(event) {
        this.value = this.value.replace(/\D/g, '').slice(0, 4); // Permite apenas 4 dígitos numéricos
    });
</script>

@endsection
