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
    <h2>Marcas</h2>
    <div class="employee-section">
        <div class="add-employee">
            <i class="fas fa-plus-circle" onclick="openEmployeeModal()"></i>
            <p>Cadastrar Marca</p>
        </div>
        <!-- Cards de Marcas -->
    @foreach($marcas as $marcav)
        <div class="employee-card" 
            data-card-id="{{ $marcav->ID }}"
            data-nome="{{ $marcav->Nome }}" 
            data-logo="{{ $marcav->Logo }}" >
            <div class="employee-photo" style="cursor: pointer;">
                <img src="{{ asset("$marcav->Logo") }}" alt="Imagem Marca">
            </div>
            <div class="employee-info">
                <h3 class="employee-name">{{ $marcav->Nome }}</h3>
            </div>
            <div class="employee-actions">
                <a href='{{ route('marcas.edit', ['id' => $marcav->ID]) }}'><i class="fas fa-edit" ></i></a>
                <i class="fas fa-times" data-nome="{{ $marcav->Nome }}" onclick="abrirModalConfirmacaoExclusao(this, this.dataset.nome)"></i>
                <form action="{{ route('marcas.delete', $marcav->ID) }}" method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    @endforeach
</div>
</section>

<div class="pagination">
    {{ $marcas->links('pagination::bootstrap-4', ['previous' => 'Anterior', 'next' => 'Próximo']) }}
</div>    

<div id="modalEdicao" class="modal" style='display: flex'>
    <div class="modal-content">
        <a href='{{ route('dashboard.marcas') }}'><span class="fechar">&times;</span></a>
        <h2>Editar Marca</h2>
        <div class="modal-body">
            <div class="form-wrapper"> <!-- Wrapper para organizar o layout -->
                <div class="photo-section">
                    <div class="photo-upload">
                        <img src="{{ asset("$marca->Logo") }}" alt="Marca" class="uploaded-image-marca">
                    </div>
                </div>
                <form action="{{ route('marcas.update', ['id' => $marca->ID] ) }}" method="POST" enctype="multipart/form-data" class="employee-details-marcas">
                    @csrf
                    @method('PUT')
                    <div class="field-group">
                        <label for="nome" class="marca-logo-label">Nome</label>
                        <input type="text" name="Nome" id="nome" placeholder="Nome" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" value="{{ $marca->Nome }}" />
                    </div>
                    <div class="marca-logo-container">
                    <label for="logo" class="marca-logo-label">Upload do Logo</label>
                    <div class="image-preview" id="imagePreview">
                    <img src="" alt="Pré-visualização" class="image-preview__image" />
                    <span class="image-preview__default-text">Nenhuma imagem selecionada</span>
                    </div>
                    <input type="file" name="logo" id="logo" class="marca-logo" accept="image/*" onchange="previewImage(event)" />
                    </div>
                    <button type="submit" class="botao-salvar-marca">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
        function previewImage(event) {
        const imagePreview = document.getElementById('imagePreview');
        const previewImage = imagePreview.querySelector('.image-preview__image');
        const previewDefaultText = imagePreview.querySelector('.image-preview__default-text');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImage.setAttribute('src', e.target.result);
                previewImage.style.display = 'block';
                previewDefaultText.style.display = 'none';
            };
            
            reader.readAsDataURL(file);
        } else {
            previewImage.style.display = 'none';
            previewDefaultText.style.display = 'block';
        }
    }
</script>
@endsection