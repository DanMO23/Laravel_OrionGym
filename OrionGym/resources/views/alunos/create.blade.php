@extends('layouts.create')

@section('header-user', 'Criar Aluno')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-user-plus"></i> Criar Novo Aluno</h4>
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

                    <form method="POST" action="{{ route('alunos.store') }}">
                        @csrf

                        <!-- Informações Pessoais -->
                        <div class="section-title mb-3">
                            <h5 class="text-primary"><i class="fas fa-id-card"></i> Informações Pessoais</h5>
                            <hr>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nome" class="font-weight-bold">Nome Completo <span class="text-danger">*</span></label>
                                    <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" 
                                           name="nome" value="{{ old('nome') }}" required autofocus>
                                    @error('nome')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cpf" class="font-weight-bold">CPF <span class="text-danger">*</span></label>
                                    <input id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" 
                                           name="cpf" value="{{ old('cpf') }}" required>
                                    @error('cpf')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="data_nascimento" class="font-weight-bold">Data de Nascimento <span class="text-danger">*</span></label>
                                    <input id="data_nascimento" type="date" class="form-control @error('data_nascimento') is-invalid @enderror" 
                                           name="data_nascimento" value="{{ old('data_nascimento') }}" required>
                                    @error('data_nascimento')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sexo" class="font-weight-bold">Sexo <span class="text-danger">*</span></label>
                                    <select id="sexo" class="form-control @error('sexo') is-invalid @enderror" 
                                            name="sexo" required>
                                        <option value="">Selecione...</option>
                                        <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                                        <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Feminino</option>
                                    </select>
                                    @error('sexo')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Informações de Contato -->
                        <div class="section-title mb-3 mt-4">
                            <h5 class="text-primary"><i class="fas fa-phone"></i> Informações de Contato</h5>
                            <hr>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="font-weight-bold">Email</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefone" class="font-weight-bold">Telefone <span class="text-danger">*</span></label>
                                    <input id="telefone" type="tel" class="form-control @error('telefone') is-invalid @enderror" 
                                           name="telefone" value="{{ old('telefone') }}" required>
                                    @error('telefone')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Endereço -->
                        <div class="section-title mb-3 mt-4">
                            <h5 class="text-primary"><i class="fas fa-map-marker-alt"></i> Endereço</h5>
                            <hr>
                        </div>

                        <div class="form-group">
                            <label for="endereco" class="font-weight-bold">Endereço Completo <span class="text-danger">*</span></label>
                            <input id="endereco" type="text" class="form-control @error('endereco') is-invalid @enderror" 
                                   name="endereco" value="{{ old('endereco') }}" required 
                                   placeholder="Rua, número, bairro, cidade">
                            @error('endereco')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Botões de Ação -->
                        <div class="d-flex justify-content-center mt-4 gap-2">
                            <button type="submit" class="btn btn-primary btn-lg px-5 m-1">
                                <i class="fas fa-check"></i> Criar Aluno
                            </button>
                            <a href="{{ route('alunos.index') }}" class="btn btn-secondary btn-lg px-5 m-1">
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
</style>
@endsection