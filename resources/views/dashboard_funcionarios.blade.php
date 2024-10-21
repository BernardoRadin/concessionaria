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
        <div class="employee-card" 
            data-card-id="{{ $funcionario->ID }}"
            data-telefone="{{ $funcionario->Telefone }}" 
            data-email="{{ $funcionario->Email }}" 
            data-cpf="{{$funcionario->CPF}}"
            data-endereco="{{ $funcionario->Endereco }}">
            <div class="employee-photo" style="cursor: pointer;">
                    <img src="{{ asset('imagens/carteira-de-identidade.png') }}" alt="Imagem Funcionário">
            </div>
            <div class="employee-info">
                <h3 class="employee-name">{{ $funcionario->Nome }}</h3>
                <p>{{ $funcionario->cargo->Nome }}</p>
            </div>
            <div class="employee-actions">
                <i class="fas fa-edit" onclick="abrirModalEdicao({ Nome: '{{ $funcionario->Nome }}', Email: '{{ $funcionario->Email }}', Telefone: '{{ $funcionario->Telefone }}' })"></i>
                <i class="fas fa-times" data-nome="{{ $funcionario->Nome }}" onclick="abrirModalConfirmacaoExclusao(this, this.dataset.nome)"></i>
                <form action="{{ route('funcionarios.delete', $funcionario->ID) }}" method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
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
        <h2>Cadastre o Funcionário</h2>
        <div class="modal-body">
            <div class="form-wrapper"> <!-- Wrapper para organizar o layout -->
                <div class="photo-section">
                    <div class="photo-upload">
                        <img src="{{ asset('imagens/funcionario.png') }}" alt="Funcionario" class="uploaded-image">
                    </div>
                </div>
                <form action="{{ route('funcionarios.create') }}" method="POST" class="employee-details">
                    @csrf
                    <input type="text" name='nome' id="nome" placeholder="Nome" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" />
                    <input type="text" name='telefone' id="telefone" placeholder="Telefone" maxlength="15" />
                    <input type="text" name='cpf' id="cpf" placeholder="CPF" maxlength="14" oninput="mascaraCPF(this)" />
                    <select id='sexo' name='sexo'>
                        <option value="" disabled selected>Sexo</option>
                        <option value="M">Masculino</option>
                        <option value="F">Feminino</option>
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
                    <input type="text" placeholder="Endereço" class="address-full-width" />
            </div> <!-- Fim do wrapper -->
            <!-- Botão fora do form e do wrapper -->
            <button id="cadastrarBtn" type="submit">Cadastrar</button>
            </form>
        </div>
    </div>
</div>

    <!-- Visualizar as informações do Funcionário -->
    <div class="modal-view-funcionario" id="modalVisualizarFuncionario">
        <div class="modal-content-view">
            <span class="close-view" onclick="fecharModalVisualizarFuncionario()">&times;</span>
            <div class="modal-header-view">
                <h2 id="viewNomeFuncionario">Nome do Funcionário</h2>
                <h3 id="viewCargoFuncionario">Cargo do Funcionário</h3>
            </div>
            <div class="modal-body-view">
                <div class="foto-view">
                    <img src="{{ asset('imagens/funcionario.png') }}" alt="View Funcionário" class="view-funcionario">
                </div>
                <div class="detalhes-view">
                    <p><strong>Telefone:</strong> <span id="viewTelefoneFuncionario">123-456-7890</span></p>
                    <p><strong>Email:</strong> <span id="viewEmailFuncionario">exemplo@email.com</span></p>
                    <p><strong>CPF:</strong> <span id="viewCpfFuncionario">123.456.789-00</span></p>
                    <p><strong>Endereço:</strong> <span id="viewEnderecoFuncionario">Rua Exemplo, 123</span></p>
                </div>
            </div>
        </div>
    </div>

<!-- Editar as informações do Funcionário -->
<div id="modalEdicao" class="modal">
    <div class="modal-conteudo">
        <span class="fechar" onclick="fecharModal('modalEdicao')">&times;</span>
        <h2>Editar Funcionário</h2>
        <form id="formEditarFuncionario" onsubmit="enviarFormulario(event)">
            @csrf
            @method('PUT')

            <div class="campo-formulario">
                <label for="nomeEdicao">Nome:</label>
                <input type="text" id="nomeEdicao" name="nome" required>
            </div>
            <div class="campo-formulario">
                <label for="emailEdicao">E-mail:</label>
                <input type="email" id="emailEdicao" name="email" required>
            </div>
            <div class="campo-formulario">
                <label for="telefoneEdicao">Telefone:</label>
                <input type="tel" id="telefoneEdicao" name="telefone" required>
            </div>
            <input type="hidden" id="idEdicao" name="id"> <!-- Campo oculto para armazenar o ID -->
            <button type="submit" class="botao-salvar">Salvar Alterações</button>
        </form>
    </div>
</div>

    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal-confirmacao" id="modalConfirmacaoExclusao">
    <div class="modal-content-confirmacao">
        <span class="fechar" onclick="fecharModal('modalConfirmacaoExclusao')">&times;</span>
        <h2>Confirmação de Exclusão</h2>
        <p id="mensagemConfirmacao">Tem certeza de que deseja excluir o funcionário <span id="nomeFuncionario"></span>?</p>
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

