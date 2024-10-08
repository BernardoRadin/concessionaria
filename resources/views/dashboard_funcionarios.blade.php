@extends('dashboard')

@section('content_dashboard')

        <section class="main-content">
            <h2>Seus Funcionários</h2>
            <div class="employee-section">
                <div class="add-employee">
                    <i class="fas fa-plus-circle" onclick="openEmployeeModal()"></i>
                    <p>Cadastre um funcionário</p>
                </div>
                
                <!-- Cards de Funcionário -->
                @foreach($funcionarios as $funcionario)

                <div class="employee-card">
                    <!-- <div class="employee-photo" style="cursor: pointer;" onclick="abrirModalVisualizacao('Mateus Alves', 'Vendedor', 'email@exemplo.com', '(XX) XXXX-XXXX', 'Endereço do Funcionário')">
                        <img src="carteira-de-identidade.png" alt="Foto do Funcionário">
                    </div> -->
                    <div class="employee-info">
                        <h3 onclick="abrirModalVisualizacao('Mateus Alves', 'Vendedor', 'email@exemplo.com', '(XX) XXXX-XXXX', 'Endereço do Funcionário')" class="employee-name">{{ $funcionario->Nome }}</h3>
                        <p>{{ $funcionario->Email }}</p>
                        <p>{{ $funcionario->Telefone }}</p>
                        <p>{{ $funcionario->CPF }}</p>
                    </div>
                    <div class="employee-actions">
                        <i class="fas fa-edit" onclick="abrirModalEdicao()"></i>
                        <form action="{{ route('funcionarios.delete', $funcionario->ID) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')    
                        <button type='submit'><i class="fas fa-times" onclick="return confirm('Tem certeza que deseja deletar este funcionário?');"></i></button>
                        </form>
                    </div>
                </div>
                @endforeach
        </div>
        </section>

        <div class="pagination">
            <a href="?page=1">1</a>
            <a href="?page=2">2</a>
            <a href="?page=3">3</a>
            <!-- Mais páginas podem ser adicionadas dinamicamente -->
        </div>
    
        <!-- Modal de Cadastro -->
        <div id="employeeModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeEmployeeModal()">&times;</span>
                <h2>Cadastre o funcionário</h2>
                <div class="form-container">
                    <!-- Seção de Foto -->
                    <div class="photo-section">
                        <div class="photo-upload" onclick="uploadPhoto()">
                            <i class="fas fa-camera"></i>
                            <p>Adicione a foto</p>
                        </div>
                    </div>
                    <!-- Seção de Detalhes do Funcionário -->
                    <div class="employee-details" >
                    <form action="{{ route('funcionarios.create') }}" method="POST">
                        @csrf
                        <input type="text" name='nome' id="nome" placeholder="Nome" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" />
                        <input type="text" name='telefone' id="telefone" placeholder="Telefone" maxlength="15" />
                        <input type="text" name='cpf' id="cpf" placeholder="CPF" maxlength="14" oninput="mascaraCPF(this)" />
                        <select id='sexo' name='sexo'>
                            <option value="" disabled selected>Sexo</option>
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                            <option value="NaoPrefiroResponder">Prefiro não Responder</option>
                        </select>
                        <input type="text" name='dataNasc' id="dataNascimento" placeholder="Data de Nascimento" maxlength="10" oninput="mascaraData(this)" />
                        <select id='cargo' name='id_cargo'>
                            <option value="" disabled selected>Selecione o cargo</option>
                            <option value="1">Chefe</option>
                        </select>
                        <input type="email" name='email' id="email" placeholder="Email" />
                        <div class="password-field">
                            <input type="password" placeholder="Senha" name='senha' id="senha" />
                            <i class="fas fa-eye" id="toggleSenha"></i>
                        </div>
                        <!-- <input type="text" placeholder="Endereço" name='endereco' class="address-full-width" /> -->
                    </div>
                </div>
                <button id="cadastrarBtn" type="submit">Cadastrar</button>
                </form>
            </div>
        </div>
    <!-- Visualizar as informações do Funcionário -->
    <div class="modal-view-funcionario" id="modalVisualizarFuncionario">
        <div class="modal-content-view">
            <span class="close-view" onclick="fecharModalVisualizarFuncionario()">&times;</span>
            <h2>Informações do Funcionário</h2>
            <div class="campo-view">
                <label for="viewNome">Nome:</label>
                <p id="viewNome">Nome do Funcionário</p>
            </div>
            <div class="campo-view">
                <label for="viewCargo">Cargo:</label>
                <p id="viewCargo">Cargo do Funcionário</p>
            </div>
            <div class="campo-view">
                <label for="viewEmail">Email:</label>
                <p id="viewEmail">email@exemplo.com</p>
            </div>
            <div class="campo-view">
                <label for="viewTelefone">Telefone:</label>
                <p id="viewTelefone">(XX) XXXX-XXXX</p>
            </div>
            <div class="campo-view">
                <label for="viewEndereco">Endereço:</label>
                <p id="viewEndereco">Endereço do Funcionário</p>
            </div>
        </div>
    </div>
