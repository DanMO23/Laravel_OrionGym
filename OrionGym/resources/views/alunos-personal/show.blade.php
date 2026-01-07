@extends('layouts.user-layout')

@section('header-user', 'Detalhes do Aluno de Personal')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Card Principal com Foto e Dados -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 profile-card">
                <div class="card-body text-center p-4">
                    <div class="profile-avatar mb-3">
                        @if($alunoPersonal->foto)
                            <img src="{{ asset('storage/' . $alunoPersonal->foto) }}" alt="{{ $alunoPersonal->nome_completo }}">
                        @else
                            <div class="avatar-placeholder-lg">
                                {{ strtoupper(substr($alunoPersonal->nome_completo, 0, 2)) }}
                            </div>
                        @endif
                        <span class="status-indicator {{ $alunoPersonal->status == 'ativo' ? 'bg-success' : 'bg-secondary' }}"></span>
                    </div>
                    
                    <h4 class="profile-name">{{ $alunoPersonal->nome_completo }}</h4>
                    
                    <div class="profile-badges mb-3">
                        <span class="badge badge-pill badge-{{ $alunoPersonal->status == 'ativo' ? 'success' : 'secondary' }}">
                            {{ ucfirst($alunoPersonal->status) }}
                        </span>
                    </div>

                    <div class="profile-info">
                        <div class="info-item">
                            <i class="fas fa-dumbbell text-warning"></i>
                            <span>{{ $alunoPersonal->professor->nome_completo ?? 'Sem Personal' }}</span>
                        </div>
                    </div>

                    <div class="profile-actions mt-4">
                        <a href="{{ route('alunos-personal.edit', $alunoPersonal->id) }}" class="btn btn-warning btn-block">
                            <i class="fas fa-edit mr-2"></i>Editar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cards de Informações -->
        <div class="col-lg-8">
            <!-- Status de Pagamento Destaque -->
            @php
                $statusClass = '';
                $statusIcon = '';
                $statusText = '';
                $statusBg = '';
                
                switch($alunoPersonal->status_pagamento) {
                    case 'pago':
                        $statusClass = 'success';
                        $statusIcon = 'fa-check-circle';
                        $statusText = 'Pagamento em dia';
                        $statusBg = 'linear-gradient(135deg, #28a745 0%, #218838 100%)';
                        break;
                    case 'pendente':
                        $statusClass = 'warning';
                        $statusIcon = 'fa-clock';
                        $statusText = 'Pagamento Pendente';
                        $statusBg = 'linear-gradient(135deg, #ffc107 0%, #e0a800 100%)';
                        break;
                    case 'atrasado':
                        $statusClass = 'danger';
                        $statusIcon = 'fa-exclamation-circle';
                        $statusText = 'Pagamento Atrasado';
                        $statusBg = 'linear-gradient(135deg, #dc3545 0%, #c82333 100%)';
                        break;
                }
                
                $hoje = \Carbon\Carbon::now()->startOfDay();
                $vencimento = $alunoPersonal->proximo_vencimento->startOfDay();
                $diasDiff = $hoje->diffInDays($vencimento, false);
            @endphp
            
            <div class="payment-status-card mb-4" style="background: {{ $statusBg }};">
                <div class="payment-status-body">
                    <div class="payment-status-icon">
                        <i class="fas {{ $statusIcon }}"></i>
                    </div>
                    <div class="payment-status-info">
                        <h5 class="mb-1">{{ $statusText }}</h5>
                        <p class="mb-0">
                            @if($diasDiff < 0)
                                Vencido há {{ abs($diasDiff) }} dias
                            @elseif($diasDiff == 0)
                                Vence hoje!
                            @else
                                Vence em {{ $diasDiff }} dias
                            @endif
                        </p>
                    </div>
                    <div class="payment-status-action">
                        @if($alunoPersonal->status_pagamento != 'pago')
                            <form action="{{ route('alunos-personal.registrar-pagamento', $alunoPersonal->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-light btn-lg">
                                    <i class="fas fa-check mr-2"></i>Registrar Pagamento
                                </button>
                            </form>
                        @else
                            <span class="payment-ok">
                                <i class="fas fa-check-double fa-2x"></i>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Cards de Informações Financeiras -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="info-card">
                        <div class="info-card-icon bg-info">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="info-card-content">
                            <span class="info-card-label">Dia de Vencimento</span>
                            <h4 class="info-card-value">Dia {{ $alunoPersonal->dia_vencimento }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="info-card">
                        <div class="info-card-icon bg-primary">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="info-card-content">
                            <span class="info-card-label">Próximo Vencimento</span>
                            <h4 class="info-card-value">{{ $alunoPersonal->proximo_vencimento->format('d/m/Y') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="info-card">
                        <div class="info-card-icon bg-success">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="info-card-content">
                            <span class="info-card-label">Mensalidade</span>
                            <h4 class="info-card-value">R$ {{ number_format($alunoPersonal->valor_mensalidade ?? 0, 2, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal Trainer Info -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-dumbbell text-warning mr-2"></i>Personal Trainer
                    </h5>
                </div>
                <div class="card-body">
                    @if($alunoPersonal->professor)
                        <div class="d-flex align-items-center">
                            <div class="personal-avatar mr-3">
                                @if($alunoPersonal->professor->foto)
                                    <img src="{{ asset('storage/' . $alunoPersonal->professor->foto) }}" alt="{{ $alunoPersonal->professor->nome_completo }}">
                                @else
                                    <div class="avatar-placeholder-sm">
                                        {{ strtoupper(substr($alunoPersonal->professor->nome_completo, 0, 2)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="personal-info">
                                <h6 class="mb-1 font-weight-bold">{{ $alunoPersonal->professor->nome_completo }}</h6>
                                <p class="mb-0 text-muted">
                                    <i class="fas fa-phone mr-1"></i> {{ $alunoPersonal->professor->telefone }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="fas fa-exclamation-triangle mr-2"></i>Personal trainer não encontrado ou foi removido.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Último Pagamento e Histórico -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-history text-primary mr-2"></i>Histórico
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase">Último Pagamento</label>
                            <p class="font-weight-bold">
                                @if($alunoPersonal->ultimo_pagamento)
                                    <i class="fas fa-calendar-check text-success mr-2"></i>
                                    {{ $alunoPersonal->ultimo_pagamento->format('d/m/Y') }}
                                @else
                                    <span class="text-muted">Nenhum pagamento registrado</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase">Cadastrado em</label>
                            <p class="font-weight-bold">
                                <i class="fas fa-calendar-plus text-primary mr-2"></i>
                                {{ $alunoPersonal->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('alunos-personal.index') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <div>
                    <a href="{{ route('alunos-personal.edit', $alunoPersonal->id) }}" class="btn btn-warning btn-lg">
                        <i class="fas fa-edit mr-2"></i>Editar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Profile Card */
    .profile-card {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .profile-avatar {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto;
    }
    
    .profile-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .avatar-placeholder-lg {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border-radius: 50%;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 700;
        border: 4px solid #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .status-indicator {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 3px solid #fff;
    }
    
    .profile-name {
        color: #344767;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .profile-info {
        text-align: left;
        margin-top: 1.5rem;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-item i {
        width: 30px;
        font-size: 1rem;
    }
    
    .info-item span {
        color: #495057;
    }
    
    /* Payment Status Card */
    .payment-status-card {
        border-radius: 15px;
        color: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    
    .payment-status-body {
        padding: 1.5rem 2rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    
    .payment-status-icon {
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .payment-status-info {
        flex: 1;
    }
    
    .payment-status-info h5 {
        font-weight: 700;
    }
    
    .payment-ok {
        opacity: 0.8;
    }
    
    /* Info Cards */
    .info-card {
        background: #fff;
        border-radius: 12px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        height: 100%;
    }
    
    .info-card-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    
    .info-card-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        color: #6c757d;
        letter-spacing: 0.5px;
    }
    
    .info-card-value {
        color: #344767;
        font-weight: 700;
        margin: 0;
        font-size: 1.1rem;
    }
    
    /* Personal Avatar */
    .personal-avatar {
        width: 50px;
        height: 50px;
        flex-shrink: 0;
    }
    
    .personal-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 10px;
        object-fit: cover;
    }
    
    .avatar-placeholder-sm {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
        border-radius: 10px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }
    
    .card {
        border-radius: 15px;
    }
    
    @media (max-width: 991px) {
        .payment-status-body {
            flex-direction: column;
            text-align: center;
        }
        
        .payment-status-info {
            width: 100%;
        }
    }
</style>
@endsection
