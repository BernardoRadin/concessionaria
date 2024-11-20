@extends('home')

@section('content_site')

<div class="slider">
    <img src="{{ asset('imagens/site/Car Wash.png') }}" alt="Carro em Destaque">
</div>

<div id="search-bar">
    <input type="text" placeholder="Buscar veículo ...">
    <button>Buscar</button>
</div>

<h2 class="titulo-destaques">Destaques</h2>

<div class="destaques">
    @foreach($veiculos as $veiculo)
        <div class="carro">
            <div class="imagem-veiculo">
                <img src="{{ asset($veiculo->fotoprincipal->Foto ?? 'caminho/para/imagem_padrao.jpg') }}" alt="{{ $veiculo->Nome }}">
            </div>
            <div class="info-veiculo">
                <h2 class="nome-veiculo">{{ $veiculo->Nome }}</h2>
                <p class="ano-veiculo"><b>{{ $veiculo->Ano }}</b></p>
                <p class="cambio-veiculo">{{ $veiculo->Cambio }}</p>
                <p class="quilometragem-veiculo">{{ number_format($veiculo->Quilometragem, 0, ',', '.') }} KM</p>
                <div class="preco-veiculo">
                    <a href="{{ route('home.veiculo', ['id'=> $veiculo->ID])}}">
                        <button type="button" class="botao-carro">R$ {{ number_format($veiculo->PrecoVenda, 2, ',', '.') }}</button>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection