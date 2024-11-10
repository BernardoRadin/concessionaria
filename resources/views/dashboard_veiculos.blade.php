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

@if(session('success'))
    <script>
        Toast.fire({
            icon: "success",
            title: "{{ session('success') }}"
        });   
    </script>
@endif

@if(session('error'))
    <script>
        Toast.fire({
            icon: "error",
            title: "{{ session('error') }}"
        });   
    </script>
@endif

<section class="main-content">
    <h2>Veículos</h2>
    <div class="vehicle-section">
        <div class="add-vehicle" onclick="openModal()">
            <i class="fas fa-plus-circle"></i>
            <p>Cadastrar Veículo</p>
        </div>
        @foreach($veiculos as $veiculo)
        <a href='{{route('veiculos.view', ['id' => $veiculo->ID]) }}'>
            <div class="vehicle-card" data-card-id="{{ $veiculo->ID }}">
                <img src="{{ asset($veiculo->fotoprincipal->Foto ?? 'caminho/para/imagem/padrao.jpg') }}" alt="{{$veiculo->Nome}}">
                <div class="vehicle-info">
                    <h3>{{$veiculo->Nome}}</h3>
                    <p>{{$veiculo->Ano}}</p>
                    <p class="price">R$ {{$veiculo->PrecoVenda}}</p>
                </div>
                <div class="vehicle-actions">
                    <a href='{{ route('veiculos.edit', ['id' => $veiculo->ID]) }}'><i class="fas fa-edit"></i></a>
                    <a @if($veiculo->Em_Estoque == 1) href='{{ route('vendas.viewcadastro', ['idcarro' => $veiculo->ID]) }}' @endif>
                    <i class="fas fa-dollar-sign {{ $veiculo->Em_Estoque == 0 ? 'disabled' : ''}}"></i></a>
                    <i class="fas fa-times" data-nome="{{ $veiculo->Nome }}"  onclick="abrirModalConfirmacaoExclusao(this, this.dataset.nome)"></i>
                    <form action="{{ route('veiculos.delete', $veiculo->ID) }}" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    <div class="pagination">
        {{ $veiculos->links('pagination::bootstrap-4', ['previous' => 'Anterior', 'next' => 'Próximo']) }}
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
                    <input type="file" class="file-input" id="file-input" name="images[]" accept="image/*" multiple required>
                    <button class="upload-btn" id="select-btn" type='button'>Selecionar Imagens</button>
                    <div id="thumbnails"></div>
                </div>
                <div class="vehicle-details">
                    <input type="text" name="nome" placeholder="Nome" required>
                    <input type="text" name="ano" placeholder="Ano" maxlength="4" required>
                    <input type="text" name="portas" placeholder="Portas" required>
                    <input type="text" name="cambio" placeholder="Câmbio" required>
                    <input type="text" name="motor" placeholder="Motor" required>
                    <input type="text" name="quilometragem" placeholder="Quilometragem" required>
                    <select name="combustivel" required>
                        <option value=''>Selecione o Combustível</option>
                        <option value='A'>Álcool</option>
                        <option value='G'>Gasolina</option>
                        <option value='F'>Álcool e Gasolina</option>
                        <option value='D'>Diesel</option>
                        <option value='E'>Elétrico</option>
                    </select>
                    <select name="categoria" required>
                        <option value=''>Selecione a Categoria</option>
                        @foreach($categorias as $categoria)
                            <option value='{{ $categoria->ID }}'>{{ $categoria->Nome }}</option>
                        @endforeach
                    </select>
                    <select name="marca" required>
                        <option value=''>Selecione a Marca</option>
                        @foreach($marcas as $marca)
                            <option value='{{ $marca->ID }}'>{{ $marca->Nome }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="cor" placeholder="Cor" required>
                    <input type="text" name="precocusto" placeholder="Preço Custo" required>
                    <input type="text" name="precovenda" placeholder="Preço Venda" required>
                    <select name="estoque" required>
                        <option value=''>Seleciona estoque</option>
                        <option value='1' selected>Sim</option>
                        <option value='0'>Não</option>
                    </select>
                    <select name="antigodono" required>
                        <option value=''>Selecione o Antigo Dono</option>
                        @foreach($clientes as $cliente)
                            <option value='{{ $cliente->ID }}'>{{ $cliente->Nome }}</option>
                        @endforeach
                    </select>
                    <textarea name="descricao" placeholder="Descrição do Veículo"></textarea>
                    <div class='align-button-veiculos'>
                        <button id="cadastrarBtn-veiculos" type="submit">Cadastrar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="modalConfirmacaoVenda" class="modal-confirmacao-venda">
    <div class="modal-conteudo">
        <span class="fechar" onclick="fecharModal('modalConfirmacaoVenda')">&times;</span>
        <h2 class="titulo-modal">Confirmação de Venda</h2>
        <form id="formConfirmacaoVenda" onsubmit="enviarFormularioVenda(event)">
            <div class="campo-form">
                <label for="dataVenda" class="label-campo">Data da Venda:</label>
                <input type="date" id="dataVenda" name="data" class="input-campo" required>
            </div>
            <div class="campo-form">
                <label for="funcionarioVenda" class="label-campo">Funcionário Responsável:</label>
                <input type="text" id="funcionarioVenda" name="funcionario" class="input-campo" required>
            </div>
            <div class="campo-form">
                <label for="descricaoVenda" class="label-campo">Descrição:</label>
                <textarea id="descricaoVenda" name="descricao" class="textarea-campo" required></textarea>
            </div>
            <button type="submit" class="botao-confirmar">Confirmar Venda</button>
        </form>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal-confirmacao" id="modalConfirmacaoExclusao">
    <div class="modal-content-confirmacao">
        <span class="fechar" onclick="fecharModal('modalConfirmacaoExclusao')">&times;</span>
        <h2>Confirmação de Exclusão</h2>
        <p id="mensagemConfirmacao">Tem certeza de que deseja excluir o veículo <span id="nomeVeiculo"></span>?</p>
        <div class="botoes-confirmacao">
            <button class="btn-sim" onclick="confirmarExclusao()">Sim</button>
            <button class="btn-nao" onclick="fecharModal('modalConfirmacaoExclusao')">Não</button>
        </div>
    </div>
</div>

    <script>
    // Abre o modal de cadastro de veículo
    function openModal() {
        document.getElementById('vehicleModal').style.display = 'block';
    }

    // Fecha o modal de cadastro de veículo
    function closeModal() {
        document.getElementById('vehicleModal').style.display = 'none';
    }

    // Exibe o modal com as informações do veículo selecionado
    function exibirModalVeiculo(idVeiculo) {
        // Aqui você deve buscar os dados reais do veículo. 
        // Para este exemplo, estamos apenas definindo valores fictícios.
        document.getElementById('modal-veiculo-nome').innerText = "Nome do Veículo " + idVeiculo;
        document.getElementById('modal-veiculo-ano').innerText = "2021"; // Exemplo fictício

        // Exibir o modal
        document.getElementById('modal-veiculo').style.display = 'block';
    }

    // Fecha o modal de informações do veículo
    function fecharModalVeiculo() {
        document.getElementById('modal-veiculo').style.display = 'none';
    }

    // Abre o modal de confirmação de venda
    function openModalVendido(event) {
        event.stopPropagation(); // Para evitar que o evento de click propague para o card do veículo
        document.getElementById('modalConfirmacaoVenda').style.display = 'block';
    }

    // Fecha o modal passando o ID do modal
    function fecharModal(idModal) {
        document.getElementById(idModal).style.display = 'none';
    }

    // Confirmar exclusão
    function abrirModalConfirmacaoExclusao(element, nomeVeiculo) {
        const modal = $('#modalConfirmacaoExclusao');
        modal.css('display', 'block');
        $('#nomeVeiculo').text(nomeVeiculo);
    
        const cardMarca = $(element).closest('.vehicle-card');
        const cardId = cardMarca.data('cardId'); // Armazena o ID no modal
        modal.data('cardId', cardId);
    }
    
    function confirmarExclusao() {
        const modal = $('#modalConfirmacaoExclusao');
        const cardId = modal.data('cardId');
    
        const form = $(`.vehicle-card[data-card-id="${cardId}"] form`);

        alert
    
        if (form.length) {
            form.submit(); // Submete o formulário para excluir no backend
        }
    
        fecharModal('modalConfirmacaoExclusao');
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

/* Estilos para o modal */
.modal-veiculo {
    display: none; /* Oculto inicialmente */
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80%;
    max-width: 800px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2);
    font-family: Arial, sans-serif;
    z-index: 1000;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    border-bottom: 1px solid #ddd;
}

.vehicle-name-year strong {
    margin-right: 5px; /* Espaço entre o rótulo e o valor */
}

.vehicle-name-year span {
    display: block; /* Faz com que cada linha ocupe toda a largura disponível */
    margin-bottom: 10px; /* Espaço entre o nome e o ano */
}

.modal-header h2 {
    font-size: 24px;
    color: #333;
}

.close {
    cursor: pointer;
    font-size: 24px;
    color: #333;
}

.modal-content {
    display: flex;
    padding: 20px;
    gap: 20px;
}

/* Seção de fotos do veículo */
.vehicle-images {
    flex: 1;
}

.vehicle-images h3 {
    font-size: 18px;
    color: #333;
    margin-bottom: 10px;
}

.image-gallery {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.image-gallery .large-image {
    width: calc(100% - 10px);
    height: 200px;
    object-fit: cover;
    border-radius: 5px;
    border: 1px solid #ddd;
}

.image-gallery img:not(.large-image) {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 5px;
    border: 1px solid #ddd;
}

/* Seção de informações do veículo */
.vehicle-info {
    flex: 2;
}

.vehicle-info h3 {
    font-size: 18px;
    color: #333;
    margin-bottom: 10px;
}

.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.info-grid div {
    padding: 10px;
    background-color: #f9f9f9;
    border-radius: 5px;
}

.info-grid strong {
    color: #555;
}

.modal-confirmacao-venda {
    display: none; /* Oculto por padrão */
    position: fixed; /* Fica fixo na tela */
    z-index: 1000; /* Coloca o modal acima de outros conteúdos */
    left: 0;
    top: 0;
    width: 100%; /* Largura total */
    height: 100%; /* Altura total */
    overflow: auto; /* Adiciona rolagem se necessário */
    background-color: rgba(0, 0, 0, 0.5); /* Fundo semi-transparente */
}

.modal-conteudo {
    background-color: #fff; /* Cor de fundo do modal */
    margin: auto; /* Centraliza o modal */
    padding: 20px; /* Espaçamento interno */
    border: 1px solid #888; /* Borda do modal */
    border-radius: 10px; /* Bordas arredondadas */
    max-width: 400px; /* Largura máxima do modal */
    width: 80%; /* Largura padrão do modal */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra do modal */
}

.titulo-modal {
    font-size: 24px;
    margin-bottom: 15px;
    color: #0a0a23;
    text-align: center; /* Centraliza o título */
}

.campo-form {
    margin-bottom: 15px; /* Espaçamento entre os campos */
}

.label-campo {
    display: block; /* Faz o label ocupar toda a largura */
    margin-bottom: 5px; /* Espaçamento abaixo do label */
    font-weight: bold; /* Negrito para o label */
    color: #333;
}

.input-campo, .textarea-campo {
    width: 100%; /* Largura total */
    padding: 10px; /* Espaçamento interno */
    border: 1px solid #e5e5e5; /* Borda dos campos */
    border-radius: 4px; /* Bordas arredondadas */
    font-size: 16px; /* Tamanho da fonte */
    color: #444;
    background-color: #f9f9f9; /* Cor de fundo dos campos */
}

.textarea-campo {
    height: 100px; /* Altura da textarea */
    resize: none; /* Desabilita redimensionamento */
}

.botao-confirmar {
    display: block;
    background-color: #0a0a23;
    color: white; 
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 10px;
}

.botao-confirmar:hover {
    background-color: #3c3c7a;
}

.fechar {
    cursor: pointer;
    font-size: 24px;
    color: #aaa;
    float: right;
}

.vehicle-section {
    display: flex;
    align-items: flex-start;
    justify-content: space-around;
    margin-top: 40px;
}

.add-vehicle {
    text-align: center;
    font-size: 18px;
    color: #0a0a23;
}

.add-vehicle i {
    font-size: 50px;
    color: #0a0a23;
    margin-bottom: 10px;
    cursor: pointer;
}

.vehicle-card {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    width: 220px;
    padding: 15px;
    text-align: center;
    margin-left: 20px;
}

.vehicle-card img {
    width: 100%;
    border-radius: 5px;
    margin-bottom: 15px;
}

.vehicle-info h3 {
    font-size: 18px;
    margin-bottom: 5px;
}

.vehicle-info p {
    margin-bottom: 5px;
    font-size: 16px;
    color: #666;
}

.price {
    font-weight: bold;
    font-size: 18px;
    color: #0a0a23;
}

.vehicle-actions {
    margin-top: 10px;
}

.vehicle-actions i {
    font-size: 18px;
    margin: 0 5px;
    color: #666;
    cursor: pointer;
}

.vehicle-actions i:hover {
    color: #0a0a23;
}

.vehicle-details {
    flex: 2; /* Seção de detalhes do veículo é maior */
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px; /* Aumentei o espaçamento */
}

.vehicle-details input {
    padding: 12px; /* Aumentei o padding dos inputs */
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.vehicle-details input:focus {
    border-color: #007BFF;
    outline: none;
}

</style>

@endsection