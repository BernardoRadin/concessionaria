@extends('dashboard')

@section('content_dashboard')

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
<div class="modal-view-veiculo">
    <div id="modal-veiculo" class="modal-veiculo">
        <div class="modal-header">
            <div class="vehicle-name-year">
                <span id="modal-veiculo-nome">{{$veiculo->Nome}}</span>
                <span id="modal-veiculo-ano">{{$veiculo->Ano}}</span>
            </div>
            <a href='{{ route('dashboard.veiculos') }}'><span class="close">&times;</span></a>
        </div>
        <div class="modal-content">
            <div class="vehicle-images">
                <h3>Fotos do Veículo</h3>
                <div class="image-gallery" id="modal-veiculo-imagens">
                    @foreach($veiculo->fotos as $foto)
                        @if($foto->Principal == 1)
                            <img src="{{ asset($foto->Foto) }}" class="large-image" alt="Foto Principal">
                        @else
                            <img src="{{ asset($foto->Foto) }}" alt="Foto do Veículo">
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="vehicle-info">
                <h3>Informações do Veículo</h3>
                <div class="info-grid" id="modal-veiculo-info">
                    <div><strong>Portas:</strong> <span id="modal-veiculo-portas">{{$veiculo->Porta}}</span></div>
                    <div><strong>Câmbio:</strong> <span id="modal-veiculo-cambio">{{$veiculo->Cambio}}</span></div>
                    <div><strong>Motor:</strong> <span id="modal-veiculo-motor">{{$veiculo->Motor}}</span></div>
                    <div><strong>Quilometragem:</strong> <span id="modal-veiculo-quilometragem">{{$veiculo->Quilometragem}} km</span></div>
                    <div><strong>Combustível:</strong> <span id="modal-veiculo-combustivel">{{ $veiculo->Combustivel == 'A' ? 'Álcool' : ($veiculo->Combustivel == 'G' ? 'Gasolina' : ($veiculo->Combustivel == 'E' ? 'Elétrico' : ($veiculo->Combustivel == 'F' ? 'Álcool e Gasolina' : 'Desconhecido'))) }} </span></div>
                    <div><strong>Categoria:</strong> <span id="modal-veiculo-categoria">{{$veiculo->Categoria->Nome}}</span></div>
                    <div><strong>Marca:</strong> <span id="modal-veiculo-marca">{{$veiculo->Marca->Nome}}</span></div>
                    <div><strong>Cor:</strong> <span id="modal-veiculo-cor">{{$veiculo->Cor}}</span></div>
                    <div><strong>Preço Custo:</strong> <span id="modal-veiculo-precocusto">R$ {{$veiculo->PrecoCusto}},00</span></div>
                    <div><strong>Preço Venda:</strong> <span id="modal-veiculo-precovenda">R$ {{$veiculo->PrecoVenda}},00</span></div>
                    <div><strong>Estoque:</strong> <span id="modal-veiculo-estoque">{{$veiculo->Estoque == 1 ? 'Sim' : 'Não'}}</span></div>
                    <div><strong>Antigo Dono:</strong> <span id="modal-veiculo-antigodono">{{$veiculo->AntigoDono->Nome}}</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    function updateImagePreview(input, previewId) {
        const preview = document.getElementById(previewId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result; // Atualiza o src da imagem de pré-visualização
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
</script>

<style>

.modal-view-veiculo{
    display: flex;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    z-index: 999;

}

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
    display: block;
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