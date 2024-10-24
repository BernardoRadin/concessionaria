@extends('dashboard')

@section('content_dashboard')

<section class="main-content">
    <h2>Marcas</h2>
    <div class="employee-section">
        <div class="add-employee">
            <i class="fas fa-plus-circle" onclick="openEmployeeModal()"></i>
            <p>Cadastrar Marca</p>
        </div>
        <!-- Cards de Marcas -->
    @foreach($marcas as $marca)
        <div class="employee-card" 
            data-card-id="{{ $marca->ID }}"
            data-nome="{{ $marca->Nome }}" 
            data-logo="{{ $marca->Logo }}" >
            <div class="employee-photo" style="cursor: pointer;">
                <img src="{{ asset("$marca->Logo") }}" alt="Imagem Marca">
            </div>
            <div class="employee-info">
                <h3 class="employee-name">{{ $marca->Nome }}</h3>
            </div>
            <div class="employee-actions">
                <a href='{{ route('funcionarios.edit', ['id' => $marca->ID]) }}'><i class="fas fa-edit" ></i></a>
                <i class="fas fa-times" data-nome="{{ $marca->Nome }}" onclick="abrirModalConfirmacaoExclusao(this, this.dataset.nome)"></i>
                <form action="{{ route('funcionarios.delete', $marca->ID) }}" method="POST" style="display:none;">
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
        <h2>Cadastre uma Marca</h2>
        <div class="modal-body">
            <div class="form-wrapper"> <!-- Wrapper para organizar o layout -->
                <div class="photo-section">
                    <div class="photo-upload">
                        <img src="{{ asset('imagens/marca.png') }}" alt="Marcas" class="uploaded-image-marca">
                    </div>
                </div>
                <form action="{{ route('funcionarios.create') }}" method="POST" class="employee-details-marcas">
                    @csrf
                    <input type="text" name='nome' id="nome" placeholder="Nome" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" /></br></br>
                    <input type="file" name='logo' placeholder="logo" class="address-full-width" /></br></br>
                    <button id="cadastrarBtn" type="submit">Cadastrar</button>
            </div> <!-- Fim do wrapper -->
            <!-- Botão fora do form e do wrapper -->
            </form>
        </div>
    </div>
</div>

<!-- Visualizar as informações do Marcas -->
<div class="modal-view-funcionario" id="modalVisualizarFuncionario">
    <div class="modal-content-view">
        <span class="close-view" onclick="fecharModalVisualizarFuncionario()">&times;</span>
        <div class="modal-header-view">
            <h2 id="viewNomeFuncionario">Nome do Funcionário</h2>
            <h3 id="viewCargoFuncionario">Cargo do Funcionário</h3>
        </div>
        <div class="modal-body-view">
            <div class="foto-view">
                <img src="{{ asset('imagens/funcionario.png') }}" alt="View Funcionário" class="view-funcionario">
            </div>
            <div class="detalhes-view">
                <p><strong>Nome:</strong> <span id="viewTelefoneFuncionario">123-456-7890</span></p>
                <p><strong>Logo:</strong> <span id="viewEmailFuncionario">exemplo@email.com</span></p>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal-confirmacao" id="modalConfirmacaoExclusao">
    <div class="modal-content-confirmacao">
        <span class="fechar" onclick="fecharModal('modalConfirmacaoExclusao')">&times;</span>
        <h2>Confirmação de Exclusão</h2>
        <p id="mensagemConfirmacao">Tem certeza de que deseja excluir a Marca <span id="nomeFuncionario"></span>?</p>
        <div class="botoes-confirmacao">
            <button class="btn-sim" onclick="confirmarExclusao()">Sim</button>
            <button class="btn-nao" onclick="fecharModal('modalConfirmacaoExclusao')">Não</button>
        </div>
    </div>
</div>


<script>
    // Abrir o modal de funcionário
    function openEmployeeModal() {
        $('#employeeModal').css('display', 'flex');
    }
    
    // Fechar o modal de funcionário
    function closeEmployeeModal() {
        $('#employeeModal').css('display', 'none');
    }

    // Função para fechar modais
    function fecharModal(modalId) {
        $('#' + modalId).css('display', 'none');
    }
    
    // Fechar o modal ao clicar fora do conteúdo
    $(window).on('click', function(event) {
        const modalEdicao = $('#modalEdicao');
        const modalVisualizacao = $('#modalVisualizarFuncionario');
    
        if (event.target === modalEdicao[0] || event.target === modalVisualizacao[0]) {
            fecharModal(event.target.id);
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
    
    // Visualizar dados do funcionário
    function abrirModalVisualizacao(nome, cargo, email, telefone, cpf, endereco) {
        $('#modalVisualizarFuncionario').css('display', 'flex');
    
        $('#viewNomeFuncionario').text(nome);
        $('#viewCargoFuncionario').text(cargo);
        $('#viewEmailFuncionario').text(email);
        $('#viewEnderecoFuncionario').text(endereco);
    
        // Atribui os valores mascarados aos campos do modal
        $('#viewTelefoneFuncionario').text(telefone);
        $('#viewCpfFuncionario').text(cpf);
    }
    
    function fecharModalVisualizarFuncionario() {
        $('#modalVisualizarFuncionario').css('display', 'none');
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
    
        $(card).on('click', function(event) {
            if (event.target !== editIcon[0] && event.target !== deleteIcon[0]) {
                abrirModalVisualizacao(nome, cargo, email, telefone, cpf, endereco);
            }
        });
    });
    </script>
        
@endsection