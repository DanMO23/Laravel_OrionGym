@extends('layouts.user-layout')

@section('header-user', 'Funcionários')

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
                <i class="fas fa-user-tie text-info mr-2"></i>Funcionários
            </h3>
            <p class="text-muted mb-0">Gerencie os funcionários da academia</p>
        </div>
        <a href="{{ route('funcionarios.create') }}" class="btn btn-info btn-lg shadow-sm">
            <i class="fas fa-plus mr-2"></i>Novo Funcionário
        </a>
    </div>

    <!-- Card Principal -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            @if($funcionarios->isEmpty())
                <div class="empty-state text-center py-5">
                    <div class="empty-icon mb-3">
                        <i class="fas fa-user-tie fa-4x text-muted"></i>
                    </div>
                    <h5 class="text-muted">Nenhum funcionário cadastrado</h5>
                    <p class="text-muted mb-3">Comece cadastrando um novo funcionário</p>
                    <a href="{{ route('funcionarios.create') }}" class="btn btn-info">
                        <i class="fas fa-plus mr-2"></i>Cadastrar Funcionário
                    </a>
                </div>
            @else
                <!-- Grid de Funcionários em Cards -->
                <div class="row">
                    @foreach($funcionarios as $funcionario)
                        <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                            <div class="funcionario-card">
                                <div class="funcionario-card-header">
                                    <div class="funcionario-avatar">
                                        @if($funcionario->foto)
                                            <img src="{{ asset('uploads/' . $funcionario->foto) }}" alt="{{ $funcionario->nome_completo }}">
                                        @else
                                            <div class="avatar-placeholder">
                                                {{ strtoupper(substr($funcionario->nome_completo, 0, 2)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="funcionario-header-info">
                                        <h6 class="funcionario-name">{{ $funcionario->nome_completo }}</h6>
                                        <span class="funcionario-cargo">{{ $funcionario->cargo }}</span>
                                    </div>
                                </div>
                                
                                <div class="funcionario-card-body">
                                    <div class="info-row">
                                        <i class="fas fa-envelope text-info"></i>
                                        <span>{{ $funcionario->email }}</span>
                                    </div>
                                    <div class="info-row">
                                        <i class="fas fa-phone text-success"></i>
                                        <span>{{ $funcionario->telefone }}</span>
                                    </div>
                                </div>
                                
                                <div class="funcionario-card-footer">
                                    <a href="{{ route('funcionarios.show', $funcionario->id) }}" class="btn btn-sm btn-outline-info" title="Detalhes">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('funcionarios.edit', $funcionario->id) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('funcionarios.destroy', $funcionario->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este funcionário?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .funcionario-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }
    
    .funcionario-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }
    
    .funcionario-card-header {
        display: flex;
        align-items: center;
        padding: 1.25rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #e9ecef;
    }
    
    .funcionario-avatar {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 1rem;
        flex-shrink: 0;
        border: 3px solid #17a2b8;
    }
    
    .funcionario-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .avatar-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
    }
    
    .funcionario-header-info {
        flex: 1;
        min-width: 0;
    }
    
    .funcionario-name {
        font-weight: 700;
        color: #344767;
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .funcionario-cargo {
        font-size: 0.8rem;
        color: #17a2b8;
        font-weight: 600;
        background: rgba(23,162,184,0.1);
        padding: 2px 10px;
        border-radius: 20px;
    }
    
    .funcionario-card-body {
        padding: 1rem 1.25rem;
    }
    
    .info-row {
        display: flex;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-row i {
        width: 24px;
        margin-right: 0.75rem;
        font-size: 0.9rem;
    }
    
    .info-row span {
        color: #495057;
        font-size: 0.9rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .funcionario-card-footer {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        padding: 1rem;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
    }
    
    .funcionario-card-footer .btn {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }
    
    .empty-state {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        margin: 1rem;
    }
    
    .empty-icon {
        opacity: 0.5;
    }
    
    .card {
        border-radius: 15px;
        overflow: hidden;
    }
</style>
@endsection
