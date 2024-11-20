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
                    <div><strong>Combustível:</strong> <span id="modal-veiculo-combustivel">{{ $veiculo->Combustivel == 'A' ? 'Álcool' : ($veiculo->Combustivel == 'G' ? 'Gasolina' : ($veiculo->Combustivel == 'E' ? 'Elétrico' : ($veiculo->Combustivel == 'F' ? 'Álcool e Gasolina' : 'Diesel'))) }} </span></div>
                    <div><strong>Categoria:</strong> <span id="modal-veiculo-categoria">{{$veiculo->Categoria->Nome}}</span></div>
                    <div><strong>Marca:</strong> <span id="modal-veiculo-marca">{{$veiculo->Marca->Nome}}</span></div>
                    <div><strong>Cor:</strong> <span id="modal-veiculo-cor">{{$veiculo->Cor}}</span></div>
                    <div><strong>Valor Compra:</strong> <span id="modal-veiculo-precocusto">R$ {{ number_format($veiculo->PrecoCusto,2, ',', '.') }}</span></div>
                    <div><strong>Valor Venda:</strong> <span id="modal-veiculo-precovenda">R$ {{ number_format($veiculo->PrecoVenda,2, ',', '.') }}</span></div>
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
                preview.src = e.target.result;
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            const icon = document.getElementById(id + '-icon');

            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
                icon.style.transform = 'rotate(0deg)';
            } else {
                dropdown.style.display = 'block';
                icon.style.transform = 'rotate(180deg)';
            }
        }
    
</script>

<style>

.modal-view-veiculo {
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

.vehicle-card {
    max-height: 300px;
    min-height: 300px;
}

.modal-content {
    display: flex;
    padding: 20px;
    gap: 20px;
}
</style>

@endsection