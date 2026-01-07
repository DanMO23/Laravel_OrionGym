@extends('layouts.user-layout')

@section('header-user', 'Cadastrar Aluno de Personal')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-white text-primary mr-3">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 font-weight-bold">Novo Aluno de Personal</h4>
                            <small class="opacity-75">Cadastro rápido</small>
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

                    <form action="{{ route('alunos-personal.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tipo_aluno" value="externo">
                        
                        <!-- Seleção do Personal Trainer -->
                        <div class="form-group mb-4">
                            <label class="form-label-custom">
                                <i class="fas fa-chalkboard-teacher text-primary mr-2"></i>Personal Trainer <span class="text-danger">*</span>
                            </label>
                            <select name="professor_id" id="professor_id" 
                                    class="form-control form-control-lg custom-select @error('professor_id') is-invalid @enderror" required>
                                <option value="">Selecione o Personal Trainer...</option>
                                @foreach($professores as $prof)
                                    <option value="{{ $prof->id }}" {{ old('professor_id') == $prof->id ? 'selected' : '' }}>
                                        {{ $prof->nome_completo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('professor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nome do Aluno -->
                        <div class="form-group mb-4">
                            <label class="form-label-custom" for="nome_completo">
                                <i class="fas fa-user text-primary mr-2"></i>Nome do Aluno <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-lg">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0">
                                        <i class="fas fa-user text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" name="nome_completo" id="nome_completo" 
                                       class="form-control border-left-0 @error('nome_completo') is-invalid @enderror" 
                                       value="{{ old('nome_completo') }}"
                                       placeholder="Digite o nome completo do aluno"
                                       required>
                            </div>
                            @error('nome_completo')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Botões de Ação -->
                        <div class="form-actions pt-3 border-top">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('alunos-personal.index') }}" class="btn btn-light btn-lg btn-block">
                                        <i class="fas fa-arrow-left mr-2"></i>Voltar
                                    </a>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block shadow-sm">
                                        <i class="fas fa-save mr-2"></i>Cadastrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Card -->
            <div class="alert alert-info mt-4 shadow-sm">
                <div class="d-flex align-items-start">
                    <i class="fas fa-info-circle fa-2x text-info mr-3 mt-1"></i>
                    <div>
                        <h6 class="font-weight-bold mb-1">Cadastro Simplificado</h6>
                        <p class="mb-0 small">
                            Apenas o nome é necessário para vincular o aluno ao Personal Trainer. 
                            O dia de vencimento será definido automaticamente como dia 10 do mês.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    }
    
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
    
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.15);
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
@endsection
