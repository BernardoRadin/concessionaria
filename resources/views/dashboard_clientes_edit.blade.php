@extends('dashboard')

@section('content_dashboard')

<div id="employeeModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEmployeeModal()">&times;</span>
        <h2>Editar Cliente</h2>
        <div class="modal-body">
            <div class="form-wrapper">
                <div class="photo-section">
                    <div class="photo-upload">
                        <img src="{{ asset('imagens/homem.png') }}" alt="Funcionario" class="uploaded-image">
                    </div>
                </div>
                <form action="{{ route('clientes.update', $cliente->id) }}" method="POST" class="employee-details">
                @csrf
                @method('PUT')
                <input type="text" name='nome' id="nome" placeholder="Nome" value="{{ $cliente->nome }}" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" />
                <input type="email" name='email' id="email" placeholder="Email" value="{{ $cliente->email }}" />
                <input type="date" name='dataNasc' id="dataNascimento" value="{{ $cliente->dataNasc }}" />
                <input type="text" name='telefone' id="telefone" placeholder="Telefone" value="{{ $cliente->telefone }}" maxlength="15" />
                <input type="text" name='cpf' id="cpf" placeholder="CPF" value="{{ $cliente->cpf }}" maxlength="14" />
                <select id='sexo' name='sexo'>
                    <option value="" disabled>Sexo</option>
                    <option value="M" {{ $cliente->sexo == 'M' ? "selected" : "" }}>Masculino</option>
                    <option value="F" {{ $cliente->sexo == 'F' ? "selected" : "" }}>Feminino</option>
                </select>
                    <input type="text" name='endereco' placeholder="Endereço" class="address-full-width" value="{{ $cliente->endereco }}" />
                    <textarea name="descricao" placeholder="Descrição do Cliente" class="description-field">{{ $cliente->descricao }}</textarea>
                    <button type="submit" class="botao-salvar">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    
    $(document).ready(function() {
        $('#telefone').mask('(00) 00000-0000'); // Aplica a máscara para telefone
        $('#telefoneEdicao').mask('(00) 00000-0000'); // Aplica a máscara para telefone
        $('#viewTelefoneFuncionario').mask('(00) 00000-0000'); // Aplica a máscara para telefone na visualização
    });
    
    // Máscara para CPF usando jQuery Mask
    $(document).ready(function() {
        $('#cpf').mask('000.000.000-00'); // Aplica a máscara para CPF
        $('#cpfEdicao').mask('000.000.000-00'); // Aplica a máscara para CPF
        $('#viewCpfFuncionario').mask('000.000.000-00'); // Aplica a máscara para CPF na visualização
    });
    
    // Máscara para data de nascimento usando jQuery Mask
    $(document).ready(function() {
        $('#dataNascimentoEdicao').mask('00/00/0000'); // Aplica a máscara para data de nascimento
    });
    
    // Alternar visualização de senha
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