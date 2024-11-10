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
    <h2>Clientes</h2>
    <div class="employee-section">
        <div class="add-employee">
            <i class="fas fa-plus-circle" onclick="openEmployeeModal()"></i>
            <p>Cadastrar Cliente</p>
        </div>
        <!-- Cards de Clientes -->
    @foreach($clientes as $clientev)
        <div class="employee-card" 
            data-card-id="{{ $clientev->ID }}"
            data-telefone="{{ $clientev->Telefone }}" 
            data-email="{{ $clientev->Email }}" 
            data-cpf="{{$clientev->CPF}}"
            data-endereco="{{ $clientev->Endereco }}"
            data-descricao="{{ $clientev->Descricao }}">
            <div class="employee-photo" style="cursor: pointer;">
                <img src="{{ asset('imagens/homem.png') }}" alt="Imagem Cliente">
            </div>
            <div class="employee-info">
                <h3 class="employee-name">{{ $clientev->Nome }}</h3>
            </div>
            <div class="employee-actions">
                <a href='{{ route('clientes.edit', ['id' => $clientev->ID]) }}'><i class="fas fa-edit" ></i></a>
                <i class="fas fa-times" data-nome="{{ $clientev->Nome }}"></i>
                <form action="{{ route('clientes.delete', $clientev->ID) }}" method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    @endforeach

    <div id="modalEdicao" class="modal" style='display: flex'>
        <div class="modal-content">
            <a href='{{ route('dashboard.clientes') }}'><span class="fechar">&times;</span></a>
            <h2>Editar Cliente</h2>
            <div class="modal-body">
                <div class="form-wrapper">
                    <div class="photo-section">
                        <div class="photo-upload">
                            <img src="{{ asset('imagens/homem.png') }}" alt="Funcionario" class="uploaded-image">
                        </div>
                    </div>
                    <form action="{{ route('clientes.update', $cliente->ID) }}" method="POST" class="employee-details">
                    @csrf
                    @method('PUT')
                    <input type="text" name='Nome' id="nome" placeholder="Nome" value="{{ $cliente->Nome }}" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" />
                    <input type="email" name='Email' id="email" placeholder="Email" value="{{ $cliente->Email }}" />
                    <input type="date" name='DataNasc' id="dataNascimento" value="{{ $cliente->DataNasc }}" />
                    <input type="text" name='Telefone' id="telefone" placeholder="Telefone" value="{{ $cliente->Telefone }}" maxlength="15" />
                    <input type="text" name='CPF' id="cpf" placeholder="CPF" value="{{ $cliente->CPF }}" maxlength="14" />
                    <select id='sexo' name='Sexo'>
                        <option value="" disabled>Sexo</option>
                        <option value="M" {{ $cliente->Sexo == 'M' ? "selected" : "" }}>Masculino</option>
                        <option value="F" {{ $cliente->Sexo == 'F' ? "selected" : "" }}>Feminino</option>
                    </select>
                        <input type="text" name='Endereco' placeholder="Endereço" class="address-full-width" value="{{ $cliente->Endereco }}" />
                        <textarea name="Descricao" placeholder="Descrição do Cliente" class="description-field">{{ $cliente->Descricao }}</textarea>
                        <button type="submit" class="botao-salvar-clientes">Salvar Alterações</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<div class="pagination">
    <a href="?page=1">1</a>
    <a href="?page=2">2</a>
    <a href="?page=3">3</a>
</div>

<script>
    $('#telefone').mask('(00) 00000-0000'); // Aplica a máscara para telefone
    $('#telefoneEdicao').mask('(00) 00000-0000'); // Aplica a máscara para telefone
    $('#viewTelefoneFuncionario').mask('(00) 00000-0000'); // Aplica a máscara para telefone na visualização
    $('#dataNascimentoEdicao').mask('00/00/0000'); // Aplica a máscara para data de nascimento
</script>
        
@endsection