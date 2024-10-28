<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css')}} ">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="logo">
                {{-- <img src="logo.png" alt="Logo da Empresa"> --}}
            </div>
            <nav class="menu">
                <ul>
                    <li><a href="{{ route('dashboard.index') }}">Inicio</a></li>
                    <li><a href="{{ route('dashboard.funcionarios') }}">Funcionarios</a></li>
                    <li><a href="{{ route('dashboard.marcas') }}">Marcas</a></li>
                    <li><a href="{{ route('dashboard.categorias') }}">Categorias</a></li>
                    <li><a href="{{ route('dashboard.clientes') }}">Clientes</a></li>
                    <li><a href="{{ route('dashboard.veiculos') }}">Veiculos</a></li>
                    <li><a href="{{ route('dashboard.vendas') }}">Vendas</a></li>
                    <li><a href="#">Gestao</a></li>
                    <li><a href="index.html">Voltar ao Site</a></li>
                </ul>
            </nav>
        </aside>

        <main class="content">
            <header class="header">
                <div class="search-bar">
                    <input type="text" placeholder="Search...">
                </div>
                <div class="user-profile">
                    <div class="notification">
                        <span>3</span>
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="profile-picture">
                        {{-- <img src="profile.jpg" alt="Foto do Usuário"> --}}
                    </div>
                    <div class="username">
                        <span>Christian</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </header>

            <section class="main-content">
                @yield('content_dashboard')
            </section>
        </main>
    </div>

</body>
</html>
