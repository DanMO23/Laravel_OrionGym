@extends('layouts.user-layout')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">
    <!-- Cards de Estatísticas Principais -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card bg-gradient-info text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Total de Membros</h6>
                            <h2 class="mb-0 font-weight-bold">{{ $totalMembros }}</h2>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-users fa-3x opacity-50"></i>
                        </div>
                    </div>
                    <a href="{{ route('alunos.index') }}" class="text-white stretched-link">
                        <small>Ver detalhes <i class="fas fa-arrow-right"></i></small>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card bg-gradient-success text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Membros Ativos</h6>
                            <h2 class="mb-0 font-weight-bold">{{ $membrosAtivos }}</h2>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-user-check fa-3x opacity-50"></i>
                        </div>
                    </div>
                    <a href="{{ route('alunos.index') }}" class="text-white stretched-link">
                        <small>Ver detalhes <i class="fas fa-arrow-right"></i></small>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card bg-gradient-danger text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Membros Bloqueados</h6>
                            <h2 class="mb-0 font-weight-bold">{{ $membrosBloqueados }}</h2>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-user-lock fa-3x opacity-50"></i>
                        </div>
                    </div>
                    <a href="{{ route('alunos.vencidos') }}" class="text-white stretched-link">
                        <small>Ver detalhes <i class="fas fa-arrow-right"></i></small>
                    </a>
                </div>
            </div>
        </div>

        @if(auth()->user()->hasRole('admin'))
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card bg-gradient-warning text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Faturamento Mensal</h6>
                            <h2 class="mb-0 font-weight-bold">R$ {{ number_format($faturamentoMensal[\Carbon\Carbon::now()->format('F')], 2, ',', '.') }}</h2>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-dollar-sign fa-3x opacity-50"></i>
                        </div>
                    </div>
                    <a href="{{ route('compra.historico') }}" class="text-white stretched-link">
                        <small>Ver detalhes <i class="fas fa-arrow-right"></i></small>
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Sistema de Abas -->
    <div class="card shadow-sm">
        <div class="card-header bg-white border-0">
            <ul class="nav nav-tabs card-header-tabs" id="dashboardTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab">
                        <i class="fas fa-chart-pie"></i> Visão Geral
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="demographics-tab" data-toggle="tab" href="#demographics" role="tab">
                        <i class="fas fa-users"></i> Demografia
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="performance-tab" data-toggle="tab" href="#performance" role="tab">
                        <i class="fas fa-chart-line"></i> Desempenho
                    </a>
                </li>
                @if(auth()->user()->hasRole('admin'))
                <li class="nav-item">
                    <a class="nav-link" id="financial-tab" data-toggle="tab" href="#financial" role="tab">
                        <i class="fas fa-dollar-sign"></i> Financeiro
                    </a>
                </li>
                @endif
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content" id="dashboardTabsContent">
                <!-- ABA: VISÃO GERAL -->
                <div class="tab-pane fade show active" id="overview" role="tabpanel">
                    <div class="row mb-4">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card stats-card-small bg-gradient-purple text-white shadow-sm">
                                <div class="card-body text-center">
                                    <h6 class="text-uppercase mb-2">Taxa de Retenção</h6>
                                    <h2 class="mb-0 font-weight-bold">{{ $taxaRetencao }}%</h2>
                                    <small>Alunos com múltiplas compras</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card stats-card-small bg-gradient-orange text-white shadow-sm">
                                <div class="card-body text-center">
                                    <h6 class="text-uppercase mb-2">Média de Dias</h6>
                                    <h2 class="mb-0 font-weight-bold">{{ $mediaDiasRestantes }}</h2>
                                    <small>Dias restantes por aluno</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card stats-card-small bg-gradient-teal text-white shadow-sm">
                                <div class="card-body text-center">
                                    <h6 class="text-uppercase mb-2">Novos Este Mês</h6>
                                    <h2 class="mb-0 font-weight-bold">{{ end($novosAlunosMes) }}</h2>
                                    <small>Alunos cadastrados</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <h5 class="mb-0"><i class="fas fa-chart-bar text-info"></i> Status das Matrículas</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="statusDetalhadoChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <h5 class="mb-0"><i class="fas fa-chart-pie text-success"></i> Status Resumido</h5>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <div class="flex-grow-1">
                                        <canvas id="membrosChart"></canvas>
                                    </div>
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span><i class="fas fa-circle text-success"></i> Ativos</span>
                                            <strong>{{ $membrosAtivos }} ({{ $totalMembros > 0 ? round(($membrosAtivos / $totalMembros) * 100, 1) : 0 }}%)</strong>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span><i class="fas fa-circle text-danger"></i> Bloqueados</span>
                                            <strong>{{ $membrosBloqueados }} ({{ $totalMembros > 0 ? round(($membrosBloqueados / $totalMembros) * 100, 1) : 0 }}%)</strong>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span><i class="fas fa-circle text-secondary"></i> Inativos</span>
                                            <strong>{{ $totalMembros - $membrosAtivos - $membrosBloqueados }} ({{ $totalMembros > 0 ? round((($totalMembros - $membrosAtivos - $membrosBloqueados) / $totalMembros) * 100, 1) : 0 }}%)</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ABA: DEMOGRAFIA -->
                <div class="tab-pane fade" id="demographics" role="tabpanel">
                    <div class="row mb-4">
                        <div class="col-lg-4 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <h5 class="mb-0"><i class="fas fa-venus-mars text-info"></i> Distribuição por Gênero</h5>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <div class="flex-grow-1">
                                        <canvas id="generoChart"></canvas>
                                    </div>
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span><i class="fas fa-circle text-primary"></i> Masculino</span>
                                            <strong>{{ $distribuicaoGenero['masculino'] }}</strong>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span><i class="fas fa-circle" style="color: #e83e8c;"></i> Feminino</span>
                                            <strong>{{ $distribuicaoGenero['feminino'] }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <h5 class="mb-0"><i class="fas fa-birthday-cake text-warning"></i> Distribuição por Faixa Etária</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="idadeChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <h5 class="mb-0"><i class="fas fa-hourglass-half text-danger"></i> Distribuição de Dias Restantes</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="diasRestantesChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <h5 class="mb-0"><i class="fas fa-box text-primary"></i> Top 5 Pacotes Mais Vendidos</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="pacotesChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ABA: DESEMPENHO -->
                <div class="tab-pane fade" id="performance" role="tabpanel">
                    <!-- Cards de Métricas de Desempenho -->
                    <div class="row mb-4">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card stats-card-small bg-gradient-success text-white shadow-sm">
                                <div class="card-body text-center">
                                    <h6 class="text-uppercase mb-2">Ticket Médio</h6>
                                    <h2 class="mb-0 font-weight-bold">R$ {{ number_format($ticketMedio, 2, ',', '.') }}</h2>
                                    <small>Valor médio por compra</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card stats-card-small bg-gradient-info text-white shadow-sm">
                                <div class="card-body text-center">
                                    <h6 class="text-uppercase mb-2">Média de Compras</h6>
                                    <h2 class="mb-0 font-weight-bold">{{ $mediaComprasPorAluno }}</h2>
                                    <small>Compras por aluno</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card stats-card-small bg-gradient-danger text-white shadow-sm">
                                <div class="card-body text-center">
                                    <h6 class="text-uppercase mb-2">Churn Rate</h6>
                                    <h2 class="mb-0 font-weight-bold">{{ $churnRate }}%</h2>
                                    <small>Evasão últimos 3 meses</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gráficos de Desempenho -->
                    <div class="row mb-4">
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <h5 class="mb-0"><i class="fas fa-chart-line text-success"></i> Novos Alunos (Últimos 12 Meses)</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="novosAlunosChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <h5 class="mb-0"><i class="fas fa-chart-area text-primary"></i> Crescimento Total (Últimos 6 Meses)</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="crescimentoChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <h5 class="mb-0"><i class="fas fa-chart-bar text-info"></i> Novos vs Renovações (Últimos 6 Meses)</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="renovacoesChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <h5 class="mb-0"><i class="fas fa-chart-line text-warning"></i> Evolução de Status (Últimos 6 Meses)</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="statusTemporalChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ABA: FINANCEIRO (APENAS ADMIN) -->
                @if(auth()->user()->hasRole('admin'))
                <div class="tab-pane fade" id="financial" role="tabpanel">
                    <!-- Filtros de Período -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <h5 class="mb-0"><i class="fas fa-filter"></i> Filtros de Período</h5>
                                        <div class="btn-group btn-group-sm period-filter" role="group">
                                            <button type="button" class="btn btn-outline-primary active" onclick="changePeriod('year')">
                                                Anual
                                            </button>
                                            <button type="button" class="btn btn-outline-primary" onclick="changePeriod('semester')">
                                                Semestral
                                            </button>
                                            <button type="button" class="btn btn-outline-primary" onclick="changePeriod('quarter')">
                                                Trimestral
                                            </button>
                                            <button type="button" class="btn btn-outline-primary" onclick="changePeriod('month')">
                                                Mensal
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-lg-12 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white border-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">
                                            <i class="fas fa-chart-line text-primary"></i> 
                                            <span id="chartTitle">Faturamento Anual</span>
                                        </h5>
                                        <div class="btn-group btn-group-sm chart-type-filter" role="group">
                                            <button type="button" class="btn btn-outline-primary active" onclick="changeChartType('line')">
                                                <i class="fas fa-chart-line"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-primary" onclick="changeChartType('bar')">
                                                <i class="fas fa-chart-bar"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <canvas id="faturamentoChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <h5 class="mb-0">
                                        <i class="fas fa-chart-area text-info"></i> 
                                        <span id="comparativoTitle">Análise por Trimestre</span>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="comparativoChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <h5 class="mb-0">
                                        <i class="fas fa-trophy text-warning"></i> 
                                        <span id="topTitle">Top 5 Meses - Maior Faturamento</span>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="topChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .stats-card {
        border: none;
        border-radius: 10px;
        transition: transform 0.3s;
        position: relative;
        overflow: hidden;
    }

    .stats-card:hover {
        transform: translateY(-5px);
    }

    .stats-card-small {
        border: none;
        border-radius: 10px;
        transition: transform 0.3s;
    }

    .stats-card-small:hover {
        transform: scale(1.05);
    }

    .stats-icon {
        opacity: 0.3;
    }

    .bg-gradient-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .bg-gradient-danger {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
    }

    .bg-gradient-purple {
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    }

    .bg-gradient-orange {
        background: linear-gradient(135deg, #ff9a56 0%, #ff6a88 100%);
    }

    .bg-gradient-teal {
        background: linear-gradient(135deg, #2af598 0%, #009efd 100%);
    }

    .card {
        border-radius: 10px;
    }

    .card-header {
        padding: 1.25rem;
    }

    .h-100 {
        height: 100% !important;
    }

    .opacity-50 {
        opacity: 0.5;
    }

    .stretched-link::after {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1;
        content: "";
    }

    .nav-tabs .nav-link {
        color: #6c757d;
        font-weight: 500;
        border: none;
        border-bottom: 3px solid transparent;
        transition: all 0.3s;
    }

    .nav-tabs .nav-link:hover {
        border-color: transparent;
        color: #007bff;
        background-color: #f8f9fa;
    }

    .nav-tabs .nav-link.active {
        color: #007bff;
        background-color: transparent;
        border-color: transparent transparent #007bff;
        font-weight: 600;
    }

    .tab-content {
        padding-top: 1.5rem;
    }
</style>

<!-- jQuery e Bootstrap JS (necessários para as tabs funcionarem) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dados do faturamento mensal
    const faturamentoData = @json($faturamentoMensal);
    const meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    const valores = [
        faturamentoData.January || 0,
        faturamentoData.February || 0,
        faturamentoData.March || 0,
        faturamentoData.April || 0,
        faturamentoData.May || 0,
        faturamentoData.June || 0,
        faturamentoData.July || 0,
        faturamentoData.August || 0,
        faturamentoData.September || 0,
        faturamentoData.October || 0,
        faturamentoData.November || 0,
        faturamentoData.December || 0
    ];

    // Dados dos alunos
    const distribuicaoGenero = @json($distribuicaoGenero);
    const distribuicaoIdade = @json($distribuicaoIdade);
    const distribuicaoDias = @json($distribuicaoDias);
    const novosAlunosMes = @json($novosAlunosMes);
    const pacotesMaisVendidos = @json($pacotesMaisVendidos);
    const statusMatricula = @json($statusMatricula);
    const crescimentoMensal = @json($crescimentoMensal);
    const renovacoesVsNovos = @json($renovacoesVsNovos);
    const statusTemporal = @json($statusTemporal);

    let currentPeriod = 'year';
    let currentChartType = 'line';
    let faturamentoChart, comparativoChart, topChart;

    // === GRÁFICOS DE FATURAMENTO (ADMIN APENAS) ===
    
    @if(auth()->user()->hasRole('admin'))
    // Função para obter dados do período
    function getPeriodData(period) {
        let labels = [], data = [];
        
        switch(period) {
            case 'year':
                labels = meses;
                data = valores;
                break;
            case 'semester':
                labels = ['1º Semestre', '2º Semestre'];
                data = [
                    valores.slice(0, 6).reduce((a, b) => a + b, 0),
                    valores.slice(6, 12).reduce((a, b) => a + b, 0)
                ];
                break;
            case 'quarter':
                labels = ['1º Trimestre', '2º Trimestre', '3º Trimestre', '4º Trimestre'];
                data = [
                    valores.slice(0, 3).reduce((a, b) => a + b, 0),
                    valores.slice(3, 6).reduce((a, b) => a + b, 0),
                    valores.slice(6, 9).reduce((a, b) => a + b, 0),
                    valores.slice(9, 12).reduce((a, b) => a + b, 0)
                ];
                break;
            case 'month':
                const mesAtual = new Date().getMonth();
                labels = [meses[mesAtual]];
                data = [valores[mesAtual]];
                break;
        }
        
        return { labels, data };
    }

    window.createFaturamentoChart = function(type) {
        type = type || currentChartType;
        currentChartType = type;
        
        if (faturamentoChart) {
            faturamentoChart.destroy();
        }

        const periodData = getPeriodData(currentPeriod);
        const ctx = document.getElementById('faturamentoChart');
        
        if (ctx) {
            faturamentoChart = new Chart(ctx, {
                type: type,
                data: {
                    labels: periodData.labels,
                    datasets: [{
                        label: 'Faturamento (R$)',
                        data: periodData.data,
                        backgroundColor: type === 'bar' ? 'rgba(54, 162, 235, 0.5)' : 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'R$ ' + context.parsed.y.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'R$ ' + value.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                }
                            }
                        }
                    }
                }
            });
        }
    };

    function createComparativoChart() {
        if (comparativoChart) {
            comparativoChart.destroy();
        }

        const periodData = getPeriodData(currentPeriod);
        const ctx = document.getElementById('comparativoChart');
        
        if (ctx) {
            comparativoChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: periodData.labels,
                    datasets: [{
                        label: 'Faturamento (R$)',
                        data: periodData.data,
                        backgroundColor: periodData.data.map((_, i) => 
                            `rgba(${75 + i * 30}, ${192 - i * 20}, ${192}, 0.7)`
                        ),
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'R$ ' + value.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                }
                            }
                        }
                    }
                }
            });
        }
    }

    function createTopChart() {
        if (topChart) {
            topChart.destroy();
        }

        const periodData = getPeriodData(currentPeriod);
        const combined = periodData.labels.map((label, i) => ({ label, value: periodData.data[i] }));
        combined.sort((a, b) => b.value - a.value);
        const top5 = combined.slice(0, 5);

        const ctx = document.getElementById('topChart');
        
        if (ctx) {
            topChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: top5.map(item => item.label),
                    datasets: [{
                        label: 'Faturamento (R$)',
                        data: top5.map(item => item.value),
                        backgroundColor: 'rgba(153, 102, 255, 0.7)',
                        borderWidth: 0
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'R$ ' + value.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                }
                            }
                        }
                    }
                }
            });
        }
    }

    window.changeChartType = function(type) {
        createFaturamentoChart(type);
        document.querySelectorAll('.chart-type-filter button').forEach(btn => btn.classList.remove('active'));
        event.target.closest('button').classList.add('active');
    };

    window.changePeriod = function(period) {
        currentPeriod = period;
        
        const titles = {
            year: { main: 'Faturamento Anual', comp: 'Análise por Trimestre', top: 'Top 5 Meses' },
            semester: { main: 'Faturamento Semestral', comp: 'Comparativo Semestral', top: 'Melhores Semestres' },
            quarter: { main: 'Faturamento Trimestral', comp: 'Análise Trimestral', top: 'Melhores Trimestres' },
            month: { main: 'Faturamento do Mês', comp: 'Análise Mensal', top: 'Desempenho do Mês' }
        };
        
        document.getElementById('chartTitle').textContent = titles[period].main;
        document.getElementById('comparativoTitle').textContent = titles[period].comp;
        document.getElementById('topTitle').textContent = titles[period].top;
        
        document.querySelectorAll('.period-filter button').forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
        
        createFaturamentoChart(currentChartType);
        createComparativoChart();
        createTopChart();
    };

    const ctxMembros = document.getElementById('membrosChart');
    if (ctxMembros) {
        new Chart(ctxMembros, {
            type: 'doughnut',
            data: {
                labels: ['Ativos', 'Bloqueados', 'Inativos'],
                datasets: [{
                    data: [
                        {{ $membrosAtivos }},
                        {{ $membrosBloqueados }},
                        {{ $totalMembros - $membrosAtivos - $membrosBloqueados }}
                    ],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(201, 203, 207, 0.8)'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    createFaturamentoChart('line');
    createComparativoChart();
    createTopChart();
    @endif

    // === GRÁFICOS DE ANÁLISE DE ALUNOS (VISÍVEL PARA TODOS) ===

    // Gráfico de Distribuição por Gênero
    const ctxGenero = document.getElementById('generoChart');
    if (ctxGenero) {
        new Chart(ctxGenero, {
            type: 'doughnut',
            data: {
                labels: ['Masculino', 'Feminino'],
                datasets: [{
                    data: [distribuicaoGenero.masculino, distribuicaoGenero.feminino],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(232, 62, 140, 0.8)'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    // Gráfico de Faixa Etária
    const ctxIdade = document.getElementById('idadeChart');
    if (ctxIdade) {
        new Chart(ctxIdade, {
            type: 'bar',
            data: {
                labels: Object.keys(distribuicaoIdade),
                datasets: [{
                    label: 'Número de Alunos',
                    data: Object.values(distribuicaoIdade),
                    backgroundColor: 'rgba(255, 159, 64, 0.7)',
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    // Gráfico de Novos Alunos
    const ctxNovosAlunos = document.getElementById('novosAlunosChart');
    if (ctxNovosAlunos) {
        new Chart(ctxNovosAlunos, {
            type: 'line',
            data: {
                labels: Object.keys(novosAlunosMes),
                datasets: [{
                    label: 'Novos Alunos',
                    data: Object.values(novosAlunosMes),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    // Gráfico de Crescimento Total
    const ctxCrescimento = document.getElementById('crescimentoChart');
    if (ctxCrescimento) {
        new Chart(ctxCrescimento, {
            type: 'line',
            data: {
                labels: Object.keys(crescimentoMensal),
                datasets: [{
                    label: 'Total de Alunos',
                    data: Object.values(crescimentoMensal),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5
                        }
                    }
                }
            }
        });
    }

    // Gráfico de Renovações vs Novos
    const ctxRenovacoes = document.getElementById('renovacoesChart');
    if (ctxRenovacoes) {
        const labelsRenovacoes = Object.keys(renovacoesVsNovos);
        const novosData = labelsRenovacoes.map(mes => renovacoesVsNovos[mes].novos);
        const renovacoesData = labelsRenovacoes.map(mes => renovacoesVsNovos[mes].renovacoes);

        new Chart(ctxRenovacoes, {
            type: 'bar',
            data: {
                labels: labelsRenovacoes,
                datasets: [{
                    label: 'Novos Alunos',
                    data: novosData,
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderWidth: 0
                }, {
                    label: 'Renovações',
                    data: renovacoesData,
                    backgroundColor: 'rgba(255, 159, 64, 0.7)',
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    // Gráfico de Status Temporal
    const ctxStatusTemporal = document.getElementById('statusTemporalChart');
    if (ctxStatusTemporal) {
        const labelsStatus = Object.keys(statusTemporal);
        const ativosData = labelsStatus.map(mes => statusTemporal[mes].ativos);
        const bloqueadosData = labelsStatus.map(mes => statusTemporal[mes].bloqueados);
        const inativosData = labelsStatus.map(mes => statusTemporal[mes].inativos);

        new Chart(ctxStatusTemporal, {
            type: 'line',
            data: {
                labels: labelsStatus,
                datasets: [{
                    label: 'Ativos',
                    data: ativosData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Bloqueados',
                    data: bloqueadosData,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Inativos',
                    data: inativosData,
                    backgroundColor: 'rgba(201, 203, 207, 0.2)',
                    borderColor: 'rgba(201, 203, 207, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5
                        }
                    }
                }
            }
        });
    }

    // Gráfico de Dias Restantes
    const ctxDiasRestantes = document.getElementById('diasRestantesChart');
    if (ctxDiasRestantes) {
        new Chart(ctxDiasRestantes, {
            type: 'bar',
            data: {
                labels: Object.keys(distribuicaoDias),
                datasets: [{
                    label: 'Número de Alunos',
                    data: Object.values(distribuicaoDias),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(255, 205, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(54, 162, 235, 0.7)'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    // Gráfico de Pacotes Mais Vendidos
    const ctxPacotes = document.getElementById('pacotesChart');
    if (ctxPacotes) {
        new Chart(ctxPacotes, {
            type: 'bar',
            data: {
                labels: pacotesMaisVendidos.map(p => p.nome),
                datasets: [{
                    label: 'Vendas',
                    data: pacotesMaisVendidos.map(p => p.total),
                    backgroundColor: 'rgba(153, 102, 255, 0.7)',
                    borderWidth: 0
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    // Gráfico de Status Detalhado
    const ctxStatusDetalhado = document.getElementById('statusDetalhadoChart');
    if (ctxStatusDetalhado) {
        new Chart(ctxStatusDetalhado, {
            type: 'bar',
            data: {
                labels: Object.keys(statusMatricula).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                datasets: [{
                    label: 'Número de Alunos',
                    data: Object.values(statusMatricula),
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(201, 203, 207, 0.7)',
                        'rgba(255, 205, 86, 0.7)',
                        'rgba(255, 99, 132, 0.7)'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }
});
</script>
@endsection
