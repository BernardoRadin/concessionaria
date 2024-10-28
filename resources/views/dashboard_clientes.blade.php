@extends('dashboard')

@section('content_dashboard')

<section class="main-content">
    <h2>Clientes</h2>
    <div class="employee-section">
        <div class="add-employee">
            <i class="fas fa-plus-circle" onclick="openEmployeeModal()"></i>
            <p>Cadastrar Cliente</p>
        </div>
        <!-- Cards de Clientes -->
    @foreach($clientes as $cliente)
        <div class="employee-card" 
            data-card-id="{{ $cliente->ID }}"
            data-telefone="{{ $cliente->Telefone }}" 
            data-email="{{ $cliente->Email }}" 
            data-cpf="{{$cliente->CPF}}"
            data-endereco="{{ $cliente->Endereco }}"
            data-descricao="{{ $cliente->Descricao }}">
            <div class="employee-photo" style="cursor: pointer;">
                <img src="{{ asset('imagens/homem.png') }}" alt="Imagem Cliente">
            </div>
            <div class="employee-info">
                <h3 class="employee-name">{{ $cliente->Nome }}</h3>
            </div>
            <div class="employee-actions">
                <a href='{{ route('clientes.edit', ['id' => $cliente->ID]) }}'><i class="fas fa-edit" ></i></a>
                <i class="fas fa-times" data-nome="{{ $cliente->Nome }}" onclick="abrirModalConfirmacaoExclusao(this, this.dataset.nome)"></i>
                <form action="{{ route('clientes.delete', $cliente->ID) }}" method="POST" style="display:none;">
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
    <!-- Mais páginas podem ser adicionadas dinamicamente -->
</div>

<!-- Modal de Cadastro -->
<div id="employeeModal" class="modal">
        <div class="modal-content">
        <span class="close" onclick="closeEmployeeModal()">&times;</span>
        <h2>Cadastrar Cliente</h2>
        <div class="modal-body">
            <div class="form-wrapper"> <!-- Wrapper para organizar o layout -->
                <div class="photo-section">
                    <div class="photo-upload">
                        <img src="{{ asset('imagens/homem.png') }}" alt="Funcionario" class="uploaded-image">
                    </div>
                </div>
                <form action="{{ route('clientes.create') }}" method="POST" class="employee-details">
                    @csrf
                    <input type="text" name='nome' id="nome" placeholder="Nome" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" />
                    <input type="email" name='email' id="email" placeholder="Email" />
                    <input type="date" name='dataNasc' id="dataNascimento" placeholder="Data de Nascimento" maxlength="10" />
                    <input type="text" name='telefone' id="telefone" placeholder="Telefone" maxlength="15" />
                    <input type="text" name='cpf' id="cpf" placeholder="CPF" maxlength="14" />
                    <select id='sexo' name='sexo'>
                        <option value="" disabled selected>Sexo</option>
                        <option value="M">Masculino</option>
                        <option value="F">Feminino</option>
                    </select>
                    <input type="text" name='endereco' placeholder="Endereço" class="address-full-width" />
                    <textarea name="descricao" placeholder="Descrição do Cliente" class="description-field"></textarea>
                    <button id="cadastrarBtn-cliente" type="submit">Cadastrar</button>
            </div> <!-- Fim do wrapper -->
            <!-- Botão fora do form e do wrapper -->
            </form>
        </div>
    </div>
</div>

<!-- Visualizar as informações do Cliente -->
<div class="modal-view-cliente" id="modalVisualizarCliente">
    <div class="modal-content-view">
        <span class="close-view" onclick="fecharModalVisualizarCliente()">&times;</span>
        <div class="modal-header-view">
            <h2 id="viewNomeCliente">Nome do Cliente</h2>
        </div>
        <div class="modal-body-view-cliente">
            <div class="foto-view-cliente">
                <img src="{{ asset('imagens/homem.png') }}" alt="View Cliente" class="view-cliente">
            </div>
            <div class="detalhes-view-cliente">
                <p><strong>Telefone:</strong> <span id="viewTelefoneCliente">123-456-7890</span></p>
                <p><strong>Email:</strong> <span id="viewEmailCliente">exemplo@email.com</span></p>
                <p><strong>CPF:</strong> <span id="viewCpfCliente">123.456.789-00</span></p>
                <p><strong>Endereço:</strong> <span id="viewEnderecoCliente">Rua Exemplo, 123</span></p>
            </div>
        </div>
        <label for="viewDescricaoCliente" class="description-title">Descrição do Cliente:</label>
        <div class="description-field">
            <span id="viewDescricaoCliente"></span>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal-confirmacao" id="modalConfirmacaoExclusao">
    <div class="modal-content-confirmacao">
        <span class="fechar" onclick="fecharModal('modalConfirmacaoExclusao')">&times;</span>
        <h2>Confirmação de Exclusão</h2>
        <p id="mensagemConfirmacao">Tem certeza de que deseja excluir o cliente <span id="nomeFuncionario"></span>?</p>
        <div class="botoes-confirmacao">
            <button class="btn-sim" onclick="confirmarExclusao()">Sim</button>
            <button class="btn-nao" onclick="fecharModal('modalConfirmacaoExclusao')">Não</button>
        </div>
    </div>
