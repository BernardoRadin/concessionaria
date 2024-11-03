@extends('dashboard')

@section('content_dashboard')

<section class="main-content">
    <h2>Veículos</h2>
    <div class="vehicle-section">
        <div class="add-vehicle" onclick="openModal()">
            <i class="fas fa-plus-circle"></i>
            <p>Cadastrar Veículo</p>
        </div>
        @foreach($veiculos as $veiculo)
            <div class="vehicle-card">
                <img src="{{ asset($veiculo->fotoprincipal->Foto) }}" alt="{{$veiculo->Nome}}">
                <div class="vehicle-info">
                    <h3>{{$veiculo->Nome}}</h3>
                    <p>{{$veiculo->Ano}}</p>
                    <p class="price">R$ {{$veiculo->PrecoVenda}}</p>
                </div>
                <div class="vehicle-actions">
                    <i class="fas fa-times"></i>
                    <i class="fas fa-eye"></i>
                    <i class="fas fa-star"></i>
                    <a href='{{ route('veiculos.edit', ['id' => $veiculo->ID]) }}'><i class="fas fa-pencil-alt"></i></a>
                </div>
            </div>
        @endforeach
        <!-- Outras vehicle-cards podem ser adicionadas aqui -->
    </div>
</section>

<!-- Modal de Cadastro de Veículo -->
<div id="vehicleModal" class="vehicle-modal">
    <div class="vehicle-modal-content">
        <span class="vehicle-close" onclick="closeModal()">&times;</span>
        <h2>Cadastrar Veículo</h2>
        <form action="{{ route('veiculos.create') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="vehicle-form-container">
                <div class="photo-section">
                    <h2>Envie Fotos do Veículo</h2>
                    <input type="file" class="file-input" id="file-input"  name="images[]" accept="image/*" multiple>
                    <button class="upload-btn" id="select-btn" type='button'>Selecionar Imagens</button>
                    <div id="thumbnails"></div>
                </div>
                <div class="vehicle-details">
                    <input type="text" name="nome" placeholder="Nome">
                    <input type="text" name="ano" placeholder="Ano" maxlength="4">
                    {{-- <input type="text" placeholder="Modelo"> --}}
                    <input type="text" name="portas" placeholder="Portas">
                    <input type="text" name="cambio" placeholder="Câmbio">
                    <input type="text" name="motor" placeholder="Motor">
                    <input type="text" name="quilometragem" placeholder="Quilometragem">
                    <select name="combustivel" placeholder="Combustível">
                        <option value=''>Selecione o Combustível</option>
                        <option value='A'>Alcool</option>
                        <option value='G'>Gasolina</option>
                        <option value='E'>Elétrico</option>
                        <option value='F'>Alcool e Gasolina</option>
                    </select>
                    <select name="categoria" placeholder="Categoria">
                        <option value=''>Selecione a Categoria</option>
                        @foreach($categorias as $categoria)
                            <option value='{{ $categoria->ID }}'>{{ $categoria->Nome }}</option>
                        @endforeach
                    </select>
                    <select name="marca" placeholder="Marca">
                        <option value=''>Selecione a Marca</option>
                        @foreach($marcas as $marca)
                            <option value='{{ $marca->ID }}'>{{ $marca->Nome }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="cor" placeholder="Cor">
                    <input type="text" name="precocusto" placeholder="Preço Custo">
                    <input type="text" name="precovenda" placeholder="Preço Venda">
                    <input type="text" name="estoque" placeholder="Estoque">
                    {{-- <input type="text" name="antigodono" placeholder="Antigo Dono"> --}}
                    <select name="antigodono" placeholder="Antigo Dono">
                        <option value=''>Selecione o Antigo Dono</option>
                        @foreach($clientes as $cliente)
                            <option value='{{ $cliente->ID }}'>{{ $cliente->Nome }}</option>
                        @endforeach
                    </select>
                    <textarea name="descricao" placeholder="Descrição do Veículo"></textarea>
                    <div class='align-button-veiculos'>
                    <button id="cadastrarBtn-veiculos" type="submit">Cadastrar</button>
                    <div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('vehicleModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('vehicleModal').style.display = 'none';
    }

    // Fechar modal ao clicar fora dele
    window.onclick = function(event) {
        var modal = document.getElementById('vehicleModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    }

    $(document).ready(function() {
        $('#select-btn').click(function() {
            $('#file-input').click();
        });

        $('#file-input').on('change', function(event) {
            const files = event.target.files;
            const $thumbnails = $('#thumbnails');
            $thumbnails.empty();

            if (files.length > 5) {
                alert('Selecione no máximo 5 imagens.');
                return;
            }

            $.each(files, function(i, file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const $div = $('<div>').addClass('thumbnail');

                    const $img = $('<img>').attr('src', e.target.result);
                    $div.append($img);

                    const $radio = $('<input type="radio">')
                        .attr('name', 'principal')
                        .val(i);
                    if (i === 0) $radio.prop('checked', true); // Marca a primeira imagem como principal por padrão
                    $div.append($radio);

                    $thumbnails.append($div);
                };

                reader.readAsDataURL(file);
            });
        });

    });
</script>

<style>
    /* Estilos para o modal de veículo */
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

/* Botão de fechar o modal */
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

/* Container principal para alinhar a photo-section e vehicle-details */
.vehicle-form-container {
    display: flex;
    gap: 20px;
    padding-top: 20px; /* Espaço superior */
}

.photo-section {
    flex: 1; /* Ocupa o espaço da esquerda */
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.vehicle-details {
    flex: 2; /* Ocupa mais espaço à direita */
}

.vehicle-details input,
.vehicle-details textarea {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
}

/* Estilo para o upload de fotos */
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

/* Thumbnails para as fotos do veículo */
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

/* Estilo para a área de texto */
.vehicle-details textarea {
    height: 80px;
    resize: vertical;
}
</style>

@endsection