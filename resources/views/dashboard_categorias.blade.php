@extends('dashboard')

@section('content_dashboard')

<section class="main-content">
    <h2>Categorias</h2>
    <div class="employee-section">
        <div class="add-employee">
            <i class="fas fa-plus-circle" onclick="openEmployeeModal()"></i>
            <p>Cadastrar Marca</p>
        </div>
        <!-- Cards de Categorias -->
    @foreach($categorias as $categoria)
        <div class="employee-card" 
            data-card-id="{{ $categoria->ID }}"
            data-nome="{{ $categoria->Nome }}">
            <div class="employee-photo" style="cursor: pointer;">
                <img src="{{ asset('imagens/categoria.png') }}" alt="Imagem Categoria">
            </div>
            <div class="employee-info">
                <h3 class="employee-name">{{ $categoria->Nome }}</h3>
            </div>
            <div class="employee-actions">
                <a href='{{ route('categorias.edit', ['id' => $categoria->ID]) }}'><i class="fas fa-edit" ></i></a>
                <i class="fas fa-times" data-nome="{{ $categoria->Nome }}" onclick="abrirModalConfirmacaoExclusao(this, this.dataset.nome)"></i>
                <form action="{{ route('categorias.delete', $categoria->ID) }}" method="POST" style="display:none;">
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
        <h2>Cadastrar uma Categoria</h2>
        <div class="modal-body">
            <div class="form-wrapper"> <!-- Wrapper para organizar o layout -->
                <div class="photo-section">
                    <div class="photo-upload">
                        <img src="{{ asset('imagens/categoria.png') }}" alt="Categorias" class="uploaded-image-marca">
                    </div>
                </div>
                <form action="{{ route('categorias.create') }}" method="POST" class="employee-details-marcas">
                    @csrf
                    <input type="text" name='nome' id="nome" placeholder="Nome" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" /></br></br>
                    <button id="cadastrarBtn-categorias" type="submit">Cadastrar</button>
            </div> <!-- Fim do wrapper -->
            <!-- Botão fora do form e do wrapper -->
            </form>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal-confirmacao" id="modalConfirmacaoExclusao">
    <div class="modal-content-confirmacao">
        <span class="fechar" onclick="fecharModal('modalConfirmacaoExclusao')">&times;</span>
        <h2>Confirmação de Exclusão</h2>
        <p id="mensagemConfirmacao">Tem certeza de que deseja excluir a categoria <span id="nomeCategoria"></span>?</p>
        <div class="botoes-confirmacao">
            <button class="btn-sim" onclick="confirmarExclusao()">Sim</button>
            <button class="btn-nao" onclick="fecharModal('modalConfirmacaoExclusao')">Não</button>
        </div>
    </div>
</div>


<script>
    function openEmployeeModal() {
        $('#employeeModal').css('display', 'flex');
    }
    
    function closeEmployeeModal() {
        $('#employeeModal').css('display', 'none');
    }

    function fecharModal(modalId) {
        $('#' + modalId).css('display', 'none');
    }
    
    function abrirModalConfirmacaoExclusao(element, nomeCategoria) {
        const modal = $('#modalConfirmacaoExclusao');
        modal.css('display', 'block');
        $('#nomeCategoria').text(nomeCategoria);
    
        const cardMarca = $(element).closest('.employee-card');
        const cardId = cardMarca.data('cardId');
        modal.data('cardId', cardId);
    }
    
    function confirmarExclusao() {
        const modal = $('#modalConfirmacaoExclusao');
        const cardId = modal.data('cardId');
    
        const form = $(`.employee-card[data-card-id="${cardId}"] form`);
    
        if (form.length) {
            form.submit();
        }
    
        fecharModal('modalConfirmacaoExclusao');
    }
    
    </script>
        
@endsection