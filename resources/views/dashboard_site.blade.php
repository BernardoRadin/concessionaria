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

<section class="main-container">
    <h1>Editar Informações do Site</h1>
    <form class="form" id="formSite" action="{{ route('site.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group logo-group">
            <label for="logo">
                <i class="fas fa-upload"></i> Upload da Logo
            </label>
            <div class="image-preview">
                <img src="{{ asset($site->Logo ? $site->Logo : 'default-logo.png') }}" alt="Pré-visualização" id="logo-preview" />
            </div>
            <input type="file" name="logo" id="logo" accept="image/*" onchange="previewImage(event)" />
        </div>

        <div class="form-group">
            <label for="email">
                <i class="fas fa-envelope"></i> Email
            </label>
            <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email', $site->Email) }}" />
        </div>

        <div class="form-group">
            <label for="telefone">
                <i class="fas fa-phone-alt"></i> Telefone
            </label>
            <input type="text" name="telefone" id="telefone" placeholder="Telefone" maxlength="15" value="{{ old('telefone', $site->Telefone) }}" />
        </div>

        <div class="form-group">
            <label for="instagram">
                <i class="fab fa-instagram"></i> Instagram
            </label>
            <input type="text" name="instagram" id="instagram" placeholder="Instagram" value="{{ old('instagram', $site->Instagram) }}" />
        </div>

        <div class="form-group">
            <label for="facebook">
                <i class="fab fa-facebook"></i> Facebook
            </label>
            <input type="text" name="facebook" id="facebook" placeholder="Facebook" value="{{ old('facebook', $site->Facebook) }}" />
        </div>

        <div class="form-group">
            <label for="whatsapp">
                <i class="fab fa-whatsapp"></i> Whatsapp
            </label>
            <input type="text" name="whatsapp" id="whatsapp" placeholder="Whatsapp" maxlength="15" value="{{ old('whatsapp', $site->Whatsapp) }}" />
        </div>

        <div class="form-group">
            <label for="endereco">
                <i class="fas fa-map-marker-alt"></i> Endereço
            </label>
            <input type="text" name="endereco" id="endereco" placeholder="Endereço" value="{{ old('endereco', $site->Endereco) }}" />
        </div>

        <div class="form-group full-width">
            <label for="sobre">
                <i class="fas fa-info-circle"></i> Sobre Nós
            </label>
            <textarea name="sobre" id="sobre" placeholder="Sobre Nós">{{ old('sobre', $site->Sobre) }}</textarea>
        </div>

        <div class="button-group">
            <button type="submit" class="save-button">
                <i class="fas fa-save"></i> Salvar Alterações
            </button>
            </a>
        </div>
    </form>
</section>
<script>

    $('#telefone').mask('(00) 00000-0000');
    $('#whatsapp').mask('(00) 0000-0000');

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

        function previewImage(event) {
        const preview = document.getElementById('logo-preview');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }

</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

* {
  box-sizing: border-box;
  font-family: 'Roboto', sans-serif;
}

.main-container {
  padding: 20px;
  background-color: #ffffff;
  border-radius: 8px;
  box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
  max-width: 900px;
  margin: 20px auto;
}

h1 {
  font-size: 20px;
  font-weight: 700;
  color: #0a0a23;
  text-align: center;
  margin-bottom: 18px;
}

.form {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 30px;
}

.form-group {
  display: flex;
  flex-direction: column;
  position: relative;
}

.form-group label {
  font-weight: 500;
  color: #555;
  margin-bottom: 4px;
  font-size: 14px;
  display: flex;
  align-items: center;
  gap: 6px;
}

.form-group.full-width {
  grid-column: span 3;
}

input, textarea {
  padding: 8px; /* Diminuindo o padding */
  font-size: 14px;
  border: 1px solid #ddd;
  border-radius: 4px;
  outline: none;
  transition: border-color 0.3s;
}

input:focus, textarea:focus {
  border-color: #007bff;
}

textarea {
  resize: vertical;
  max-height: 150px;
  min-height: 120px;
}

.form-group.logo-group {
  grid-column: span 3;
  text-align: center;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 150px;
}

.form-group.logo-group {
  grid-column: span 3;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 150px;
  width: 100%;
}

#logo-preview {
  display: block;
  margin: 0 auto;
  max-width: 300px;
  min-width: 300px;
  height: auto;
  padding: 3px;
  border-radius: 4px;
  object-fit: cover;
}

.image-preview {
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px dashed #ccc;
    border-radius: 5px;
    width: 300px;
    height: 300px;
    position: relative;
    overflow: hidden;
    background-color: #f9f9f9;
    margin-left: 10px;
    margin-top: 10px;
    margin-bottom: 10px; 
}

.button-group {
  grid-column: span 3;
  display: flex;
  justify-content: center;
  gap: 12px;
  margin-top: 10px;
}

.save-button, .cancel-button {
  font-size: 14px;
  font-weight: 500;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s, box-shadow 0.3s;
  display: flex;
  align-items: center;
  gap: 6px;
}

.save-button {
  background-color: #0a0a23;
  color: white;
}

.save-button:hover {
  background-color: #2c2c5f;
  box-shadow: 0px 4px 8px rgba(0, 91, 187, 0.3);
}

</style>

@endsection