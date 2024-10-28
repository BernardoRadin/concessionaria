@extends('dashboard')

@section('content_dashboard')

<section class="main-content">
    <h2>Seus Veículos</h2>
        <div class="vehicle-section">
            <div class="add-vehicle" onclick="openModal()">
                <i class="fas fa-plus-circle"></i>
                <p>Cadastre um veículo</p>
            </div>

        <div class="vehicle-card">
            <img src="carro.jpg" alt="Nissan KICKS 2020">
            <div class="vehicle-info">
                    <h3>Nissan/KICKS</h3>
                    <p>2020</p>
                    <p class="price">R$ 99.000,00</p>
                        </div>
                        <div class="vehicle-actions">
                            <i class="fas fa-times"></i>
                            <i class="fas fa-eye"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-pencil-alt"></i>
                        </div>
                    </div>

                    <div class="vehicle-card">
                        <img src="carro.jpg" alt="Nissan KICKS 2020">
                        <div class="vehicle-info">
                            <h3>Nissan/KICKS</h3>
                            <p>2020</p>
                            <p class="price">R$ 99.000,00</p>
                        </div>
                        <div class="vehicle-actions">
                            <i class="fas fa-times"></i>
                            <i class="fas fa-eye"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-pencil-alt"></i>
                        </div>
                    </div>

                    <div class="vehicle-card">
                    <img src="{{ asset('imagens/ecosport.webp') }}" alt="Imagem Veiculo" class="view-funcionario">
                        <div class="vehicle-info">
                            <h3>Nissan/KICKS</h3>
                            <p>2020</p>
                            <p class="price">R$ 99.000,00</p>
                        </div>
                        <div class="vehicle-actions">
                            <i class="fas fa-times"></i>
                            <i class="fas fa-eye"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-pencil-alt"></i>
                        </div>
                    </div>

                </div>
            </section>
        </main>
    </div>

    <!-- Modal de Cadastro de Veículo -->
    <div id="vehicleModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Cadastre o veículo</h2>
            <div class="form-container">
                <div class="photo-section">
                    <div class="photo-upload">
                        <i class="fas fa-plus"></i>
                        <p>Adicione as fotos</p>
                    </div>
                    <div class="photo-preview">
                        <div class="arrow">&lt;</div>
                        <div class="thumbnail"></div>
                        <div class="thumbnail"></div>
                        <div class="thumbnail"></div>
                        <div class="arrow">&gt;</div>
                    </div>
                </div>
                <div class="vehicle-details">
                <input type="text" placeholder="Nome">
                <input type="text" placeholder="Ano">
                <input type="text" placeholder="Modelo">
                <input type="text" placeholder="Portas">
                <input type="text" placeholder="Câmbio">
                <input type="text" placeholder="Motor">
                <input type="text" placeholder="Quilometragem">
                <input type="text" placeholder="Combustível">
                <input type="text" placeholder="Categoria">
                <input type="text" placeholder="Marca">
                <input type="text" placeholder="Cor">
                <input type="text" placeholder="Preço Custo">
                <input type="text" placeholder="Preço Venda">
                <input type="text" placeholder="Estoque">
                <input type="text" placeholder="Antigo Dono">
                <textarea placeholder="Descrição do Veículo"></textarea>
                </div>
            </div>
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
</script>

@endsection


