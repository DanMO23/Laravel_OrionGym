@extends('layouts.user-layout')


@section('content')
<div class="container-fluid py-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <!-- Cabeçalho do Painel -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h3 class="font-weight-bold text-dark mb-1">
                        <i class="fas fa-chart-line text-primary mr-2"></i>Painel de Pagamentos
                    </h3>
                    <p class="text-muted mb-0">Controle financeiro dos alunos de Personal Trainer</p>
                </div>
                <div class="text-right">
                    <span class="badge badge-light px-3 py-2">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards de Estatísticas Modernos -->
    <div class="row mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
            <div class="stats-card stats-card-primary">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-info">
                        <span class="stats-label">Total de Alunos</span>
                        <h3 class="stats-value">{{ $totalAlunos }}</h3>
                    </div>
                </div>
                <div class="stats-footer">
                    <i class="fas fa-user-friends mr-1"></i> Alunos ativos
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
            <div class="stats-card stats-card-success">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <div class="stats-info">
                        <span class="stats-label">Pagos Este Mês</span>
                        <h3 class="stats-value">{{ $pagosEsseMes }}</h3>
                    </div>
                </div>
                <div class="stats-footer">
                    <i class="fas fa-percentage mr-1"></i> 
                    {{ $totalAlunos > 0 ? number_format(($pagosEsseMes / $totalAlunos) * 100, 0) : 0 }}% do total
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
            <div class="stats-card stats-card-warning">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stats-info">
                        <span class="stats-label">Pendentes</span>
                        <h3 class="stats-value">{{ $pendentes ?? 0 }}</h3>
                    </div>
                </div>
                <div class="stats-footer">
                    <i class="fas fa-hourglass-half mr-1"></i> Aguardando pagamento
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
            <div class="stats-card stats-card-danger">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stats-info">
                        <span class="stats-label">Atrasados</span>
                        <h3 class="stats-value">{{ $atrasados }}</h3>
                    </div>
                </div>
                <div class="stats-footer">
                    <i class="fas fa-bell mr-1"></i> Necessitam atenção
                </div>
            </div>
        </div>
    </div>

    <!-- Card de Receita Total -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="revenue-card">
                <div class="revenue-card-body">
                    <div class="revenue-info">
                        <div class="revenue-icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="revenue-text">
                            <span class="revenue-label">Total Recebido Este Mês</span>
                            <h2 class="revenue-value">R$ {{ number_format($totalRecebido, 2, ',', '.') }}</h2>
                        </div>
                    </div>
                    <div class="revenue-chart">
                        <div class="progress-ring">
                            <span class="progress-percentage">{{ $totalAlunos > 0 ? number_format(($pagosEsseMes / $totalAlunos) * 100, 0) : 0 }}%</span>
                            <span class="progress-label">recebido</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de Alunos -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0 font-weight-bold text-dark">
                    <i class="fas fa-list-alt text-primary mr-2"></i>Lista de Alunos
                </h5>
                <span class="badge badge-primary px-3 py-2">{{ $alunos->total() }} registros</span>
            </div>
        </div>

        <div class="card-body pt-0">
            <!-- Filtros Modernos -->
            <form action="{{ route('alunos-personal.painel-pagamentos') }}" method="GET" class="mb-4">
                <div class="filter-container">
                    <div class="row align-items-end">
                        <div class="col-lg-3 col-md-6 mb-2">
                            <label class="filter-label">Personal Trainer</label>
                            <select name="professor_id" class="form-control form-control-sm custom-select">
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
                            <select name="status_pagamento" class="form-control form-control-sm custom-select">
                                <option value="">Todos</option>
                                <option value="pago" {{ request('status_pagamento') == 'pago' ? 'selected' : '' }}>✓ Pago</option>
                                <option value="pendente" {{ request('status_pagamento') == 'pendente' ? 'selected' : '' }}>⏳ Pendente</option>
                                <option value="atrasado" {{ request('status_pagamento') == 'atrasado' ? 'selected' : '' }}>⚠️ Atrasado</option>
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-2">
                            <label class="filter-label">Mês</label>
                            <select name="mes" class="form-control form-control-sm custom-select">
                                <option value="">Todos os Meses</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('mes') == $i ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-2">
                            <button type="submit" class="btn btn-primary btn-sm btn-block">
                                <i class="fas fa-filter mr-1"></i> Filtrar
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Lista de Alunos em Cards -->
            @if($alunos->isEmpty())
                <div class="empty-state text-center py-5">
                    <div class="empty-icon mb-3">
                        <i class="fas fa-inbox fa-4x text-muted"></i>
                    </div>
                    <h5 class="text-muted">Nenhum registro encontrado</h5>
                    <p class="text-muted mb-0">Tente ajustar os filtros de busca</p>
                </div>
            @else
                <div class="alunos-list">
                    @foreach($alunos as $aluno)
                        @php
                            $statusClass = '';
                            $statusIcon = '';
                            $statusText = '';
                            $cardBorder = '';
                            
                            switch($aluno->status_pagamento) {
                                case 'pago':
                                    $statusClass = 'status-success';
                                    $statusIcon = 'fa-check-circle';
                                    $statusText = 'Pago';
                                    $cardBorder = 'border-left-success';
                                    break;
                                case 'pendente':
                                    $statusClass = 'status-warning';
                                    $statusIcon = 'fa-clock';
                                    $statusText = 'Pendente';
                                    $cardBorder = 'border-left-warning';
                                    break;
                                case 'atrasado':
                                    $statusClass = 'status-danger';
                                    $statusIcon = 'fa-exclamation-circle';
                                    $statusText = 'Atrasado';
                                    $cardBorder = 'border-left-danger';
                                    break;
                            }

                            // Calcular dias restantes/atrasados
                            $hoje = \Carbon\Carbon::now()->startOfDay();
                            $vencimento = $aluno->proximo_vencimento->startOfDay();
                            $diasDiff = $hoje->diffInDays($vencimento, false);
                        @endphp
                        
                        <div class="aluno-card {{ $cardBorder }}">
                            <div class="aluno-card-body">
                                <div class="aluno-info">
                                    <div class="aluno-avatar">
                                        @if($aluno->foto)
                                            <img src="{{ asset('storage/' . $aluno->foto) }}" alt="{{ $aluno->nome_completo }}">
                                        @else
                                            <div class="avatar-placeholder">
                                                {{ strtoupper(substr($aluno->nome_completo, 0, 2)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="aluno-details">
                                        <h6 class="aluno-name">{{ $aluno->nome_completo }}</h6>
                                        <div class="aluno-meta">
                                            <span class="meta-item">
                                                <i class="fas fa-id-card text-muted"></i>
                                                {{ $aluno->cpf ?: 'CPF não informado' }}
                                            </span>
                                            <span class="meta-item">
                                                <i class="fas fa-dumbbell text-primary"></i>
                                                {{ $aluno->professor->nome_completo }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="aluno-payment-info">
                                    <div class="payment-detail">
                                        <span class="payment-label">Vencimento</span>
                                        <span class="payment-value">
                                            <i class="fas fa-calendar-day mr-1"></i>
                                            Dia {{ $aluno->dia_vencimento }}
                                        </span>
                                    </div>
                                    <div class="payment-detail">
                                        <span class="payment-label">Próximo</span>
                                        <span class="payment-value">
                                            {{ $aluno->proximo_vencimento->format('d/m/Y') }}
                                        </span>
                                    </div>
                                    <div class="payment-detail">
                                        <span class="payment-label">Dias</span>
                                        <span class="payment-value {{ $diasDiff < 0 ? 'text-danger' : ($diasDiff <= 5 ? 'text-warning' : 'text-success') }}">
                                            @if($diasDiff < 0)
                                                <i class="fas fa-arrow-down"></i> {{ abs($diasDiff) }} dias atrás
                                            @elseif($diasDiff == 0)
                                                <i class="fas fa-exclamation-circle"></i> Hoje!
                                            @else
                                                <i class="fas fa-arrow-up"></i> {{ $diasDiff }} dias
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="aluno-valor">
                                    <span class="valor-label">Mensalidade</span>
                                    <span class="valor-amount">R$ {{ number_format($aluno->valor_mensalidade ?? 0, 2, ',', '.') }}</span>
                                </div>

                                <div class="aluno-status">
                                    <span class="status-badge {{ $statusClass }}">
                                        <i class="fas {{ $statusIcon }} mr-1"></i>
                                        {{ $statusText }}
                                    </span>
                                    @if($aluno->ultimo_pagamento)
                                        <small class="text-muted d-block mt-1">
                                            Último: {{ $aluno->ultimo_pagamento->format('d/m/Y') }}
                                        </small>
                                    @endif
                                </div>

                                <div class="aluno-actions">
                                    @if($aluno->status_pagamento != 'pago')
                                        <form action="{{ route('alunos-personal.registrar-pagamento', $aluno->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm btn-action" title="Registrar Pagamento">
                                                <i class="fas fa-check"></i>
                                                <span>Pagar</span>
                                            </button>
                                        </form>
                                    @else
                                        <span class="paid-badge">
                                            <i class="fas fa-check-circle"></i>
                                        </span>
                                    @endif
                                    <a href="{{ route('alunos-personal.show', $aluno->id) }}" class="btn btn-outline-primary btn-sm btn-action" title="Ver Detalhes">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $alunos->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Stats Cards */
    .stats-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }
    
    .stats-card-body {
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .stats-card-primary .stats-icon { background: rgba(0,123,255,0.15); color: #007bff; }
    .stats-card-success .stats-icon { background: rgba(40,167,69,0.15); color: #28a745; }
    .stats-card-warning .stats-icon { background: rgba(255,193,7,0.15); color: #e6a300; }
    .stats-card-danger .stats-icon { background: rgba(220,53,69,0.15); color: #dc3545; }
    
    .stats-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        font-weight: 600;
    }
    
    .stats-value {
        font-size: 2rem;
        font-weight: 700;
        color: #344767;
        margin: 0;
    }
    
    .stats-footer {
        background: #f8f9fa;
        padding: 0.75rem 1.5rem;
        font-size: 0.8rem;
        color: #6c757d;
    }
    
    /* Revenue Card */
    .revenue-card {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border-radius: 15px;
        color: #fff;
        box-shadow: 0 10px 40px rgba(0,123,255,0.3);
    }
    
    .revenue-card-body {
        padding: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .revenue-info {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    
    .revenue-icon {
        width: 80px;
        height: 80px;
        background: rgba(255,255,255,0.2);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }
    
    .revenue-label {
        font-size: 0.9rem;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .revenue-value {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0.5rem 0 0;
    }
    
    .progress-ring {
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        width: 100px;
        height: 100px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    
    .progress-percentage {
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    .progress-label {
        font-size: 0.75rem;
        opacity: 0.8;
    }
    
    /* Filter Container */
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
    
    /* Aluno Cards */
    .alunos-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .aluno-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
    }
    
    .aluno-card:hover {
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .border-left-success { border-left-color: #28a745; }
    .border-left-warning { border-left-color: #ffc107; }
    .border-left-danger { border-left-color: #dc3545; }
    
    .aluno-card-body {
        padding: 1.25rem;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .aluno-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex: 1;
        min-width: 250px;
    }
    
    .aluno-avatar {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
    }
    
    .aluno-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .avatar-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
    }
    
    .aluno-name {
        font-weight: 600;
        color: #344767;
        margin: 0 0 0.25rem;
    }
    
    .aluno-meta {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .meta-item {
        font-size: 0.8rem;
        color: #6c757d;
    }
    
    .meta-item i {
        margin-right: 0.25rem;
    }
    
    .aluno-payment-info {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    
    .payment-detail {
        text-align: center;
    }
    
    .payment-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        color: #6c757d;
        display: block;
    }
    
    .payment-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: #344767;
    }
    
    .aluno-valor {
        text-align: center;
        min-width: 100px;
    }
    
    .valor-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        color: #6c757d;
        display: block;
    }
    
    .valor-amount {
        font-size: 1.1rem;
        font-weight: 700;
        color: #28a745;
    }
    
    .aluno-status {
        text-align: center;
        min-width: 100px;
    }
    
    .status-badge {
        padding: 0.4rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
    }
    
    .status-success { background: #d4edda; color: #155724; }
    .status-warning { background: #fff3cd; color: #856404; }
    .status-danger { background: #f8d7da; color: #721c24; }
    
    .aluno-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    
    .btn-action {
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .paid-badge {
        width: 36px;
        height: 36px;
        background: #d4edda;
        color: #28a745;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
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
    
    /* Responsive */
    @media (max-width: 991px) {
        .aluno-card-body {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .aluno-payment-info {
            width: 100%;
            justify-content: space-between;
        }
        
        .aluno-actions {
            width: 100%;
            justify-content: flex-end;
        }
        
        .revenue-card-body {
            flex-direction: column;
            text-align: center;
        }
        
        .revenue-info {
            flex-direction: column;
        }
    }
</style>
@endsection
