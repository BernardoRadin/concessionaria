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
                    <p class="price">R$ {{ number_format($veiculo->PrecoVenda,2, ',', '.') }} </p>
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
                    <input type="text" name="precocusto" placeholder="Valor Compra" required>
                    <input type="text" name="precovenda" placeholder="Valor Venda" required>
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

@endsection