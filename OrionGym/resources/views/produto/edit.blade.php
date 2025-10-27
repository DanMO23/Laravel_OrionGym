@extends('layouts.user-layout')

@section('header-user', 'Editar Produto')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-edit"></i> Editar Produto</h4>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Atenção!</strong> Por favor, corrija os seguintes erros:
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('produto.update', $produto) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Foto Atual -->
                        @if($produto->foto)
                        <div class="section-title mb-3">
                            <h5 class="text-primary"><i class="fas fa-image"></i> Imagem Atual</h5>
                            <hr>
                        </div>

                        <div class="text-center mb-4">
                            <img src="{{ asset('uploads/produtos/' . $produto->foto) }}" 
                                 alt="Foto do Produto" 
                                 class="img-thumbnail" 
                                 style="max-width: 300px; max-height: 300px; object-fit: cover;">
                        </div>
                        @endif

                        <!-- Nova Foto -->
                        <div class="section-title mb-3">
                            <h5 class="text-primary"><i class="fas fa-image"></i> Alterar Imagem</h5>
                            <hr>
                        </div>

                        <div class="form-group">
                            <label for="foto" class="font-weight-bold">Nova Foto do Produto (PNG)</label>
                            <div class="custom-file">
                                <input type="file" name="foto" id="foto" 
                                       class="custom-file-input @error('foto') is-invalid @enderror" 
                                       accept="image/png">
                                <label class="custom-file-label" for="foto">Escolher arquivo...</label>
                            </div>
                            <small class="form-text text-muted">Deixe em branco para manter a imagem atual.</small>
                            @error('foto')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Estoque e Valor -->
                        <div class="section-title mb-3 mt-4">
                            <h5 class="text-primary"><i class="fas fa-dollar-sign"></i> Estoque e Preço</h5>
                            <hr>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quantidade_estoque" class="font-weight-bold">Quantidade em Estoque <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-boxes"></i></span>
                                        </div>
                                        <input type="number" name="quantidade_estoque" id="quantidade_estoque" 
                                               class="form-control @error('quantidade_estoque') is-invalid @enderror" 
                                               value="{{ old('quantidade_estoque', $produto->estoque) }}" required min="0">
                                        @error('quantidade_estoque')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="valor" class="font-weight-bold">Valor do Produto (R$) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="number" name="valor" id="valor" 
                                               class="form-control @error('valor') is-invalid @enderror" 
                                               value="{{ old('valor', $produto->valor) }}" step="0.01" required min="0">
                                        @error('valor')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botões de Ação -->
                        <div class="d-flex justify-content-center mt-4 gap-2">
                            <button type="submit" class="btn btn-primary btn-lg px-5 m-1">
                                <i class="fas fa-check"></i> Atualizar
                            </button>
                            <a href="{{ route('produto.index') }}" class="btn btn-secondary btn-lg px-5 m-1">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .section-title h5 {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .section-title hr {
        margin-top: 0.5rem;
        border-top: 2px solid #007bff;
        opacity: 0.3;
    }

    .form-group label {
        font-size: 0.9rem;
        color: #495057;
    }

    .form-control {
        border-radius: 5px;
        padding: 0.6rem 0.75rem;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .card {
        border-radius: 10px;
        border: none;
    }

    .gap-2 {
        gap: 0.5rem;
    }

    .btn-lg {
        font-weight: 500;
    }

    .text-danger {
        font-weight: bold;
    }

    .input-group-text {
        background-color: #e9ecef;
        border: 1px solid #ced4da;
    }
</style>

<script>
    // Atualizar o nome do arquivo selecionado
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        var label = e.target.nextElementSibling;
        label.textContent = fileName;
    });
</script>
@endsection