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
            <a href="{{ route('dashboard.index') }}">
                <div class="logo">
                    <img src="{{ asset($logo)}}" class='logo'/>
                </div>
            </a>
            <nav class="menu">
                <ul>
                    <li style='text-align: center'><h4>Cadastros</h4></li>
                    <li><a href="{{ route('dashboard.funcionarios') }}">Funcionarios</a></li>
                    <li><a href="{{ route('dashboard.marcas') }}">Marcas</a></li>
                    <li><a href="{{ route('dashboard.categorias') }}">Categorias</a></li>
                    <li><a href="{{ route('dashboard.clientes') }}">Clientes</a></li>
                    <li><a href="{{ route('dashboard.veiculos') }}">Veiculos</a></li>
                    <li><a href="{{ route('dashboard.vendas') }}">Vendas</a></li>
                    <li style='text-align: center'><h4>Site</h4></li>
                    <li><a href="{{ route('dashboard.site') }}">Gestão Site</a></li>
                    <li><a href="{{ route('home') }}">Voltar ao Site</a></li>
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
                        <h3>Gráfico Quantidade/Vendas/Data</h3></br>
                        <canvas id="burnUpChart"></canvas>
                        <script>
                            var ctx = document.getElementById('burnUpChart').getContext('2d');
                            var graficoVendas = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: @json($datas),
                                    datasets: [{
                                        label: 'Quantidade de Vendas',
                                        data: @json($quantidades),
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        fill: false,
                                        yAxisID: 'y'
                                    },
                                    {
                                        label: 'Valor Total',
                                        data: @json($valores),
                                        borderColor: 'rgba(255, 99, 132, 1)',
                                        fill: false,
                                        yAxisID: 'y1'
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            position: 'left',
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        },
                                        y1: {
                                            beginAtZero: true,
                                            position: 'right',
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }
                                    },
                                    plugins: {
                                        tooltip: {
                                            callbacks: {
                                                label: function(tooltipItem) {
                                                    let label = tooltipItem.dataset.label || '';
                                                    if (label) {
                                                        label += ': ';
                                                    }
                                                    if (tooltipItem.datasetIndex === 0) {
                                                        label += tooltipItem.raw + ' vendas'; 
                                                    } else {
                                                        label += 'R$ ' + tooltipItem.raw.toFixed(2);
                                                    }
                                                    return label;
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        </script>                        
                    @endif
                </div>
            </section>
        </main>
    </div>

</body>
</html>