<!-- Editar as informações do Funcionário -->
    <div id="modalEdicao" class="modal">
        <div class="modal-conteudo">
            <span class="fechar" onclick="fecharModal('modalEdicao')">&times;</span>
            <h2>Editar Funcionário</h2>
            <form id="formEditarFuncionario">
                <div class="campo-formulario">
                    <label for="nomeEdicao">Nome:</label>
                    <input type="text" id="nomeEdicao" required oninput="this.value=this.value.replace(/[^A-Za-zÀ-ÿ ]/g,'');">
                </div>
                <div class="campo-formulario">
                    <label for="emailEdicao">E-mail:</label>
                    <input type="email" id="emailEdicao" required>
                </div>
                <div class="campo-formulario">
                    <label for="telefoneEdicao">Telefone:</label>
                    <input type="tel" id="telefoneEdicao" required oninput="mascaraTelefone(this)">
                </div>
                <div class="campo-formulario">
                    <label for="cargoEdicao">Cargo:</label>
                    <input type="text" id="cargoEdicao" required oninput="this.value=this.value.replace(/[^A-Za-zÀ-ÿ ]/g,'');">
                </div>
                <div class="campo-formulario">
                    <label for="enderecoEdicao">Endereço:</label>
                    <input type="text" id="enderecoEdicao" required>
                </div>
                <button type="submit" class="botao-salvar">Salvar Alterações</button>
            </form>
        </div>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal-confirmacao" id="modalConfirmacaoExclusao">
        <div class="modal-content-confirmacao">
            <span class="fechar" onclick="fecharModal('modalConfirmacaoExclusao')">&times;</span>
            <h2>Confirmação de Exclusão</h2>
            <p>Tem certeza de que deseja excluir este funcionário?</p>
            <div class="botoes-confirmacao">
                <button class="btn-sim" onclick="confirmarExclusao()">Sim</button>
                <button class="btn-nao" onclick="fecharModal('modalConfirmacaoExclusao')">Não</button>
            </div>
        </div>
    </div>


<script>
// Abrir o modal de funcionário
function openEmployeeModal() {
    document.getElementById('employeeModal').style.display = 'flex';
}

// Fechar o modal de funcionário
function closeEmployeeModal() {
    document.getElementById('employeeModal').style.display = 'none';
}

// Máscara para telefone
function mascaraTelefone(input) {
    input.value = input.value.replace(/\D/g, '') // Remove tudo o que não for dígito
        .replace(/^(\d{2})(\d)/, '($1) $2')      // Coloca parênteses nos dois primeiros dígitos
        .replace(/(\d{5})(\d{4})$/, '$1-$2');    // Coloca um hífen no meio do número
}

// Máscara para CPF
function mascaraCPF(input) {
    input.value = input.value.replace(/\D/g, '')  // Remove tudo o que não for dígito
        .replace(/(\d{3})(\d)/, '$1.$2')         // Coloca um ponto após os três primeiros dígitos
        .replace(/(\d{3})(\d)/, '$1.$2')         // Outro ponto após os próximos três
        .replace(/(\d{3})(\d{1,2})$/, '$1-$2');  // Coloca um hífen no meio
}

