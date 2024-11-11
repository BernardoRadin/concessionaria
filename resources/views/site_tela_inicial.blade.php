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
            <img src="{{ asset($veiculo->fotoprincipal->Foto ?? 'caminho/para/imagem_padrao.jpg') }}" alt="Nissan KICKS">
            <h2>{{$veiculo->Nome}}</h2>
            <b><p>{{$veiculo->Ano}}</p></b>
            <p>{{$veiculo->Cambio}}</p>
            <p>{{ number_format($veiculo->Quilometragem, 0, ',', '.') }} KM</p>
            <a href="{{ route('home.veiculo', ['id'=> $veiculo->ID])}}"><button type="button" class="botao-carro">R$ {{ number_format($veiculo->PrecoVenda,2, ',', '.') }}</button></a>
        </div>
    @endforeach
</div>

@endsection