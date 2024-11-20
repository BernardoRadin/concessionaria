@extends('dashboard')

@section('content_dashboard')

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            Toast.fire({
                icon: "warning",
                title: "{{ $error }}"
            });   
        </script>
    @endforeach    
@endif

<section class="main-content">
    <h2>Funcionários</h2>
    <div class="employee-section">
        <div class="add-employee">
            <i class="fas fa-plus-circle" onclick="openEmployeeModal()"></i>
            <p>Cadastrar Funcionário</p>
        </div>
        <!-- Cards de Funcionário -->
    @foreach($funcionarios as $funcionariov)
        <div class="employee-card">
            <div class="employee-photo" style="cursor: pointer;">
                    <img src="{{ asset('imagens/carteira-de-identidade.png') }}" alt="Imagem Funcionário">
            </div>
            <div class="employee-info">
                <h3 class="employee-name">{{ $funcionariov->Nome }}</h3>
                <p> {{ $funcionariov->cargo->Nome }}</p>
            </div>
            <div class="employee-actions">
                <i class="fas fa-edit" onclick="abrirModalEdicao({ ID: '{{ $funcionariov->ID }}', Nome: '{{ $funcionariov->Nome }}', Cpf: '{{ $funcionariov->CPF }}', DataNasc: '{{ $funcionariov->DataNasc }}', Email: '{{ $funcionariov->Email }}', Telefone: '{{ $funcionariov->Telefone }}' , Senha: '{{ $funcionariov->Senha }}', Endereco: '{{ $funcionariov->Endereco }}'})"></i>
                <i class="fas fa-times" data-nome="{{ $funcionariov->Nome }}" onclick="abrirModalConfirmacaoExclusao(this, this.dataset.nome)"></i>
                <form action="{{ route('funcionarios.delete', $funcionariov->ID) }}" method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    @endforeach
</div>
</section>

<div class="pagination">
    <a href="?page=1">1</a>
    <a href="?page=2">2</a>
    <a href="?page=3">3</a>
</div>

<!-- Editar as informações do Funcionário -->
<div id="modalEdicao" class="modal" style='display: flex'>
    <div class="modal-content">
        <a href='{{ route('dashboard.funcionarios') }}'><span class="fechar">&times;</span></a>
        <h2>Editar Funcionário</h2>
        <div class="modal-body">
            <div class="form-wrapper"> <!-- Wrapper para organizar o layout -->
                <div class="photo-section">
                    <div class="photo-upload">
                        <img src="{{ asset('imagens/funcionario.png') }}" alt="Funcionario" class="uploaded-image">
                    </div>
                </div>
                <form id="formEditarFuncionario" class='employee-details' action="{{ route('funcionarios.update', ['id' => $funcionario->ID]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="field-group">
                        <label for="nomeEdicao" class="marca-logo-label">Nome</label>
                        <input type="text" name='Nome' id="nomeEdicao" placeholder="Nome" value="{{ $funcionario->Nome }}" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" />
                    </div>
                    <div class="field-group">
                        <label for="telefoneEdicao" class="marca-logo-label">Telefone</label>
                        <input type="text" name='Telefone' id="telefoneEdicao" placeholder="Telefone" maxlength="15" value="{{ $funcionario->Telefone }}" />
                    </div>
                    <div class="field-group">
                        <label for="cpfEdicao" class="marca-logo-label">CPF</label>
                        <input type="text" name='CPF' id="cpfEdicao" placeholder="CPF" maxlength="14" value="{{ $funcionario->CPF }}"/>
                    </div>
                    <div class="field-group">
                        <label for="sexoEdicao" class="marca-logo-label">Sexo</label>
                        <select id='sexoEdicao' name='Sexo'>
                            <option value="" disabled selected>Sexo</option>
                            <option value="M" {{ $funcionario->Sexo == 'M' ? "selected" : ""}}>Masculino</option>
                            <option value="F" {{ $funcionario->Sexo == 'F' ? "selected" : ""}}>Feminino</option>
                        </select>
                    </div>
                    <div class="field-group">
                        <label for="dataNascEdicao" class="marca-logo-label">Data de Nascimento</label>
                        <input type="date" name='DataNasc' id="dataNascEdicao" placeholder="Data de Nascimento" maxlength="10" value="{{ $funcionario->DataNasc }}"/>
                    </div>
                    <div class="field-group">
                        <label for="cargoEdicao" class="marca-logo-label">Cargo</label>
                        <select id='cargoEdicao' name='ID_Cargo'>
                            <option value="">Selecione o cargo</optio>
                            <option value="1" {{ $funcionario->ID_Cargo == '1' ? "selected" : ""}}>Chefe</option>
                        </select>
                    </div>
                    <div class="field-group">
                        <label for="emailEdicao" class="marca-logo-label">Email</label>
                        <input type="email" name='Email' id="emailEdicao" placeholder="Email" value="{{ $funcionario->Email }}"/>
                    </div>
                    <div class="field-group password-field">
                        <label for="senhaEdicao" class="marca-logo-label">Senha</label>
                        <input type="password" placeholder="Senha" name='Senha' id="senhaEdicao" value="{{ $funcionario->Senha }}"/>
                        <i class="fas fa-eye" id="toggleSenhaEdicao"></i>
                    </div>
                    <div class="field-group-address">
                        <label for="enderecoEdicao" class="marca-logo-label">Endereço</label>
                        <input type="text" id='enderecoEdicao' name='Endereco' placeholder="Endereço" class="address-full-width" value="{{ $funcionario->Endereco }}"/>
                    </div>
                    <button type="submit" class="botao-salvar">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    
    $(document).ready(function() {
        $('#telefone').mask('(00) 00000-0000');
        $('#telefoneEdicao').mask('(00) 00000-0000');
        $('#viewTelefoneFuncionario').mask('(00) 00000-0000');
    });
    
    $(document).ready(function() {
        $('#cpf').mask('000.000.000-00');
        $('#cpfEdicao').mask('000.000.000-00');
        $('#viewCpfFuncionario').mask('000.000.000-00');
    });
    
    $(document).ready(function() {
        $('#dataNascimentoEdicao').mask('00/00/0000');
    });
    
    $('#toggleSenha').on('click', function() {
        const senhaInput = $('#senha');
        if (senhaInput.attr('type') === 'password') {
            senhaInput.attr('type', 'text');
            $(this).removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            senhaInput.attr('type', 'password');
            $(this).removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#toggleSenhaEdicao').on('click', function() {
        const senhaInput = $('#senhaEdicao');
        if (senhaInput.attr('type') === 'password') {
            senhaInput.attr('type', 'text');
            $(this).removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            senhaInput.attr('type', 'password');
            $(this).removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
                     
</script>
        
@endsection