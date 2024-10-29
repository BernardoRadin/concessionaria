@extends('dashboard')

@section('content_dashboard')

<section class="sales-section">
    <h2 class="section-title">Vendas</h2>
    
    <div class="sales-header">
        <div class="search-bar">
            <input type="text" placeholder="Buscar vendas...">
        </div>
    </div>

    <div class="sales-list">
        <!-- Card 1 -->
        <div class="sale-card" onclick="openDetailModal('Nissan KICKS', '01/10/2024', 'R$ 99.000,00', 'João Silva', 'Veículo em excelente estado. Foi vendido com todos os documentos e garantia.')">
            <div class="sale-info">
                <h3>Nissan KICKS</h3>
                <p>Vendido em: 01/10/2024</p>
                <p>Preço: R$ 99.000,00</p>
                <p>Comprador: João Silva</p>
            </div>
            <div class="sale-actions">
                <i class="fas fa-pencil-alt" title="Editar"></i>
                <i class="fas fa-trash" title="Excluir"></i>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="sale-card" onclick="openDetailModal('Ford Fiesta', '15/09/2024', 'R$ 45.000,00', 'Maria Oliveira', 'Veículo em ótimo estado, com revisão recente.')">
            <div class="sale-info">
                <h3>Ford Fiesta</h3>
                <p>Vendido em: 15/09/2024</p>
                <p>Preço: R$ 45.000,00</p>
                <p>Comprador: Maria Oliveira</p>
            </div>
            <div class="sale-actions">
                <i class="fas fa-pencil-alt" title="Editar"></i>
                <i class="fas fa-trash" title="Excluir"></i>
            </div>
        </div>
    </div>

    <div id="detailModal" class="sales-modal">
        <div class="sales-modal-content">
            <span class="close" onclick="closeDetailModal()">&times;</span>
            <h2>Detalhes da Venda</h2>
            <p><strong>Veículo:</strong> <span id="detailVehicle"></span></p>
            <p><strong>Data da Venda:</strong> <span id="detailDate"></span></p>
            <p><strong>Preço:</strong> <span id="detailPrice"></span></p>
            <p><strong>Comprador:</strong> <span id="detailBuyer"></span></p>
            <p><strong>Observações:</strong></p>
            <p id="detailNotes"></p>
        </div>
    </div>

<div id="modalEdicaoVenda" class="modal-venda">
    <div class="modal-conteudo-venda">
        <span class="fechar-venda" onclick="fecharModal('modalEdicaoVenda')">&times;</span>
        <h2>Editar Venda</h2>
        <form id="formEditarVenda" onsubmit="enviarFormularioVenda(event)">
            <div class="formulario-edicao">
                <div class="campo-formulario-venda">
                    <label for="veiculoEdicao">Veículo:</label>
                    <input type="text" id="veiculoEdicao" name="veiculo" required>
                </div>
                <div class="campo-formulario-venda">
                    <label for="dataEdicao">Data de Venda:</label>
                    <input type="date" id="dataEdicao" name="data" required>
                </div>
                <div class="campo-formulario-venda">
                    <label for="precoEdicao">Preço:</label>
                    <input type="number" id="precoEdicao" name="preco" required>
                </div>
                <div class="campo-formulario-venda">
                    <label for="compradorEdicao">Comprador:</label>
                    <input type="text" id="compradorEdicao" name="comprador" required>
                </div>
                <div class="campo-formulario-venda">
                    <label for="vendedorEdicao">Vendedor:</label>
                    <input type="text" id="vendedorEdicao" name="vendedor" required>
                </div>
                <div class="campo-formulario-venda">
                    <label for="observacaoEdicao">Observação:</label>
                    <textarea id="observacaoEdicao" name="observacao" required></textarea>
                </div>
            </div>
            <button type="submit" class="botao-salvar">Salvar Alterações</button>
        </form>
    </div>
</div>

</section>

<div class="pagination">
    <a href="?page=1">1</a>
    <a href="?page=2">2</a>
    <a href="?page=3">3</a>
</div>

<script>
    function openDetailModal(vehicle, date, price, buyer, notes) {
        document.getElementById('detailVehicle').innerText = vehicle;
        document.getElementById('detailDate').innerText = date;
        document.getElementById('detailPrice').innerText = price;
        document.getElementById('detailBuyer').innerText = buyer;
        document.getElementById('detailNotes').innerText = notes;
        document.getElementById('detailModal').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    window.onclick = function(event) {
        var modal = document.getElementById('detailModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    }
</script>
@endsection
