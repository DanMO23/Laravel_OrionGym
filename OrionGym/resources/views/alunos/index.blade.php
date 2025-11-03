@extends('layouts.user-layout')

@section('title', 'Lista de Alunos')

@section('content')
<div class="container py-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h4 class="mb-0"><i class="fas fa-users"></i> Lista de Alunos</h4>
                <div class="btn-group-actions mt-2 mt-md-0">
                    <a href="{{ route('alunos.create') }}" class="btn btn-light btn-sm m-1">
                        <i class="fas fa-user-plus"></i> Novo Aluno
                    </a>
                    <a href="{{ route('alunos.export') }}" class="btn btn-success btn-sm m-1">
                        <i class="fas fa-file-excel"></i> Exportar Excel
                    </a>
                    <a href="{{ route('alunos.resgate') }}" class="btn btn-warning btn-sm m-1">
                        <i class="fas fa-undo"></i> Resgate
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Formulário de Busca e Filtros -->
            <div class="search-box mb-4">
                <form action="{{ route('alunos.index') }}" method="GET" id="searchForm">
                    <div class="row">
                        <div class="col-md-8 mb-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <input type="text" id="search" name="search" class="form-control" 
                                       placeholder="Buscar por nome, CPF ou matrícula..." 
                                       value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                    @if(request('search'))
                                        <a href="{{ route('alunos.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Limpar
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-search"></i> Por página:
                                    </span>
                                </div>
                                <select name="per_page" class="form-control" onchange="this.form.submit()">
                                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                    <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="sort_by" value="{{ request('sort_by', 'numero_matricula') }}">
                    <input type="hidden" name="sort_order" value="{{ request('sort_order', 'asc') }}">
                </form>
            </div>

            @if ($alunos->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-2"></i>
                    <p class="mb-0">Não há alunos cadastrados.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th class="sortable" data-sort="numero_matricula">
                                    <i class="fas fa-id-card"></i> Matrícula
                                    @if(request('sort_by') == 'numero_matricula')
                                        <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </th>
                                <th class="sortable" data-sort="nome">
                                    <i class="fas fa-user"></i> Nome
                                    @if(request('sort_by') == 'nome')
                                        <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </th>
                                <th class="sortable" data-sort="email">
                                    <i class="fas fa-envelope"></i> Email
                                    @if(request('sort_by') == 'email')
                                        <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </th>
                                <th class="sortable" data-sort="telefone">
                                    <i class="fas fa-phone"></i> Telefone
                                    @if(request('sort_by') == 'telefone')
                                        <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </th>
                                <th class="sortable" data-sort="sexo">
                                    <i class="fas fa-venus-mars"></i> Sexo
                                    @if(request('sort_by') == 'sexo')
                                        <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </th>
                                <th class="sortable" data-sort="dias_restantes">
                                    <i class="fas fa-calendar-alt"></i> Dias Restantes
                                    @if(request('sort_by') == 'dias_restantes')
                                        <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </th>
                                <th class="sortable" data-sort="matricula_ativa">
                                    <i class="fas fa-flag"></i> Status
                                    @if(request('sort_by') == 'matricula_ativa')
                                        <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </th>
                                <th class="text-center"><i class="fas fa-cog"></i> Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alunos as $aluno)
                            <tr class="{{ $aluno->dias_restantes <= 5 && $aluno->dias_restantes > 0 ? 'table-warning' : '' }} 
                                       {{ $aluno->dias_restantes == 0 ? 'table-danger' : '' }}">
                                <td class="font-weight-bold">{{ $aluno->numero_matricula }}</td>
                                <td>{{ $aluno->nome }}</td>
                                <td>{{ $aluno->email ?: '-' }}</td>
                                <td>{{ $aluno->telefone }}</td>
                                <td>
                                    <span class="badge badge-{{ $aluno->sexo == 'M' ? 'info' : 'pink' }}">
                                        {{ $aluno->sexo == 'M' ? 'Masculino' : 'Feminino' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-pill 
                                        {{ $aluno->dias_restantes > 5 ? 'badge-success' : '' }}
                                        {{ $aluno->dias_restantes > 0 && $aluno->dias_restantes <= 5 ? 'badge-warning' : '' }}
                                        {{ $aluno->dias_restantes == 0 ? 'badge-danger' : '' }}">
                                        {{ $aluno->dias_restantes }} dias
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $statusClass = '';
                                        $statusText = '';
                                        switch($aluno->matricula_ativa) {
                                            case 'ativa':
                                                $statusClass = 'badge-success';
                                                $statusText = 'Ativa';
                                                break;
                                            case 'inativa':
                                                $statusClass = 'badge-secondary';
                                                $statusText = 'Inativa';
                                                break;
                                            case 'trancado':
                                                $statusClass = 'badge-warning';
                                                $statusText = 'Trancada';
                                                break;
                                            case 'bloqueado':
                                                $statusClass = 'badge-danger';
                                                $statusText = 'Bloqueada';
                                                break;
                                            default:
                                                $statusClass = 'badge-secondary';
                                                $statusText = ucfirst($aluno->matricula_ativa);
                                        }
                                    @endphp
                                    <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap justify-content-center">
                                        @if($aluno->matricula_ativa == 'ativa')
                                            <button type="button" class="btn btn-sm btn-outline-danger m-1" 
                                                    data-toggle="modal" data-target="#confirmarTrancamento{{$aluno->id}}"
                                                    title="Trancar Matrícula">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-outline-success m-1" 
                                                    data-toggle="modal" data-target="#confirmarDestrancamento{{$aluno->id}}"
                                                    title="Destrancar Matrícula">
                                                <i class="fas fa-unlock"></i>
                                            </button>
                                        @endif

                                        <a href="{{ route('alunos.show', $aluno->id) }}" 
                                           class="btn btn-sm btn-outline-info m-1"
                                           title="Ver Detalhes">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('avaliacao.create', ['aluno_id' => $aluno->id]) }}" 
                                           class="btn btn-sm btn-outline-primary m-1"
                                           title="Agendar Avaliação">
                                            <i class="fas fa-calendar-check"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <p class="text-muted">
                            Mostrando {{ $alunos->firstItem() }} até {{ $alunos->lastItem() }} de {{ $alunos->total() }} registros
                        </p>
                    </div>
                    <div>
                        {{ $alunos->links() }}
                    </div>
                </div>

                <!-- Legenda -->
                <div class="mt-3">
                    <small class="text-muted">
                        <strong>Legenda:</strong>
                        <span class="badge badge-success ml-2">Mais de 5 dias</span>
                        <span class="badge badge-warning ml-2">5 dias ou menos</span>
                        <span class="badge badge-danger ml-2">Sem dias</span>
                    </small>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
        border: none;
    }

    .table th {
        font-weight: 600;
        font-size: 0.9rem;
        border-top: none;
    }

    .table th.sortable {
        cursor: pointer;
        user-select: none;
        transition: background-color 0.2s;
    }

    .table th.sortable:hover {
        background-color: #e2e6ea;
    }

    .table td {
        vertical-align: middle;
    }

    .search-box .input-group-text {
        border-right: none;
    }

    .search-box .form-control {
        border-left: none;
    }

    .search-box .form-control:focus {
        box-shadow: none;
        border-color: #ced4da;
    }

    .btn-group-actions .btn {
        font-weight: 500;
    }

    .badge-pink {
        background-color: #e83e8c;
        color: white;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    .modal-content {
        border-radius: 10px;
    }

    @media (max-width: 768px) {
        .btn-group-actions {
            width: 100%;
        }
        
        .btn-group-actions .btn {
            width: 100%;
            margin: 0.25rem 0 !important;
        }
    }
</style>

<script>
    // JavaScript para ordenação por clique nas colunas
    document.addEventListener('DOMContentLoaded', function() {
        const sortableHeaders = document.querySelectorAll('.sortable');
        
        sortableHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const sortBy = this.getAttribute('data-sort');
                const currentSortBy = '{{ request("sort_by", "numero_matricula") }}';
                const currentSortOrder = '{{ request("sort_order", "asc") }}';
                
                let newSortOrder = 'asc';
                if (sortBy === currentSortBy) {
                    newSortOrder = currentSortOrder === 'asc' ? 'desc' : 'asc';
                }
                
                // Atualizar campos hidden e submeter formulário
                document.querySelector('input[name="sort_by"]').value = sortBy;
                document.querySelector('input[name="sort_order"]').value = newSortOrder;
                document.getElementById('searchForm').submit();
            });
        });
    });
</script>

<!-- Scripts do Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection