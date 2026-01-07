@extends('layouts.user-layout')

@section('header-user', 'Lista de Avaliações Físicas')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h4 class="mb-0"><i class="fas fa-clipboard-list"></i> Avaliações Físicas</h4>
                <div class="btn-group-actions mt-2 mt-md-0">
                    <a href="{{ route('avaliacao.create') }}" class="btn btn-light btn-sm m-1">
                        <i class="fas fa-plus"></i> Nova Avaliação
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Formulário de Busca -->
            <div class="search-box mb-4">
                <form action="{{ route('avaliacao.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-8 mb-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Buscar por nome ou CPF..." 
                                       value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                    @if(request('search'))
                                        <a href="{{ route('avaliacao.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Limpar
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <select name="status" class="form-control" onchange="this.form.submit()">
                                <option value="">Todos os Status</option>
                                <option value="Pendente" {{ request('status') == 'Pendente' ? 'selected' : '' }}>Pendente</option>
                                <option value="Finalizada" {{ request('status') == 'Finalizada' ? 'selected' : '' }}>Finalizada</option>
                                <option value="Cancelada" {{ request('status') == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            @if($avaliacoes->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-2"></i>
                    <p class="mb-0">Não há avaliações cadastradas.</p>
                    <a href="{{ route('avaliacao.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus"></i> Cadastrar Nova Avaliação
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th><i class="fas fa-user"></i> Nome</th>
                                <th><i class="fas fa-id-card"></i> CPF</th>
                                <th><i class="fas fa-calendar"></i> Data da Compra</th>
                                <th><i class="fas fa-clock"></i> Hora da Compra</th>
                                <th><i class="fas fa-comment"></i> Descrição</th>
                                <th><i class="fas fa-dollar-sign"></i> Valor</th>
                                <th><i class="fas fa-flag"></i> Status</th>
                                <th class="text-center"><i class="fas fa-cog"></i> Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($avaliacoes as $avaliacao)
                            <tr class="{{ $avaliacao->status == 'Pendente' ? 'table-warning' : '' }}
                                       {{ $avaliacao->status == 'Cancelada' ? 'table-danger' : '' }}
                                       {{ $avaliacao->status == 'Finalizada' ? 'table-success' : '' }}">
                                <td class="font-weight-bold">{{ $avaliacao->nome }}</td>
                                <td>{{ $avaliacao->cpf }}</td>
                                <td>
                                    <i class="fas fa-calendar-day text-muted"></i>
                                    {{ \Carbon\Carbon::parse($avaliacao->data_avaliacao)->format('d/m/Y') }}
                                </td>
                                <td>
                                    <i class="fas fa-clock text-muted"></i>
                                    {{ $avaliacao->horario_avaliacao }}
                                </td>
                                <td>
                                    @if($avaliacao->descricao_pagamento)
                                        <span class="text-truncate d-inline-block" style="max-width: 150px;" 
                                              title="{{ $avaliacao->descricao_pagamento }}">
                                            {{ $avaliacao->descricao_pagamento }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="font-weight-bold text-success">
                                        R$ {{ number_format($avaliacao->valor_avaliacao, 2, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    @if($avaliacao->status == 'Pendente')
                                        <span class="badge badge-warning badge-pill px-3 py-2">
                                            <i class="fas fa-hourglass-half"></i> Pendente
                                        </span>
                                    @elseif($avaliacao->status == 'Finalizada')
                                        <span class="badge badge-success badge-pill px-3 py-2">
                                            <i class="fas fa-check-circle"></i> Finalizada
                                        </span>
                                    @else
                                        <span class="badge badge-danger badge-pill px-3 py-2">
                                            <i class="fas fa-times-circle"></i> Cancelada
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($avaliacao->status == 'Pendente')
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('avaliacao.confirmar', $avaliacao->id) }}" 
                                               class="btn btn-success btn-sm" title="Confirmar Avaliação"
                                               onclick="return confirm('Tem certeza que deseja confirmar esta avaliação?')">
                                                <i class="fas fa-check"></i>
                                            </a>
                                            <a href="{{ route('avaliacao.cancelar', $avaliacao->id) }}" 
                                               class="btn btn-danger btn-sm" title="Cancelar e Apagar"
                                               onclick="return confirm('Tem certeza que deseja cancelar e apagar esta avaliação?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    @else
                                        <span class="badge badge-light text-muted">
                                            <i class="fas fa-lock"></i> Finalizada
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 mb-3">
                    <div class="text-muted mb-2 mb-md-0">
                        Mostrando {{ $avaliacoes->firstItem() ?? 0 }} a {{ $avaliacoes->lastItem() ?? 0 }} de {{ $avaliacoes->total() }} registros
                    </div>
                    <nav aria-label="Paginação">
                        {{ $avaliacoes->links('pagination::bootstrap-4') }}
                    </nav>
                </div>

                <!-- Estatísticas resumidas -->
                <div class="row mt-4">
                    <div class="{{ auth()->user()->hasRole('admin') ? 'col-md-4' : 'col-md-6' }}">
                        <div class="card bg-warning text-white shadow-sm">
                            <div class="card-body text-center py-3">
                                <h5 class="mb-0">{{ $totalPendentes }}</h5>
                                <small>Pendentes</small>
                            </div>
                        </div>
                    </div>
                    <div class="{{ auth()->user()->hasRole('admin') ? 'col-md-4' : 'col-md-6' }}">
                        <div class="card bg-success text-white shadow-sm">
                            <div class="card-body text-center py-3">
                                <h5 class="mb-0">{{ $totalFinalizadas }}</h5>
                                <small>Finalizadas</small>
                            </div>
                        </div>
                    </div>
                    @if(auth()->user()->hasRole('admin'))
                    <div class="col-md-4">
                        <div class="card bg-primary text-white shadow-sm">
                            <div class="card-body text-center py-3">
                                <h5 class="mb-0">R$ {{ number_format($totalMesAtual, 2, ',', '.') }}</h5>
                                <small>Total do Mês ({{ now()->format('M/Y') }})</small>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 10px;
}
.card-header {
    border-radius: 10px 10px 0 0 !important;
}
.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}
.badge-pill {
    font-size: 0.8rem;
}
.btn-group .btn {
    margin-right: 2px;
}
.search-box {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
}

/* Estilos da Paginação */
.pagination {
    margin-bottom: 0;
    display: flex;
    flex-wrap: wrap;
}

.pagination .page-item {
    margin: 0 2px;
}

.pagination .page-link {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.25;
    color: #007bff;
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
    text-decoration: none;
    display: inline-block;
    min-width: 40px;
    text-align: center;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
    z-index: 1;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    cursor: not-allowed;
    background-color: #fff;
    border-color: #dee2e6;
    opacity: 0.6;
}

.pagination .page-link:hover:not(.disabled) {
    color: #0056b3;
    text-decoration: none;
    background-color: #e9ecef;
    border-color: #dee2e6;
}

.pagination .page-link:focus {
    z-index: 2;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

@media (max-width: 768px) {
    .pagination {
        font-size: 0.75rem;
    }

    .pagination .page-link {
        padding: 0.25rem 0.5rem;
        min-width: 32px;
    }
}
</style>
@endsection
