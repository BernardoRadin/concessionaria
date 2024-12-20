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
    <h2>Categorias</h2>
    <div class="employee-section">
        <div class="add-employee">
            <i class="fas fa-plus-circle" onclick="openEmployeeModal()"></i>
            <p>Cadastrar Marca</p>
        </div>
        <!-- Cards de Categorias -->
    @foreach($categorias as $categoriav)
        <div class="employee-card" 
            data-card-id="{{ $categoriav->ID }}"
            data-nome="{{ $categoriav->Nome }}">
            <div class="employee-photo" style="cursor: pointer;">
                <img src="{{ asset('imagens/categoria.png') }}" alt="Imagem Categoria">
            </div>
            <div class="employee-info">
                <h3 class="employee-name">{{ $categoriav->Nome }}</h3>
            </div>
            <div class="employee-actions">
                <a href='{{ route('categorias.edit', ['id' => $categoriav->ID]) }}'><i class="fas fa-edit" ></i></a>
                <i class="fas fa-times" data-nome="{{ $categoriav->Nome }}" onclick="abrirModalConfirmacaoExclusao(this, this.dataset.nome)"></i>
                <form action="{{ route('categorias.delete', $categoriav->ID) }}" method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    @endforeach
</div>
</section>


<div class="pagination">
    {{ $categorias->links('pagination::bootstrap-4', ['previous' => 'Anterior', 'next' => 'Próximo']) }}
</div>    

<!-- Modal de Edicao -->
<div id="modalEdicao" class="modal" style='display: flex'>
    <div class="modal-content">
        <a href='{{ route('dashboard.categorias') }}'><span class="fechar">&times;</span></a>
        <h2>Editar Categoria</h2>
        <div class="modal-body">
            <div class="form-wrapper">
                <div class="photo-section">
                    <div class="photo-upload">
                        <img src="{{ asset('imagens/categoria.png') }}" alt="Categoria" class="uploaded-image-marca">
                    </div>
                </div>
                <form action="{{ route('categorias.update', ['id' => $categoria->ID] ) }}" method="POST" class="employee-details-marcas">
                    @csrf
                    @method('PUT')
                    <div class="field-group">
                        <label for="nome" class="marca-logo-label">Nome</label>
                        <input type="text" name="Nome" id="nome" placeholder="Nome" 
                            oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" 
                            value="{{ $categoria->Nome }}"/>
                    </div>

                    <button type="submit" class="botao-salvar-categorias">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</div>
        
@endsection