</div>


<script>
    // Abrir o modal de cliente
    function openEmployeeModal() {
        $('#employeeModal').css('display', 'flex');
    }
    
    // Fechar o modal de cliente
    function closeEmployeeModal() {
        $('#employeeModal').css('display', 'none');
    }
    
    // Máscara para telefone usando jQuery Mask
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
     
    // Função para fechar modais
    function fecharModal(modalId) {
        $('#' + modalId).css('display', 'none');
    }
    
    // Fechar o modal ao clicar fora do conteúdo
    $(window).on('click', function(event) {
        const modalEdicao = $('#modalEdicao');
        const modalVisualizacao = $('#modalVisualizarCliente');
    
        if (event.target === modalEdicao[0] || event.target === modalVisualizacao[0]) {
            fecharModal(event.target.id);
        }
    });
    
    // Fechar o modal ao pressionar a tecla "ESC"
    $(document).on('keydown', function(event) {
        if (event.key === "Escape") {
            fecharModal('modalEdicao');
            fecharModal('modalVisualizarCliente');
            fecharModal('modalConfirmacaoExclusao');
        }
    });
    
    // Confirmar exclusão
    function abrirModalConfirmacaoExclusao(element, nomeFuncionario) {
        const modal = $('#modalConfirmacaoExclusao');
        modal.css('display', 'block');
        $('#nomeFuncionario').text(nomeFuncionario);
    
        const cardFuncionario = $(element).closest('.employee-card');
        const cardId = cardFuncionario.data('cardId'); // Armazena o ID no modal
        modal.data('cardId', cardId);
    }
    
    function confirmarExclusao() {
        const modal = $('#modalConfirmacaoExclusao');
        const cardId = modal.data('cardId');
    
        const form = $(`.employee-card[data-card-id="${cardId}"] form`);
    
        if (form.length) {
            form.submit(); // Submete o formulário para excluir no backend
        }
    
        fecharModal('modalConfirmacaoExclusao');
    }
    
    // Visualizar dados do cliente
    function abrirModalVisualizacao(nome, cargo, email, telefone, cpf, endereco, descricao) {
        $('#modalVisualizarCliente').css('display', 'flex');
    
        $('#viewNomeCliente').text(nome);
        $('#viewEmailCliente').text(email);
        $('#viewEnderecoCliente').text(endereco);
    
        // Atribui os valores mascarados aos campos do modal
        $('#viewTelefoneCliente').text(telefone);
        $('#viewCpfCliente').text(cpf);
        $('#viewDescricaoCliente').text(descricao)
    }
    
    function fecharModalVisualizarCliente() {
        $('#modalVisualizarCliente').css('display', 'none');
    }
    
    $('.employee-card').each(function(index, card) {
        const editIcon = $(card).find('.fas.fa-edit');
        const deleteIcon = $(card).find('.fas.fa-times');
    
        const nome = $(card).find('.employee-name').text();
        const cargo = $(card).find('p').text();
        const email = $(card).data('email');
        const telefone = $(card).data('telefone');
        const cpf = $(card).data('cpf');
        const endereco = $(card).data('endereco');
        const descricao = $(card).data('descricao');

        $(card).on('click', function(event) {
            if (event.target !== editIcon[0] && event.target !== deleteIcon[0]) {
                abrirModalVisualizacao(nome, cargo, email, telefone, cpf, endereco, descricao);
            }
        });
    });
    </script>
        
@endsection