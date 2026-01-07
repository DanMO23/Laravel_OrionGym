@extends('layouts.user-layout')

@section('header-user', 'Editar Aluno de Personal')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-warning text-white py-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-white text-warning mr-3">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 font-weight-bold">Editar Aluno de Personal</h4>
                            <small class="opacity-75">{{ $alunoPersonal->nome_completo }}</small>
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

                    <form action="{{ route('alunos-personal.update', $alunoPersonal->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Seleção do Personal Trainer -->
                        <div class="form-group mb-4">
                            <label class="form-label-custom">
                                <i class="fas fa-chalkboard-teacher text-warning mr-2"></i>Personal Trainer <span class="text-danger">*</span>
                            </label>
                            <select name="professor_id" id="professor_id" 
                                    class="form-control form-control-lg custom-select @error('professor_id') is-invalid @enderror" required>
                                <option value="">Selecione o Personal Trainer...</option>
                                @foreach($professores as $prof)
                                    <option value="{{ $prof->id }}" {{ old('professor_id', $alunoPersonal->professor_id) == $prof->id ? 'selected' : '' }}>
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
                                <i class="fas fa-user text-warning mr-2"></i>Nome do Aluno <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-lg">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0">
                                        <i class="fas fa-user text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" name="nome_completo" id="nome_completo" 
                                       class="form-control border-left-0 @error('nome_completo') is-invalid @enderror" 
                                       value="{{ old('nome_completo', $alunoPersonal->nome_completo) }}"
                                       placeholder="Digite o nome completo do aluno"
                                       required>
                            </div>
                            @error('nome_completo')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Status -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom" for="status">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select name="status" id="status" 
                                        class="form-control form-control-lg custom-select @error('status') is-invalid @enderror" required>
                                    <option value="ativo" {{ old('status', $alunoPersonal->status) == 'ativo' ? 'selected' : '' }}>
                                        ✅ Ativo
                                    </option>
                                    <option value="inativo" {{ old('status', $alunoPersonal->status) == 'inativo' ? 'selected' : '' }}>
                                        ❌ Inativo
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Dia de Vencimento -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom" for="dia_vencimento">
                                    <i class="fas fa-calendar-day text-warning mr-2"></i>Dia de Vencimento <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light border-right-0">
                                            <i class="fas fa-calendar text-muted"></i>
                                        </span>
                                    </div>
                                    <select name="dia_vencimento" id="dia_vencimento" 
                                            class="form-control border-left-0 custom-select @error('dia_vencimento') is-invalid @enderror" required>
                                        @for($i = 1; $i <= 28; $i++)
                                            <option value="{{ $i }}" {{ old('dia_vencimento', $alunoPersonal->dia_vencimento) == $i ? 'selected' : '' }}>
                                                Dia {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                @error('dia_vencimento')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom" for="valor_mensalidade">
                                    Valor da Mensalidade
                                </label>
                                <div class="input-group input-group-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light border-right-0">R$</span>
                                    </div>
                                    <input type="number" step="0.01" name="valor_mensalidade" id="valor_mensalidade" 
                                           class="form-control border-left-0 @error('valor_mensalidade') is-invalid @enderror" 
                                           value="{{ old('valor_mensalidade', $alunoPersonal->valor_mensalidade) }}"
                                           placeholder="0,00">
                                </div>
                                @error('valor_mensalidade')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
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
    .bg-gradient-warning {
        background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
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
        border-color: #ffc107;
        box-shadow: 0 0 0 0.2rem rgba(255,193,7,.15);
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
