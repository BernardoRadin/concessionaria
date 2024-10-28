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
        <div class="sale-card" onclick="abrirModalDetalhes('Nissan KICKS', '01/10/2024', 'R$ 99.000,00', 'João Silva', 'Nenhuma observação.')">
            <div class="sale-info">
                <h3>Nissan KICKS</h3>
                <p>Vendido em: 01/10/2024</p>
                <p>Preço: R$ 99.000,00</p>
                <p>Comprador: João Silva</p>
            </div>
            <div class="sale-actions">
                <!-- Abre o modal de edição de venda -->
                <i class="fas fa-edit" onclick="event.stopPropagation(); abrirModal('modalEdicaoVenda')"></i>
                <!-- Abre o modal de confirmação de exclusão -->
                <i class="fas fa-times" onclick="event.stopPropagation(); abrirModal('modalConfirmacaoExclusao')"></i>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="sale-card" onclick="abrirModalDetalhes('Ford Fiesta', '15/09/2024', 'R$ 45.000,00', 'Maria Oliveira', 'Nenhuma observação.')">
            <div class="sale-info">
                <h3>Ford Fiesta</h3>
                <p>Vendido em: 15/09/2024</p>
                <p>Preço: R$ 45.000,00</p>
                <p>Comprador: Maria Oliveira</p>
            </div>
            <div class="sale-actions">
                <i class="fas fa-edit" onclick="event.stopPropagation(); abrirModal('modalEdicaoVenda')"></i>
                <i class="fas fa-times" onclick="event.stopPropagation(); abrirModal('modalConfirmacaoExclusao')"></i>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="sale-card" onclick="abrirModalDetalhes('Volkswagen Fusca', '24/10/2024', 'R$ 9.000,00', 'Gustavo Kissel', 'Nenhuma observação.')">
            <div class="sale-info">
                <h3>Volkswagen Fusca</h3>
                <p>Vendido em: 24/10/2024</p>
                <p>Preço: R$ 9.000,00</p>
                <p>Comprador: Gustavo Kissel</p>
            </div>
            <div class="sale-actions">
                <i class="fas fa-edit" onclick="event.stopPropagation(); abrirModal('modalEdicaoVenda')"></i>
                <i class="fas fa-times" onclick="event.stopPropagation(); abrirModal('modalConfirmacaoExclusao')"></i>
            </div>
        </div>
    </div>

    <!-- Modal de Detalhes da Venda -->
    <div id="detailModal" class="sales-modal">
        <div class="sales-modal-content">
            <span class="close" onclick="fecharModal('detailModal')">&times;</span>
            <h2>Detalhes da Venda</h2>
            <p><strong>Veículo:</strong> <span id="detailVehicle"></span></p>
            <p><strong>Data da Venda:</strong> <span id="detailDate"></span></p>
            <p><strong>Preço:</strong> <span id="detailPrice"></span></p>
            <p><strong>Comprador:</strong> <span id="detailBuyer"></span></p>
            <p><strong>Observações:</strong></p>
            <p id="detailNotes"></p>
        </div>
    </div>

    <!-- Modal de Edição de Venda -->
    <div id="modalEdicaoVenda" class="modal-venda">
        <div class="modal-conteudo-venda">
            <span class="fechar-venda" onclick="fecharModal('modalEdicaoVenda')">&times;</span>
            <h2>Editar Venda</h2>
            <form id="formEditarVenda" onsubmit="enviarFormularioVenda(event)">
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
                <button type="submit" class="botao-salvar">Salvar Alterações</button>
            </form>
        </div>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <div id="modalConfirmacaoExclusao" class="modal-confirmacao">
        <div class="modal-content-confirmacao">
            <span class="fechar" onclick="fecharModal('modalConfirmacaoExclusao')">&times;</span>
            <h2>Confirmação de Exclusão</h2>
            <p id="mensagemConfirmacao">Tem certeza de que deseja excluir essa venda?</p>
            <div class="botoes-confirmacao">
                <button class="btn-sim" onclick="confirmarExclusao()">Sim</button>
                <button class="btn-nao" onclick="fecharModal('modalConfirmacaoExclusao')">Não</button>
            </div>
        </div>
    </div>

</section>

<!-- Script -->
<script>
    // Função para abrir modal de detalhes
    function abrirModalDetalhes(veiculo, data, preco, comprador, observacoes) {
        document.getElementById('detailVehicle').innerText = veiculo;
        document.getElementById('detailDate').innerText = data;
        document.getElementById('detailPrice').innerText = preco;
        document.getElementById('detailBuyer').innerText = comprador;
        document.getElementById('detailNotes').innerText = observacoes;
        abrirModal('detailModal');
    }

    // Função para abrir modal
    function abrirModal(id) {
        document.getElementById(id).style.display = 'flex';
    }

    // Função para fechar modal
    function fecharModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    // Fecha modais ao clicar fora deles
    window.onclick = function(event) {
        var modais = ['detailModal', 'modalEdicaoVenda', 'modalConfirmacaoExclusao'];
        modais.forEach(function(modalId) {
            var modal = document.getElementById(modalId);
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    }

    // Envio de formulário de edição de venda
    function enviarFormularioVenda(event) {
        event.preventDefault();
        // Lógica para salvar alterações aqui...
        fecharModal('modalEdicaoVenda');
    }

    // Função de confirmação de exclusão
    function confirmarExclusao() {
        // Lógica para excluir venda...
        fecharModal('modalConfirmacaoExclusao');
    }
</script>

@endsection