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

<section class="sales-section">
    <h2 class="section-title">Vendas</h2>
    
    <div class="sales-header">
        <div class="search-bar">
            <input type="text" placeholder="Buscar vendas...">
        </div>
    </div>

    <div class="sales-list">
        @foreach($vendas as $venda)
        <div class="sale-card" data-card-id="{{ $venda->ID }}" onclick="openDetailModal('{{ $venda->veiculo->Nome }}', '{{ date('d/m/Y', strtotime($venda->Data)) }}', 'R$ {{ number_format($venda->PrecoVenda,2, ',', '.') }}', '{{ $venda->Cliente->Nome}}', '{{ $venda->Funcionario->Nome}}', '{{ $venda->Descricao}}')">
            <div class="sale-info">
                <h3>{{ $venda->veiculo->Nome }}</h3>
                <p>Vendido em: {{ date('d/m/Y', strtotime($venda->Data)) }}</p>
                <p>Preço: R$ {{ number_format($venda->PrecoVenda,2, ',', '.') }}</p>
                <p>Comprador: {{ $venda->Cliente->Nome}}</p>
            </div>
            <div class="sale-actions">
                <i class="fas fa-trash" id="deletar" title="Excluir" data-nome="{{ $venda->veiculo->Nome }}" onclick="abrirModalConfirmacaoExclusao(this, this.dataset.nome); event.stopPropagation();"></i>
                <form action="{{ route('vendas.delete', $venda->ID) }}" method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <div id="detailModal" class="sales-modal">
        <div class="sales-modal-content">
            <span class="close" onclick="closeDetailModal()">&times;</span>
            <h2>Detalhes da Venda</h2>
            <p><strong>Veículo:</strong> <span id="veiculo"></span></p>
            <p><strong>Data da Venda:</strong> <span id="data"></span></p>
            <p><strong>Preço:</strong> <span id="preco"></span></p>
            <p><strong>Comprador:</strong> <span id="comprador"></span></p>
            <p><strong>Funcionário (Vendedor):</strong> <span id="vendedor"></span></p>
            <p><strong>Observações:</strong></p>
            <p id="descricao"></p>
        </div>
    </div>
</section>

<div class="modal-confirmacao" id="modalConfirmacaoExclusao">
    <div class="modal-content-confirmacao">
        <span class="fechar" onclick="closeModalExclusao()">&times;</span>
        <h2>Confirmação de Exclusão</h2>
        <p id="mensagemConfirmacao">Tem certeza de que deseja excluir a venda do veículo <span id="nomeVeiculo"></span>?</p>
        <div class="botoes-confirmacao">
            <button class="btn-sim" onclick="confirmarExclusao()">Sim</button>
            <button class="btn-nao" onclick="fecharModal('modalConfirmacaoExclusao')">Não</button>
        </div>
    </div>
</div>

<div class="pagination">
    <a href="?page=1">1</a>
    <a href="?page=2">2</a>
    <a href="?page=3">3</a>
</div>

<script>
    function openDetailModal(veiculo, data, preco, comprador, vendedor, descricao) {
        document.getElementById('veiculo').innerText = veiculo;
        document.getElementById('data').innerText = data;
        document.getElementById('preco').innerText = preco;
        document.getElementById('comprador').innerText = comprador;
        document.getElementById('vendedor').innerText = vendedor;
        document.getElementById('descricao').innerText = descricao;
        document.getElementById('detailModal').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    function closeModalExclusao() {
        document.getElementById('modalConfirmacaoExclusao').style.display = 'none';
    }


    window.onclick = function(event) {
        var modal = document.getElementById('detailModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    }

    function abrirModalConfirmacaoExclusao(element, nomeVeiculo) {
        const modal = $('#modalConfirmacaoExclusao');
        modal.css('display', 'block');
        $('#nomeVeiculo').text(nomeVeiculo);
    
        const cardVenda = $(element).closest('.sale-card');
        const cardId = cardVenda.data('cardId');
        modal.data('cardId', cardId);
    }
    
    function confirmarExclusao() {

        const modal = $('#modalConfirmacaoExclusao');
        const cardId = modal.data('cardId');
        const form = $(`.sale-card[data-card-id="${cardId}"] form`);

        if (form.length) {
            form.submit();
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
@endsection
