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
    <a href="?page=1">1</a>
    <a href="?page=2">2</a>
    <a href="?page=3">3</a>
    <!-- Mais páginas podem ser adicionadas dinamicamente -->
</div>

<!-- Editar as informações do Marca -->
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
                    <input type="text" name='Nome' id="nome" placeholder="Nome" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" value="{{ $marca->Nome }}"/></br></br>
                    <input type="file" name='logo' placeholder="logo" class="address-full-width" /></br></br>
                    <button id="editarBtn" type="submit">Editar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection