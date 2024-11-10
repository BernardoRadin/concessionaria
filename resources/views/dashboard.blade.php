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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
    </script>
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
                    <li><a href="{{ route('dashboard.site') }}">Gestão Site</a></li>
                    <li><a href="index.html">Voltar ao Site</a></li>
                </ul>
            </nav>
        </aside>

        <main class="content">
            <header class="header">
                <div class="search-bar">
                    {{-- <input type="text" placeholder="Search..."> --}}
                </div>
                <div class="user-profile">
                    <div class="profile-picture">
                        {{-- <img src="profile.jpg" alt="Foto do Usuário"> --}}
                    </div>
                    <div class="dropdown">
                        <div class="username" style="cursor: pointer;">
                            <span>{{ $user->Nome }}</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="dropdown-content">
                            <a href="{{ route('login.logout') }}">Sair</a>
                        </div>
                    </div>                
                </div>
            </header>

            <section class="main-content">
                @yield('content_dashboard')
                <div class='div-canva'>
                    @if (!View::hasSection('content_dashboard'))
                        <canvas id="burnUpChart"></canvas>
                    @endif
                </div>
            </section>
        </main>
    </div>

</body>
</html>
<script>

const ctx = document.getElementById('burnUpChart').getContext('2d');

const burnUpChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4', 'Semana 5'],
        datasets: [{
            label: 'Trabalho Completo',
            data: [0, 10, 30, 50, 70],
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            fill: true,
        }, {
            label: 'Objetivo Total',
            data: [100, 100, 100, 100, 100],
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            fill: false,
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Pontos'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Semanas'
                }
            }
        }
    }
});

</script>