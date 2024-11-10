@extends('dashboard')

@section('content_dashboard')

<section class="main-content">
    <h2>Site</h2>
    <div class="modal-body">
        <form id="formSite" action="" method="POST" style='width: 100%'>
            @csrf
            @method('PUT')
            <div class="marca-logo-container" style='width: 49.5%'>
                <label for="logo" class="marca-logo-label">Upload da Logo</label>
                <div class="image-preview" id="imagePreview">
                    <img src="{{ asset('imagens/logo/sua-logo.png')}}" alt="Pré-visualização" class="image-preview__image-site-create" />
                </div>
                <input type="file" name="logo" id="logo" class="marca-logo" accept="image/*" onchange="previewImage(event)" />
            </div></br>
            <div class='employee-details'>
                <div class="field-group">
                    <label>Email: </label>
                    <input type="email" name='email' id="email" placeholder="Email" value="{{ $site->Email }}"/>
                </div>
                <div class="field-group">
                    <label>Telefone: </label>
                    <input type="text" name='telefone' id="telefone" placeholder="Telefone" maxlength="15" value="{{ $site->Telefone }}" />
                </div>
                <div class="field-group">
                    <label>Instagram: </label>
                    <input type="text" name='instagram' id="instagram" placeholder="Instagram" value="{{ $site->Instagram }}" />
                </div>
                <div class="field-group">
                    <label>Facebook: </label>
                    <input type="text" name='facebook' id="facebook" placeholder="Facebook" value="{{ $site->Facebook }}" />
                </div>
                <div class="field-group">
                    <label>Whatsapp: </label>
                    <input type="text" name='whatsapp' id="whatsapp" placeholder="Telefone" maxlength="15" value="{{ $site->Whatsapp }}" />
                </div>
                <div class="field-group">
                    <label>Endereço: </label>
                    <input type="text" id='endereco' name='Endereco' placeholder="Endereço" class="address-full-width" value="{{ $site->Endereco }}"/>
                </div>
                <div class="field-group">
                    <label>Sobre Nós: </label>
                    <textarea name="sobre" placeholder="Sobre Nós" class='text-area-site'>{{ $site->Sobre }}</textarea>
                </div>
            </div>
            <button type="submit" class="botao-salvar">Salvar Alterações</button>
        </form>
    </div>
</section>
<script>
    $('#telefone').mask('(00) 00000-0000');
    $('#whatsapp').mask('(00) 0000-0000');

</script>

@endsection