function abrirModalEdicao(funcionario) {
    document.getElementById('nomeEdicao').value = funcionario.Nome;
    document.getElementById('emailEdicao').value = funcionario.Email;
    document.getElementById('telefoneEdicao').value = funcionario.Telefone;

    // Coloque o ID do funcionário no campo oculto
    document.getElementById('idEdicao').value = funcionario.ID; 

    // Abre o modal
    document.getElementById('modalEdicao').style.display = 'block';  
}

async function enviarFormulario(event) {
    event.preventDefault(); // Previna o comportamento padrão do formulário

    const id = document.getElementById('idEdicao').value; // Obtenha o ID do campo oculto
    const formData = new FormData(document.getElementById('formEditarFuncionario'));

    try {
        const response = await fetch(`/funcionarios/${id}`, {
            method: 'PUT',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (response.ok) {
            fecharModal('modalEdicao');
            alert('Funcionário atualizado com sucesso!');
            // Opcional: atualize a tabela ou faça outras ações necessárias
        } else {
            const errorData = await response.json();
            alert('Não foi possível atualizar os dados do funcionário: ' + errorData.error);
        }
    } catch (error) {
        console.error('Erro:', error);
        alert('Ocorreu um erro ao tentar atualizar os dados do funcionário.');
    }
}

// Função para fechar modais
function fecharModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
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
function abrirModalConfirmacaoExclusao(element, nomeFuncionario) {
    const modal = document.getElementById("modalConfirmacaoExclusao");
    modal.style.display = "block";
    
    // Atualiza o texto com o nome do funcionário
    document.getElementById('nomeFuncionario').innerText = nomeFuncionario;

    // Obtém o ID do funcionário do card
    const cardFuncionario = element.closest('.employee-card');
    const cardId = cardFuncionario.dataset.cardId; // Armazena o ID no modal
    modal.dataset.cardId = cardId; // Armazena o ID no modal
}

function confirmarExclusao() {
    const modal = document.getElementById("modalConfirmacaoExclusao");
    const cardId = modal.dataset.cardId;

    // Seleciona o formulário correspondente ao funcionário
    const form = document.querySelector(`.employee-card[data-card-id="${cardId}"] form`);

    if (form) {
        form.submit(); // Submete o formulário para excluir no backend
    }

    fecharModal('modalConfirmacaoExclusao');
}

// Visualizar dados do funcionário
function abrirModalVisualizacao(nome, cargo, email, telefone, cpf, endereco) {
    // Abre o modal
    document.getElementById('modalVisualizarFuncionario').style.display = 'flex';

    // Preenche os campos do modal com os dados do funcionário
    document.getElementById('viewNomeFuncionario').innerText = nome;
    document.getElementById('viewCargoFuncionario').innerText = cargo;
    document.getElementById('viewEmailFuncionario').innerText = email;
    document.getElementById('viewEnderecoFuncionario').innerText = endereco;

    // Aplica a máscara correta no telefone
    const telefoneMascarado = telefone.replace(/\D/g, '') // Remove tudo o que não for dígito
        .replace(/^(\d{2})(\d)/, '($1) $2')      // Coloca parênteses nos dois primeiros dígitos
        .replace(/(\d{5})(\d{4})$/, '$1-$2');    // Coloca um hífen no meio do número

    // Aplica a máscara correta no CPF
    const cpfMascarado = cpf.replace(/\D/g, '')  // Remove tudo o que não for dígito
        .replace(/(\d{3})(\d)/, '$1.$2')         // Coloca um ponto após os três primeiros dígitos
        .replace(/(\d{3})(\d)/, '$1.$2')         // Outro ponto após os próximos três
        .replace(/(\d{3})(\d{1,2})$/, '$1-$2');  // Coloca um hífen no meio

    // Atribui os valores mascarados aos campos do modal
    document.getElementById('viewTelefoneFuncionario').innerText = telefoneMascarado;
    document.getElementById('viewCpfFuncionario').innerText = cpfMascarado;
}

function fecharModalVisualizarFuncionario() {
    document.getElementById('modalVisualizarFuncionario').style.display = 'none';
}

document.querySelectorAll('.employee-card').forEach((card, index) => {
    const editIcon = card.querySelector('.fas.fa-edit');
    const deleteIcon = card.querySelector('.fas.fa-times');

    const nome = card.querySelector('.employee-name').innerText;
    const cargo = card.querySelector('p').innerText;
    const email = card.dataset.email;
    const telefone = card.dataset.telefone;  // Verifique que está pegando o telefone
    const cpf = card.dataset.cpf;            // Verifique que está pegando o CPF
    const endereco = card.dataset.endereco;

    card.addEventListener('click', function(event) {
        if (event.target !== editIcon && event.target !== deleteIcon) {
            abrirModalVisualizacao(nome, cargo, email, telefone, cpf, endereco);
        }
    });
});

</script>

@endsection