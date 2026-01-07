@extends('layouts.user-layout')

@section('header-user', 'Detalhes do Funcionário')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Card Principal com Foto e Dados -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 profile-card">
                <div class="card-body text-center p-4">
                    <div class="profile-avatar mb-3">
                        @if($funcionario->foto)
                            <img src="{{ asset('uploads/' . $funcionario->foto) }}" alt="{{ $funcionario->nome_completo }}">
                        @else
                            <div class="avatar-placeholder-lg">
                                {{ strtoupper(substr($funcionario->nome_completo, 0, 2)) }}
                            </div>
                        @endif
                    </div>
                    
                    <h4 class="profile-name">{{ $funcionario->nome_completo }}</h4>
                    
                    <div class="profile-badges mb-3">
                        <span class="badge badge-pill badge-info">
                            <i class="fas fa-briefcase mr-1"></i>{{ $funcionario->cargo }}
                        </span>
                    </div>

                    <div class="profile-actions mt-4">
                        <a href="{{ route('funcionarios.edit', $funcionario->id) }}" class="btn btn-warning btn-block mb-2">
                            <i class="fas fa-edit mr-2"></i>Editar
                        </a>
                        <a href="{{ route('funcionarios.index') }}" class="btn btn-outline-secondary btn-block">
                            <i class="fas fa-arrow-left mr-2"></i>Voltar
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Card de Ações Perigosas -->
            <div class="card shadow-sm border-0 mt-3">
                <div class="card-body p-3">
                    <h6 class="text-danger mb-3"><i class="fas fa-exclamation-triangle mr-2"></i>Zona de Perigo</h6>
                    <form action="{{ route('funcionarios.destroy', $funcionario->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este funcionário? Esta ação não pode ser desfeita.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-block">
                            <i class="fas fa-trash mr-2"></i>Excluir Funcionário
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Cards de Informações -->
        <div class="col-lg-8">
            <!-- Informações de Contato -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-address-card text-info mr-2"></i>Informações de Contato
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-box-icon bg-info-light">
                                    <i class="fas fa-envelope text-info"></i>
                                </div>
                                <div class="info-box-content">
                                    <span class="info-label">E-mail</span>
                                    <span class="info-value">{{ $funcionario->email }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-box-icon bg-success-light">
                                    <i class="fas fa-phone text-success"></i>
                                </div>
                                <div class="info-box-content">
                                    <span class="info-label">Telefone</span>
                                    <span class="info-value">{{ $funcionario->telefone }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="info-box">
                                <div class="info-box-icon bg-warning-light">
                                    <i class="fas fa-map-marker-alt text-warning"></i>
                                </div>
                                <div class="info-box-content">
                                    <span class="info-label">Endereço</span>
                                    <span class="info-value">{{ $funcionario->endereco ?: 'Não informado' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informações Profissionais -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-briefcase text-info mr-2"></i>Informações Profissionais
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-box-icon bg-info-light">
                                    <i class="fas fa-user-tag text-info"></i>
                                </div>
                                <div class="info-box-content">
                                    <span class="info-label">Cargo</span>
                                    <span class="info-value">{{ $funcionario->cargo }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="info-box-icon bg-secondary-light">
                                    <i class="fas fa-venus-mars text-secondary"></i>
                                </div>
                                <div class="info-box-content">
                                    <span class="info-label">Sexo</span>
                                    <span class="info-value">{{ $funcionario->sexo == 'M' ? 'Masculino' : 'Feminino' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informações do Sistema -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-history text-info mr-2"></i>Histórico
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <span class="info-label d-block mb-1">Cadastrado em</span>
                            <span class="info-value">
                                <i class="fas fa-calendar-plus text-info mr-2"></i>
                                {{ $funcionario->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <span class="info-label d-block mb-1">Última atualização</span>
                            <span class="info-value">
                                <i class="fas fa-calendar-check text-success mr-2"></i>
                                {{ $funcionario->updated_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-card {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .profile-avatar {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid #17a2b8;
        box-shadow: 0 5px 20px rgba(23,162,184,0.3);
    }
    
    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .avatar-placeholder-lg {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 700;
    }
    
    .profile-name {
        font-weight: 700;
        color: #344767;
        margin-bottom: 0.5rem;
    }
    
    .info-box {
        display: flex;
        align-items: center;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .info-box:hover {
        background: #e9ecef;
    }
    
    .info-box-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.1rem;
    }
    
    .bg-info-light {
        background: rgba(23,162,184,0.15);
    }
    
    .bg-success-light {
        background: rgba(40,167,69,0.15);
    }
    
    .bg-warning-light {
        background: rgba(255,193,7,0.15);
    }
    
    .bg-secondary-light {
        background: rgba(108,117,125,0.15);
    }
    
    .info-box-content {
        flex: 1;
    }
    
    .info-label {
        display: block;
        font-size: 0.75rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }
    
    .info-value {
        font-size: 1rem;
        color: #344767;
        font-weight: 500;
    }
    
    .card {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .card-header {
        border-bottom: 1px solid #e9ecef;
    }
</style>
@endsection
