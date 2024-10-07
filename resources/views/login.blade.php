@extends('master')

@section('content')

{{-- <h2>Login</h2>

<form action="{{ route('login.store') }}" method="POST">
    @csrf
    <label>Email</label>
    <input type="text" name="email" value="">
    @error('email')
        <span>{{ $message }}</span>
    @enderror
    <label>Senha</label>
    <input type="password" name="password" value="">
    @error('password')
        <span>{{ $message }}</span>
    @enderror
    <button type="submit">Enviar</button>
    @error('error')
        {{ $message }}
    @enderror
</form> --}}

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso Admin - Concessionária</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <h1>TOP CAR CONCESSIONARIA</h1>
    </header>
    {{-- <a href="{{ route('home') }}">Home</a> --}}

    <div class="login-container">
        <h2>ACESSO ADMIN</h2>
        <form action="{{ route('login.store') }}" method="post">
            @csrf
            <div class="input-wrapper">
                <div class="icon-box">
                    <i class="fa-solid fa-user" style="color: #ffffff;"></i>
                </div>
                <input type="text" id="email" name="email" placeholder="Email">
            </div>
            {{-- <a href="#" class="forgot-password">Esqueci minha senha</a> --}}
            <div class="input-wrapper">
                <div class="icon-box">
                    <i class="fas fa-lock"></i>
                </div>
                <input type="password" id="password" name="password" placeholder="Senha">
            </div>
            @error('email')
                <span>{{ $message }}</span>
            @enderror    
            @error('password')
                <span>{{ $message }}</span>
            @enderror
                <button type="submit">Acessar</button>
            @if (session()->has('success'))
                {{ session()->get('success') }}
            @endif    
        </form>
    </div>
</body>
</html>
@endsection