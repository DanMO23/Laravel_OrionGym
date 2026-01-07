@extends('layouts.user-layout')



@section('content')
<div class="container-fluid py-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fas fa-user-friends text-primary mr-2"></i>Alunos de Personal
            </h3>
            <p class="text-muted mb-0">Gerencie os alunos vinculados aos Personal Trainers</p>
        </div>
        <a href="{{ route('alunos-personal.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-plus mr-2"></i>Novo Aluno
        </a>
    </div>

    <!-- Card Principal -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <!-- Filtros Modernos -->
            <form action="{{ route('alunos-personal.index') }}" method="GET" class="mb-4">
                <div class="filter-container">
                    <div class="row align-items-end">
                        <div class="col-lg-4 col-md-6 mb-2">
                            <label class="filter-label">Buscar</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" name="search" class="form-control border-left-0" 
                                       placeholder="Nome ou CPF..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-2">
                            <label class="filter-label">Personal Trainer</label>
                            <select name="professor_id" class="form-control custom-select">
                                <option value="">Todos</option>
                                @foreach($professores as $prof)
                                    <option value="{{ $prof->id }}" {{ request('professor_id') == $prof->id ? 'selected' : '' }}>
                                        {{ $prof->nome_completo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-2">
                            <label class="filter-label">Status</label>
                            <select name="status" class="form-control custom-select">
                                <option value="">Todos</option>
                                <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>✅ Ativo</option>
                                <option value="inativo" {{ request('status') == 'inativo' ? 'selected' : '' }}>❌ Inativo</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-6 mb-2">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-filter mr-1"></i> Filtrar
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            @if($alunosPersonal->isEmpty())
                <div class="empty-state text-center py-5">
                    <div class="empty-icon mb-3">
                        <i class="fas fa-user-friends fa-4x text-muted"></i>
                    </div>
                    <h5 class="text-muted">Nenhum aluno cadastrado</h5>
                    <p class="text-muted mb-3">Comece cadastrando um novo aluno de personal</p>
                    <a href="{{ route('alunos-personal.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i>Cadastrar Aluno
                    </a>
                </div>
            @else
                <!-- Grid de Alunos em Cards -->
                <div class="row">
                    @foreach($alunosPersonal as $alunoP)
                        @php
                            $statusClass = '';
                            $borderClass = '';
                            
                            if($alunoP->status_pagamento == 'atrasado') {
                                $borderClass = 'border-danger';
                            } elseif($alunoP->dias_restantes <= 5) {
                                $borderClass = 'border-warning';
                            } else {
                                $borderClass = 'border-success';
                            }
                        @endphp
                        
                        <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                            <div class="aluno-card {{ $borderClass }}">
                                <div class="aluno-card-header">
                                    <div class="aluno-avatar-sm">
                                        @if($alunoP->foto)
                                            <img src="{{ asset('storage/' . $alunoP->foto) }}" alt="{{ $alunoP->nome_completo }}">
                                        @else
                                            <div class="avatar-placeholder">
                                                {{ strtoupper(substr($alunoP->nome_completo, 0, 2)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="aluno-header-info">
                                        <h6 class="aluno-name">{{ $alunoP->nome_completo }}</h6>
                                    </div>
                                    <span class="status-badge {{ $alunoP->status == 'ativo' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($alunoP->status) }}
                                    </span>
                                </div>
                                
                                <div class="aluno-card-body">
                                    <div class="info-row">
                                        <i class="fas fa-dumbbell text-warning"></i>
                                        <span>{{ $alunoP->professor->nome_completo }}</span>
                                    </div>
                                    
                                    <div class="payment-info mt-3">
                                        <div class="payment-item">
                                            <span class="payment-label">Vencimento</span>
                                            <span class="payment-value">Dia {{ $alunoP->dia_vencimento }}</span>
                                        </div>
                                        <div class="payment-item">
                                            <span class="payment-label">Dias</span>
                                            <span class="payment-value {{ $alunoP->dias_restantes > 5 ? 'text-success' : ($alunoP->dias_restantes > 0 ? 'text-warning' : 'text-danger') }}">
                                                {{ $alunoP->dias_restantes }}
                                            </span>
                                        </div>
                                        <div class="payment-item">
                                            <span class="payment-label">Valor</span>
                                            <span class="payment-value text-success">R$ {{ number_format($alunoP->valor_mensalidade ?? 0, 2, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="aluno-card-footer">
                                    <a href="{{ route('alunos-personal.show', $alunoP->id) }}" 
                                       class="btn btn-outline-primary btn-sm" title="Ver Detalhes">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('alunos-personal.edit', $alunoP->id) }}" 
                                       class="btn btn-outline-warning btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('alunos-personal.destroy', $alunoP->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                onclick="return confirm('Deseja remover este aluno?')" title="Remover">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $alunosPersonal->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .filter-container {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1rem;
    }
    
    .filter-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }
    
    .border-left-0 {
        border-left: 0 !important;
    }
    
    /* Aluno Cards */
    .aluno-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .aluno-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }
    
    .border-success { border-left-color: #28a745 !important; }
    .border-warning { border-left-color: #ffc107 !important; }
    .border-danger { border-left-color: #dc3545 !important; }
    
    .aluno-card-header {
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .aluno-avatar-sm {
        width: 50px;
        height: 50px;
        flex-shrink: 0;
    }
    
    .aluno-avatar-sm img {
        width: 100%;
        height: 100%;
        border-radius: 12px;
        object-fit: cover;
    }
    
    .avatar-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border-radius: 12px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
    }
    
    .aluno-header-info {
        flex: 1;
        min-width: 0;
    }
    
    .aluno-name {
        font-weight: 700;
        color: #344767;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .aluno-cpf {
        font-size: 0.8rem;
        color: #6c757d;
    }
    
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        color: #fff;
        text-transform: uppercase;
    }
    
    .aluno-card-body {
        padding: 1.25rem;
    }
    
    .info-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f8f9fa;
    }
    
    .info-row:last-of-type {
        border-bottom: none;
    }
    
    .info-row i {
        width: 20px;
        text-align: center;
    }
    
    .info-row span {
        color: #495057;
        font-size: 0.9rem;
    }
    
    .payment-info {
        display: flex;
        justify-content: space-between;
        background: #f8f9fa;
        border-radius: 10px;
        padding: 0.75rem;
    }
    
    .payment-item {
        text-align: center;
    }
    
    .payment-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        color: #6c757d;
        display: block;
    }
    
    .payment-value {
        font-weight: 700;
        font-size: 0.9rem;
        color: #344767;
    }
    
    .aluno-card-footer {
        padding: 1rem 1.25rem;
        background: #f8f9fa;
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }
    
    /* Empty State */
    .empty-state {
        opacity: 0.7;
    }
    
    .empty-icon {
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    .card {
        border-radius: 15px;
    }
</style>
@endsection