// Máscara para data de nascimento
function mascaraData(input) {
    input.value = input.value.replace(/\D/g, '')  // Remove tudo o que não for dígito
        .replace(/(\d{2})(\d)/, '$1/$2')         // Coloca uma barra após os dois primeiros dígitos (dia)
        .replace(/(\d{2})(\d)/, '$1/$2');        // Outra barra após os dois dígitos do mês
}

// Alternar visualização de senha
document.getElementById("toggleSenha").addEventListener("click", function() {
    const senhaInput = document.getElementById("senha");
    if (senhaInput.type === "password") {
        senhaInput.type = "text";
        this.classList.remove("fa-eye");
        this.classList.add("fa-eye-slash");
    } else {
        senhaInput.type = "password";
        this.classList.remove("fa-eye-slash");
        this.classList.add("fa-eye");
    }
});

// Função para abrir o modal de edição
function abrirModalEdicao() {
    // Preencher os campos com dados fictícios (substitua por dados reais)
    document.getElementById("nomeEdicao").value = "Nome do Funcionário";
    document.getElementById("emailEdicao").value = "email@exemplo.com";
    document.getElementById("telefoneEdicao").value = "(XX) XXXXX-XXXX";
    document.getElementById("cargoEdicao").value = "Cargo do Funcionário";
    document.getElementById("enderecoEdicao").value = "Endereço do Funcionário";

    document.getElementById('modalEdicao').style.display = 'flex';
}

// Função para fechar modais
function fecharModal(id) {
    document.getElementById(id).style.display = 'none';
}

// Fechar o modal ao clicar fora do conteúdo
window.onclick = function(event) {
    const modalEdicao = document.getElementById("modalEdicao");
    const modalVisualizacao = document.getElementById("modalVisualizarFuncionario");

    if (event.target === modalEdicao || event.target === modalVisualizacao) {
        fecharModal(event.target.id);
    }
}

// Fechar o modal ao pressionar a tecla "ESC"
document.onkeydown = function(event) {
    if (event.key === "Escape") {
        fecharModal('modalEdicao');
        fecharModal('modalVisualizarFuncionario');
        fecharModal('modalConfirmacaoExclusao');
    }
}

// Confirmar exclusão
function abrirModalConfirmacaoExclusao(element) {
    const modal = document.getElementById("modalConfirmacaoExclusao");
    modal.style.display = "block";
    modal.dataset.card = element.closest('.card-funcionario').dataset.cardId;
}

function confirmarExclusao() {
    const modal = document.getElementById("modalConfirmacaoExclusao");
    const cardId = modal.dataset.card;

    const card = document.querySelector(`.card-funcionario[data-card-id="${cardId}"]`);
    if (card) {
        card.remove();
    }
    fecharModal('modalConfirmacaoExclusao');
}

// Visualizar dados do funcionário
function abrirModalVisualizacao(nome, cargo, email, telefone, endereco) {
    document.getElementById('viewNome').innerText = nome;
    document.getElementById('viewCargo').innerText = cargo;
    document.getElementById('viewEmail').innerText = email;
    document.getElementById('viewTelefone').innerText = telefone;
    document.getElementById('viewEndereco').innerText = endereco;

    document.getElementById('modalVisualizarFuncionario').style.display = 'flex';
}

// Adicionando event listeners aos cards
document.querySelectorAll('.card-funcionario').forEach(card => {
    const nome = card.querySelector('.nome-funcionario').innerText;
    const cargo = card.querySelector('.cargo-funcionario').innerText;
    const email = card.querySelector('.email-funcionario').innerText;
    const telefone = card.querySelector('.telefone-funcionario').innerText;
    const endereco = card.querySelector('.endereco-funcionario').innerText;

    const foto = card.querySelector('.foto-funcionario');
    
    card.querySelector('.nome-funcionario').addEventListener('click', () => {
        abrirModalVisualizacao(nome, cargo, email, telefone, endereco);
    });
});

</script>

@endsection