<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concessionária</title>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body>

<nav>
    <a href="{{ route('home')}}"><img src="{{ asset("$site->Logo")}}" style='width: 50px'/></a>
    <a href="{{ route('home')}}">Tela Inicial</a>
    <a href="{{ route('home.veiculos')}}">Veículos</a>
    <a href="{{ route('home.sobre')}}">Sobre</a>
</nav>
<div class='container-principal'>
    @yield('content_site')
</div>
<footer>
    <p>O melhor carro está aqui!</p>
    <a href="{{ $site->Facebook}}" target="_blank"><img src="{{ asset('imagens/site/facebook.png') }}" alt="Icone Facebook"></a>
    <a href="{{ $site->Instagram}}" target="_blank"><img src="{{ asset('imagens/site/instagram.png') }}" alt="Icone Instagram"></a>
    <a href="{{ $site->Whatsapp}}" target="_blank"><img src="{{ asset('imagens/site/whatsapp.png') }}" alt="Icone WhatsApp"></a>
</footer>

</body>
</html>
