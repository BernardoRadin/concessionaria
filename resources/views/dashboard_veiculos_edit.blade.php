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
    <h2>Veículos</h2>
    <div class="vehicle-section">
        <div class="add-vehicle" onclick="openModal()">
            <i class="fas fa-plus-circle"></i>
            <p>Cadastrar Veículo</p>
        </div>
        @foreach($veiculos as $veiculov)
        <a>
            <div class="vehicle-card" onclick="exibirModalVeiculo()">
                <img src="{{ asset($veiculov->fotoprincipal->Foto ?? 'caminho/para/imagem/padrao.jpg') }}" alt="{{$veiculov->Nome}}">
                <div class="vehicle-info">
                    <h3>{{$veiculov->Nome}}</h3>
                    <p>{{$veiculov->Ano}}</p>
                    <p class="price">R$ {{$veiculov->PrecoVenda}}</p>
                </div>
                <div class="vehicle-actions">
                    <a href='{{ route('veiculos.edit', ['id' => $veiculov->ID]) }}'><i class="fas fa-edit"></i></a>
                    <i class="fas fa-dollar-sign"></i>
                    <i class="fas fa-times"></i>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>

<div id="modalEdicao" class="modal" style='display: flex'>
    <div class="vehicle-modal-content">
        <a href='{{ route('dashboard.veiculos') }}'><span class="vehicle-close">&times;</span></a>
        <h2>Editar Veículo</h2>
        <form action="{{ route('veiculos.update', ['id' => $veiculo->ID]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="vehicle-form-container">
                <div class="photo-section">
                    <h2>Envie Fotos do Veículo</h2>
                    <div class="grid-imagens">
                        @foreach($veiculo->fotos as $foto)
                            <div class="image-input">
                                <label for="input{{ $foto->ID }}"> 
                                    <input type="radio" name="principal" value="{{ $foto->ID }}" {{ $foto->Principal ? 'checked' : '' }}>  
                                    <img src="{{ asset($foto->Foto) }}" alt="Imagem {{ $foto->ID }}" id="preview{{ $foto->ID }}" class="preview-image">
                                </label>
                                <input type="file" id="input{{ $foto->ID }}" name='image-{{ $foto->ID }}' accept="image/*" onchange="updateImagePreview(this, 'preview{{ $foto->ID }}')">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="vehicle-details">
                    <input type="text" name="nome" placeholder="Nome" value='{{ $veiculo->Nome }}'>
                    <input type="text" name="ano" placeholder="Ano" maxlength="4" value='{{ $veiculo->Ano }}'>
                    {{-- <input type="text" placeholder="Modelo"> --}}
                    <input type="text" name="porta" placeholder="Portas" value='{{ $veiculo->Porta }}'>
                    <input type="text" name="cambio" placeholder="Câmbio" value='{{ $veiculo->Cambio }}'>
                    <input type="text" name="motor" placeholder="Motor" value='{{ $veiculo->Motor }}'>
                    <input type="text" name="quilometragem" placeholder="Quilometragem" value='{{ $veiculo->Quilometragem }}'>
                    <select name="combustivel" placeholder="Combustível">
                        <option value=''>Selecione o Combustível</option>
                        <option value='A' {{ $veiculo->Combustivel == 'A' ? 'selected' : ''}}>Álcool</option>
                        <option value='G' {{ $veiculo->Combustivel == 'G' ? 'selected' : ''}}>Gasolina</option>
                        <option value='F' {{ $veiculo->Combustivel == 'F' ? 'selected' : ''}}>Álcool e Gasolina</option>
                        <option value='D' {{ $veiculo->Combustivel == 'D' ? 'selected' : ''}}>Diesel</option>
                        <option value='E' {{ $veiculo->Combustivel == 'E' ? 'selected' : ''}}>Elétrico</option>
                    </select>
                    <select name="categoria" placeholder="Categoria">
                        <option value=''>Selecione a Categoria</option>
                        @foreach($categorias as $categoria)
                            <option value='{{ $categoria->ID }}' {{ $veiculo->ID_Categoria == $categoria->ID ? 'selected' : ''}}>{{ $categoria->Nome }}</option>
                        @endforeach
                    </select>
                    <select name="marca" placeholder="Marca">
                        <option value=''>Selecione a Marca</option>
                        @foreach($marcas as $marca)
                            <option value='{{ $marca->ID }}' {{ $veiculo->ID_Marca == $marca->ID ? 'selected' : ''}}>{{ $marca->Nome }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="cor" placeholder="Cor" value='{{ $veiculo->Cor }}'>
                    <input type="text" name="precocusto" placeholder="Valor Compra" value='{{ number_format($veiculo->PrecoCusto,0, ',', '.') }}'>
                    <input type="text" name="precovenda" placeholder="Valor Venda" value='{{ number_format($veiculo->PrecoVenda,0, ',', '.') }}'>
                    <select name="estoque">
                        <option value=''>Seleciona estoque</option>
                        <option value='1' {{ $veiculo->Em_Estoque == 1 ? 'selected' : ''}}>Sim</option>
                        <option value='0' {{ $veiculo->Em_Estoque == 0 ? 'selected' : ''}}>Não</option>
                    </select>    
                    <select name="antigodono" placeholder="Antigo Dono">
                        <option value=''>Selecione o Antigo Dono</option>
                        @foreach($clientes as $cliente)
                            <option value='{{ $cliente->ID }}' {{ $veiculo->ID_AntigoDono == $cliente->ID ? 'selected' : ''}}>{{ $cliente->Nome }}</option>
                        @endforeach
                    </select>
                    <textarea name="descricao" placeholder="Descrição do Veículo">{{ $veiculo->Descricao }}</textarea>
                    <div class='align-button-veiculos'>
                        <button id="cadastrarBtn-veiculos" type="submit">Editar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>

    function updateImagePreview(input, previewId) {
        const preview = document.getElementById(previewId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
</script>

<style>

    .image-input {
        position: relative;
        width: 150px;
    }

    .image-input label {
        cursor: pointer;
    }

    .image-input img {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
        width: 100%;
    }

    .image-input input[type="radio"] {
        position: absolute;
        top: 5px;
        left: 0px;
        transform: scale(1.3);
    }

    .grid-imagens {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-template-rows: auto auto auto;
        gap: 20px;
        justify-items: center;
    }

    .image-input {
        position: relative;
    }

    .image-input input[type="file"] {
        display: none;
    }

    .image-input img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border: 2px solid #ccc;
        cursor: pointer;
    }

    .grid-imagens div:nth-child(5) {
        grid-column: 1 / -1;
        justify-self: center;
    }

    .vehicle-modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .vehicle-modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 20px;
        border-radius: 8px;
        width: 80%;
        max-height: 90%;
        overflow-y: auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .vehicle-close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .vehicle-close:hover,
    .vehicle-close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .vehicle-form-container {
        display: flex;
        gap: 20px;
        padding-top: 20px;
    }

    .photo-section {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .vehicle-details {
        flex: 2;
    }

    .vehicle-details input,
    .vehicle-details textarea {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .upload-container {
        width: 90%;
        max-width: 600px;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        text-align: center;
    }

    .upload-container h2 {
        margin-bottom: 20px;
        color: #333;
    }

    .file-input {
        display: none;
    }

    .thumbnail {
        display: inline-block;
        position: relative;
        margin: 10px;
        width: 100px;
        height: 100px;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .thumbnail input[type="radio"] {
        position: absolute;
        top: 5px;
        left: 5px;
        transform: scale(1.5);
        accent-color: #007bff;
    }

    .upload-btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 20px;
    }

    .upload-btn:hover {
        background-color: #0056b3;
    }

    .vehicle-photo-preview {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
    }

    .vehicle-thumbnail {
        width: 60px;
        height: 60px;
        background-color: #f0f0f0;
        border-radius: 4px;
    }

    .vehicle-details textarea {
        height: 80px;
        resize: vertical;
    }
    </style>

@endsection