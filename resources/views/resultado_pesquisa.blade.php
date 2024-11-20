@extends('home')

@section('content_site')
<h1 class="titulo-veiculos">Resultados da Busca</h1>

<div class="veiculos-lista">
    @if($veiculos->isEmpty())
        <p>Nenhum veículo encontrado com os critérios de busca.</p>
    @else
        @foreach($veiculos as $veiculo)
            <div class="veiculo-card">
                <img src="{{ asset($veiculo->imagem) }}" alt="{{ $veiculo->modelo }}">
                <h3>{{ $veiculo->modelo }}</h3>
                <p>Preço: R$ {{ number_format($veiculo->preco, 2, ',', '.') }}</p>
                <p>Ano: {{ $veiculo->ano }}</p>
                <p>Quilometragem: {{ $veiculo->quilometragem }} km</p>
                <p>Câmbio: {{ ucfirst($veiculo->cambio) }}</p>
                <p>Marca: {{ $veiculo->marca->nome }}</p>
            </div>
        @endforeach
    @endif
</div>
@endsection