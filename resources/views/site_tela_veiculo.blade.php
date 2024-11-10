@extends('home')

@section('content_site')

<div class="car-destaque">
    <div class="car-header">
        <h1>{{$veiculo->Nome}}</h1>
        <p>{{$veiculo->Nome}}</p>
    </div>

    <div class="car-content">
        <div class="car-image">
            <img src="{{ asset($veiculo->fotoprincipal->Foto)}}" alt="Carro em Destaque">
        </div>
        <div class="car-info">
            <ul class="car-details">
                <li><img src="{{ asset('imagens/site/calendario.png') }}" alt="Ano"> <strong>Ano: </strong> <span class="car-value">{{$veiculo->Ano}}</span></li>
                <li><img src="{{ asset('imagens/site/cambio-de-marchas.png') }}" alt="Câmbio"> <strong>Câmbio: </strong> <span class="car-value">{{$veiculo->Cambio}}</span></li>
                <li><img src="{{ asset('imagens/site/motor-de-carro.png') }}" alt="Motor"> <strong>Motor: </strong> <span class="car-value">{{$veiculo->Motor}}</span></li>
                <li><img src="{{ asset('imagens/site/posto-de-gasolina.png') }}" alt="Combustível"> <strong>Combustível: </strong> <span class="car-value">{{ $veiculo->Combustivel == 'A' ? 'Álcool' : ($veiculo->Combustivel == 'G' ? 'Gasolina' : ($veiculo->Combustivel == 'E' ? 'Elétrico' : ($veiculo->Combustivel == 'F' ? 'Álcool e Gasolina' : 'Diesel'))) }}</span></li>
                <li><img src="{{ asset('imagens/site/quilometragem.png') }}" alt="Quilometragem"> <strong>Quilometragem: </strong> <span class="car-value">{{ number_format($veiculo->Quilometragem, 0, ',', '.') }}</span></li>
                <li><img src="{{ asset('imagens/site/porta-do-carro.png') }}" alt="Portas"> <strong>Portas: </strong> <span class="car-value">{{$veiculo->Porta}}</span></li>
                <li><img src="{{ asset('imagens/site/quadro.png') }}" alt="Cor"> <strong>Cor: </strong> <span class="car-value">{{$veiculo->Cor}}</span></li>
                <li><img src="{{ asset('imagens/site/carro.png') }}" alt="Modelo"> <strong>Modelo: </strong> <span class="car-value">{{$veiculo->categoria->Nome}}</span></li>

            </ul>
            <div class="preco">
                R$ {{ number_format($veiculo->PrecoVenda, 2, ',', '.') }}
            </div>
            <a href="https://api.whatsapp.com/send?phone={{$site->Whatsapp}}&text=Olá, Tenho interesse no veículo {{ $veiculo->Nome}}!" target="_blank" class="whatsapp-btn">
                <i class="fab fa-whatsapp"></i> Chamar no Whatsapp
            </a>
        </div>
    </div>
    <div class="car-gallery-container">
        <button class="car-gallery-btn prev-btn">
            <img src="{{ asset('imagens/site/seta-esquerda.png') }}" alt="Previous">
        </button>
        <div class="car-gallery">
            @foreach($veiculo->fotos as $foto)
                @if($foto->Principal == 0)
                <img src="{{ asset("$foto->Foto")}}" alt="Carro">
                @endif
            @endforeach
        </div>
        <button class="car-gallery-btn next-btn">
            <img src="{{ asset('imagens/site/seta-direita.png') }}" alt="Next">
        </button>
    </div>
</div>
@endsection
