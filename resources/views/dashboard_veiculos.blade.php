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

        <!-- Outras vehicle-cards podem ser adicionadas aqui -->

    </div>
</section>

<!-- Modal de Cadastro de Veículo -->
<div id="vehicleModal" class="vehicle-modal">
    <div class="vehicle-modal-content">
        <span class="vehicle-close" onclick="closeModal()">&times;</span>
        <h2>Cadastre o veículo</h2>
        
        <div class="vehicle-form-container">
            <div class="photo-section">
                <h2>Envie Fotos do Veículo</h2>
                <input type="file" class="file-input" id="file-input" accept="image/*" multiple>
                <button class="upload-btn" id="select-btn">Selecionar Imagens</button>
                <div id="thumbnails"></div>
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

        $('#submit-btn').click(function() {
            const files = $('#file-input')[0].files;
            const formData = new FormData();
            const principalImageIndex = $('input[name="principal"]:checked').val();

            if (files.length === 0) {
                alert('Por favor, selecione imagens para enviar.');
                return;
            }

            // Adiciona as imagens ao FormData
            $.each(files, function(i, file) {
                formData.append('images[]', file);
            });

            // Adiciona a imagem principal ao FormData
            formData.append('principal', principalImageIndex);

            // Envia os dados via AJAX
            $.ajax({
                url: 'seu_endpoint_aqui', // Substitua pelo seu endpoint
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert('Imagens enviadas com sucesso!');
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    alert('Ocorreu um erro ao enviar as imagens.');
                    console.error(error);
                }
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