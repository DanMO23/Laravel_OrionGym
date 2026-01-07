@extends('layouts.user-layout')

@section('header-user', 'Editar Funcionário')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-info text-white py-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-white text-info mr-3">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 font-weight-bold">Editar Funcionário</h4>
                            <small class="opacity-75">Atualize os dados do funcionário</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-4">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <strong>Verifique os erros:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    <form action="{{ route('funcionarios.update', $funcionario->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Seção: Dados Pessoais -->
                        <div class="section-divider mb-4">
                            <span class="section-title"><i class="fas fa-user mr-2"></i>Dados Pessoais</span>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom" for="nome">
                                    Nome Completo <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light border-right-0">
                                            <i class="fas fa-user text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="nome" id="nome" 
                                           class="form-control border-left-0 @error('nome') is-invalid @enderror" 
                                           value="{{ old('nome', $funcionario->nome_completo) }}"
                                           placeholder="Digite o nome completo"
                                           required>
                                </div>
                                @error('nome')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom" for="email">
                                    E-mail <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light border-right-0">
                                            <i class="fas fa-envelope text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="email" name="email" id="email" 
                                           class="form-control border-left-0 @error('email') is-invalid @enderror" 
                                           value="{{ old('email', $funcionario->email) }}"
                                           placeholder="email@exemplo.com"
                                           required>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom" for="telefone">
                                    Telefone <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light border-right-0">
                                            <i class="fas fa-phone text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="telefone" id="telefone" 
                                           class="form-control border-left-0 @error('telefone') is-invalid @enderror" 
                                           value="{{ old('telefone', $funcionario->telefone) }}"
                                           placeholder="(00) 00000-0000"
                                           maxlength="15"
                                           required>
                                </div>
                                @error('telefone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom" for="sexo">
                                    Sexo <span class="text-danger">*</span>
                                </label>
                                <select name="sexo" id="sexo" 
                                        class="form-control form-control-lg custom-select @error('sexo') is-invalid @enderror" required>
                                    <option value="">Selecione...</option>
                                    <option value="M" {{ old('sexo', $funcionario->sexo) == 'M' ? 'selected' : '' }}>👨 Masculino</option>
                                    <option value="F" {{ old('sexo', $funcionario->sexo) == 'F' ? 'selected' : '' }}>👩 Feminino</option>
                                </select>
                                @error('sexo')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom" for="endereco">
                                    Endereço <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light border-right-0">
                                            <i class="fas fa-map-marker-alt text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="endereco" id="endereco" 
                                           class="form-control border-left-0 @error('endereco') is-invalid @enderror" 
                                           value="{{ old('endereco', $funcionario->endereco) }}"
                                           placeholder="Endereço completo"
                                           required>
                                </div>
                                @error('endereco')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom" for="cargo">
                                    Cargo <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light border-right-0">
                                            <i class="fas fa-briefcase text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="cargo" id="cargo" 
                                           class="form-control border-left-0 @error('cargo') is-invalid @enderror" 
                                           value="{{ old('cargo', $funcionario->cargo) }}"
                                           placeholder="Ex: Recepcionista, Auxiliar"
                                           required>
                                </div>
                                @error('cargo')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Seção: Foto -->
                        <div class="section-divider mb-4 mt-4">
                            <span class="section-title"><i class="fas fa-camera mr-2"></i>Foto <span class="text-muted font-weight-normal">(opcional)</span></span>
                        </div>

                        <div class="form-group mb-4">
                            <div class="custom-file-upload">
                                <div class="upload-area" id="uploadArea">
                                    <div class="upload-content text-center">
                                        <div class="preview-container" id="previewContainer" style="{{ $funcionario->foto ? 'display: inline-block;' : 'display: none;' }}">
                                            <img id="imagePreview" src="{{ $funcionario->foto ? asset('uploads/' . $funcionario->foto) : '' }}" alt="Preview" class="img-preview">
                                            <button type="button" class="btn btn-sm btn-danger btn-remove-image" id="removeImage">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="upload-placeholder" id="uploadPlaceholder" style="{{ $funcionario->foto ? 'display: none;' : '' }}">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                            <p class="mb-1 text-muted">Clique ou arraste uma nova imagem</p>
                                            <small class="text-muted">JPG, PNG ou GIF (máx. 2MB)</small>
                                        </div>
                                    </div>
                                    <input type="file" name="foto" id="foto" class="file-input" accept="image/*">
                                </div>
                            </div>
                            @error('foto')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Botões de Ação -->
                        <div class="form-actions pt-3 border-top mt-4">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('funcionarios.index') }}" class="btn btn-light btn-lg btn-block">
                                        <i class="fas fa-arrow-left mr-2"></i>Cancelar
                                    </a>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-warning btn-lg btn-block shadow-sm">
                                        <i class="fas fa-save mr-2"></i>Atualizar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    }
    
    /* Mesmo CSS do create.blade.php */
    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    
    .opacity-75 {
        opacity: 0.75;
    }
    
    .form-label-custom {
        font-weight: 600;
        color: #344767;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.9rem;
    }
    
    .section-divider {
        position: relative;
        text-align: center;
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 0.5rem;
    }
    
    .section-title {
        background: #fff;
        padding: 0 1rem;
        color: #6c757d;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .form-control:focus {
        border-color: #17a2b8;
        box-shadow: 0 0 0 0.2rem rgba(23,162,184,.15);
    }
    
    .input-group-text {
        border-color: #ced4da;
    }
    
    .border-left-0 {
        border-left: 0 !important;
    }
    
    .border-right-0 {
        border-right: 0 !important;
    }
    
    .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        padding: 2rem;
        transition: all 0.3s ease;
        cursor: pointer;
        background: #f8f9fa;
        position: relative;
    }
    
    .upload-area:hover {
        border-color: #17a2b8;
        background: #e8f7fa;
    }
    
    .upload-area.dragover {
        border-color: #17a2b8;
        background: #d4f1f7;
    }
    
    .file-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    
    .img-preview {
        max-width: 150px;
        max-height: 150px;
        border-radius: 12px;
        object-fit: cover;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .preview-container {
        position: relative;
        display: inline-block;
    }
    
    .btn-remove-image {
        position: absolute;
        top: -8px;
        right: -8px;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-light {
        background: #f8f9fa;
        border-color: #dee2e6;
        color: #495057;
    }
    
    .btn-light:hover {
        background: #e9ecef;
        border-color: #ced4da;
    }
    
    .card {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .custom-select {
        height: calc(1.5em + 1.5rem + 2px);
        padding: 0.75rem 1rem;
    }
</style>

<script>
    document.getElementById('telefone').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length <= 11) {
            value = value.replace(/^(\d{2})(\d)/g, '($1) $2');
            value = value.replace(/(\d)(\d{4})$/, '$1-$2');
        }
        e.target.value = value;
    });

    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('foto');
    const previewContainer = document.getElementById('previewContainer');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const imagePreview = document.getElementById('imagePreview');
    const removeImageBtn = document.getElementById('removeImage');

    fileInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const file = e.target.files[0];
            
            if (file.size > 2 * 1024 * 1024) {
                alert('A imagem deve ter no máximo 2MB');
                fileInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                previewContainer.style.display = 'inline-block';
                uploadPlaceholder.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    });

    removeImageBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        fileInput.value = '';
        previewContainer.style.display = 'none';
        uploadPlaceholder.style.display = 'block';
        // Limpar o src para garantir que não envie lixo se for submetido, 
        // mas o backend que decide se remove ou não.
        // Se a pessoa remover a imagem no preview, talvez ela queira excluir a foto atual?
        // O formulário padrão não remove a foto antiga a menos que enviemos um campo hidden.
        // Como o backend atual não parece suportar remoção explícita no update (só substituição),
        // este botão serve mais para "cancelar a seleção de nova foto".
        imagePreview.src = '';
        
        // Se já tinha foto antes, talvez devêssemos restaurar a visualização da foto original?
        @if($funcionario->foto)
            imagePreview.src = "{{ asset('uploads/' . $funcionario->foto) }}";
            previewContainer.style.display = 'inline-block';
            uploadPlaceholder.style.display = 'none';
        @endif
    });

    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        
        if (e.dataTransfer.files && e.dataTransfer.files[0]) {
            fileInput.files = e.dataTransfer.files;
            const event = new Event('change');
            fileInput.dispatchEvent(event);
        }
    });
</script>
@endsection
