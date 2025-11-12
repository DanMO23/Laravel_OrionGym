@extends('layouts.user-layout')

@section('header-user', 'Cadastrar Professor')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Cadastrar Professor</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Professores</a></li>
                    <li class="breadcrumb-item active">Cadastrar</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-user-plus"></i> Novo Professor</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('professores.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nome_completo">Nome Completo *</label>
                                        <input type="text" name="nome_completo" id="nome_completo" 
                                               class="form-control @error('nome_completo') is-invalid @enderror" 
                                               value="{{ old('nome_completo') }}" required>
                                        @error('nome_completo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefone">Telefone *</label>
                                        <input type="text" name="telefone" id="telefone" 
                                               class="form-control @error('telefone') is-invalid @enderror" 
                                               value="{{ old('telefone') }}" required>
                                        @error('telefone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sexo">Sexo *</label>
                                        <select name="sexo" id="sexo" 
                                                class="form-control @error('sexo') is-invalid @enderror" required>
                                            <option value="">Selecione...</option>
                                            <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                                            <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Feminino</option>
                                        </select>
                                        @error('sexo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cargo">Cargo *</label>
                                        <input type="text" name="cargo" id="cargo" 
                                               class="form-control @error('cargo') is-invalid @enderror" 
                                               value="{{ old('cargo', 'Professor') }}" required>
                                        @error('cargo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipo">Tipo de Professor *</label>
                                        <select name="tipo" id="tipo" 
                                                class="form-control @error('tipo') is-invalid @enderror" required>
                                            <option value="">Selecione...</option>
                                            <option value="integral" {{ old('tipo') == 'integral' ? 'selected' : '' }}>Professor Integral</option>
                                            <option value="personal" {{ old('tipo') == 'personal' ? 'selected' : '' }}>Personal Trainer</option>
                                            <option value="ambos" {{ old('tipo') == 'ambos' ? 'selected' : '' }}>Ambos</option>
                                        </select>
                                        @error('tipo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="endereco">Endereço</label>
                                <input type="text" name="endereco" id="endereco" 
                                       class="form-control @error('endereco') is-invalid @enderror" 
                                       value="{{ old('endereco') }}">
                                @error('endereco')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="foto">Foto</label>
                                <input type="file" name="foto" id="foto" 
                                       class="form-control-file @error('foto') is-invalid @enderror" 
                                       accept="image/*">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Formatos aceitos: JPG, PNG, GIF (máx. 2MB)</small>
                            </div>

                            <div class="alert alert-info mt-3">
                                <i class="fas fa-info-circle"></i> 
                                <strong>Nota:</strong> Se o tipo for "Personal Trainer" ou "Ambos", 
                                será gerado automaticamente um número de matrícula começando em 8000.
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Salvar
                                </button>
                                <a href="{{ route('professores.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
