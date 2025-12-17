@extends('layouts.user-layout')

@section('title', 'Alunos Vencidos')

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
        <div class="card-header bg-danger text-white">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h4 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Alunos Vencidos</h4>
                <div class="mt-2 mt-md-0">
                    <a href="{{ route('alunos.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Voltar para Lista
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if ($alunosVencidos->isEmpty() && !$search)
                <div class="alert alert-success text-center">
                    <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                    <h5>Ótimas notícias!</h5>
                    <p class="mb-0">Não há alunos com matrícula vencida no momento.</p>
                </div>
            @else
                <!-- Barra de Pesquisa -->
                <div class="search-bar mb-4">
                    <form action="{{ route('alunos.vencidos') }}" method="GET">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-right-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   id="searchInput"
                                   class="form-control border-left-0" 
                                   placeholder="Pesquisar por nome, matrícula ou telefone..."
                                   value="{{ $search }}"
                                   autofocus>
                            @if($search)
                                <div class="input-group-append">
                                    <a href="{{ route('alunos.vencidos') }}" class="btn btn-outline-secondary" title="Limpar busca">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </form>
                    @if($search)
                        <small class="text-muted mt-2 d-block">
                            <i class="fas fa-info-circle"></i> 
                            Mostrando resultados para: <strong>"{{ $search }}"</strong>
                        </small>
                    @endif
                </div>

                @if($alunosVencidos->isEmpty())
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle fa-2x mb-2"></i>
                        <p class="mb-0">Nenhum aluno vencido encontrado para "{{ $search }}".</p>
                        <a href="{{ route('alunos.vencidos') }}" class="btn btn-sm btn-primary mt-2">
                            <i class="fas fa-arrow-left"></i> Ver todos os alunos vencidos
                        </a>
                    </div>
                @else
                    <div class="alert alert-warning mb-4">
                        <strong><i class="fas fa-info-circle"></i> Atenção:</strong>
                        @if($search)
                            Encontrado(s) <strong>{{ $alunosVencidos->count() }}</strong> aluno(s) vencido(s) com o termo "{{ $search }}".
                        @else
                            Existem <strong>{{ $alunosVencidos->count() }}</strong> aluno(s) com matrícula vencida.
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th><i class="fas fa-id-card"></i> Matrícula</th>
                                    <th><i class="fas fa-user"></i> Nome</th>
                                    <th><i class="fas fa-phone"></i> Telefone</th>
                                    <th><i class="fas fa-flag"></i> Status</th>
                                    <th><i class="fas fa-calendar-times"></i> Data de Vencimento</th>
                                    <th class="text-center"><i class="fas fa-cog"></i> Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alunosVencidos as $aluno)
                                <tr class="table-danger">
                                    <td class="font-weight-bold">{{ $aluno->numero_matricula }}</td>
                                    <td>{{ $aluno->nome }}</td>
                                    <td>{{ $aluno->telefone }}</td>
                                    <td>
                                        @php
                                            $statusClass = '';
                                            $statusIcon = '';
                                            switch($aluno->matricula_ativa) {
                                                case 'bloqueado':
                                                    $statusClass = 'badge-danger';
                                                    $statusIcon = 'fa-lock';
                                                    break;
                                                case 'inativa':
                                                    $statusClass = 'badge-secondary';
                                                    $statusIcon = 'fa-ban';
                                                    break;
                                                default:
                                                    $statusClass = 'badge-warning';
                                                    $statusIcon = 'fa-exclamation-triangle';
                                            }
                                        @endphp
                                        <span class="badge {{ $statusClass }}">
                                            <i class="fas {{ $statusIcon }}"></i>
                                            {{ ucfirst($aluno->matricula_ativa) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-danger font-weight-bold">
                                            <i class="fas fa-calendar-times"></i>
                                            {{ $aluno->created_at->format('d/m/Y') }}
                                        </span>
                                        <br>
                                        <small class="text-muted">
                                            {{ $aluno->created_at->diffForHumans() }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap justify-content-center">
                                            <a href="{{ route('alunos.show', $aluno->aluno_id) }}" 
                                               class="btn btn-sm btn-outline-info m-1"
                                               title="Ver Detalhes">
                                                <i class="fas fa-eye"></i> Detalhes
                                            </a>
                                            
                                            @if($aluno->matricula_ativa != 'bloqueado')
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger m-1" 
                                                        data-toggle="modal" 
                                                        data-target="#confirmarBloqueio{{ $aluno->id }}">
                                                    <i class="fas fa-lock"></i> Bloquear
                                                </button>
                                            @else
                                                <span class="badge badge-danger p-2 m-1">
                                                    <i class="fas fa-lock"></i> Já Bloqueado na Catraca
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Legenda -->
                    <div class="mt-3">
                        <small class="text-muted">
                            <strong>Status:</strong>
                            <span class="badge badge-danger ml-2"><i class="fas fa-lock"></i> Bloqueado</span>
                            <span class="badge badge-secondary ml-2"><i class="fas fa-ban"></i> Inativa</span>
                            <span class="badge badge-warning ml-2"><i class="fas fa-exclamation-triangle"></i> Vencido</span>
                        </small>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

<!-- Modals de Confirmação de Bloqueio -->
@foreach ($alunosVencidos as $aluno)
    @if($aluno->matricula_ativa != 'bloqueado')
    <div class="modal fade" id="confirmarBloqueio{{ $aluno->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-lock"></i> Confirmar Bloqueio na Catraca
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <p>Você confirma que o aluno <strong>{{ $aluno->nome }}</strong> foi bloqueado na catraca?</p>
                    <div class="alert alert-warning mt-3">
                        <small>
                            <i class="fas fa-info-circle"></i>
                            Esta ação indicará que o aluno está fisicamente impedido de acessar a academia.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <form action="{{ route('alunos.bloquear', $aluno->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-lock"></i> Confirmar Bloqueio
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach

<style>
    .search-bar .input-group-text {
        border-radius: 50px 0 0 50px;
    }

    .search-bar .form-control {
        border-radius: 0 50px 50px 0;
        padding: 1rem 1.5rem;
        font-size: 1rem;
        border: 2px solid #e0e0e0;
    }

    .search-bar .form-control:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

    .search-bar .input-group-prepend .input-group-text {
        border: 2px solid #e0e0e0;
        border-right: none;
    }

    .card {
        border-radius: 10px;
        border: none;
    }

    .table th {
        font-weight: 600;
        font-size: 0.9rem;
        border-top: none;
        white-space: nowrap;
    }

    .table td {
        vertical-align: middle;
    }

    .table-hover tbody tr:hover {
        background-color: #fff5f5 !important;
    }

    .modal-content {
        border-radius: 10px;
    }

    .alert i.fa-3x {
        opacity: 0.8;
    }

    @media (max-width: 768px) {
        .table th, .table td {
            font-size: 0.85rem;
            padding: 0.5rem;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .search-bar .form-control {
            font-size: 0.9rem;
            padding: 0.75rem 1rem;
        }
    }
</style>

<!-- Scripts do Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Busca em tempo real (opcional)
    let searchTimeout;
    document.getElementById('searchInput').addEventListener('keyup', function(e) {
        clearTimeout(searchTimeout);
        
        // Submete o formulário após 500ms de inatividade
        if (e.key !== 'Enter') {
            searchTimeout = setTimeout(() => {
                this.form.submit();
            }, 500);
        }
    });
</script>
@endsection