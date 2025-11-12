@extends('layouts.user-layout')

@section('header-user', 'Ficha de Treino')

@section('content')
<div class="container-fluid py-4">
    <!-- Cabeçalho da Ficha -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-gradient-primary text-white">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="mb-0"><i class="fas fa-clipboard-list"></i> {{ $ficha->nome_ficha }}</h3>
                    <p class="mb-0 mt-2"><i class="fas fa-user"></i> Aluno: <strong>{{ $ficha->nome_aluno }}</strong></p>
                </div>
                <div class="col-md-4 text-right">
                    <span class="badge badge-light badge-lg">
                        <i class="fas fa-calendar-alt"></i> {{ $ficha->created_at->format('d/m/Y') }}
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group" role="group">
                        <a href="{{ route('fichas.edit', $ficha->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar Ficha
                        </a>
                        <a href="{{ route('fichas.imprimir', $ficha->id) }}" target="_blank" class="btn btn-success">
                            <i class="fas fa-print"></i> Imprimir
                        </a>
                        <a href="{{ route('fichas.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards de Treinos -->
    @if($treinos->isEmpty())
        <div class="alert alert-warning text-center">
            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
            <p class="mb-0">Nenhum treino cadastrado para esta ficha.</p>
        </div>
    @else
        <div class="row">
            @foreach($treinos as $index => $treino)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card treino-card shadow-sm h-100" data-toggle="modal" data-target="#treinoModal{{ $treino->id }}">
                        <div class="card-header bg-treino-{{ $index % 5 }} text-white text-center">
                            <h4 class="mb-0">
                                <i class="fas fa-dumbbell"></i> Treino {{ $treino->nome_treino }}
                            </h4>
                        </div>
                        <div class="card-body">
                            @if($treino->exercicios->count() > 0)
                                <p class="text-center mb-3">
                                    <span class="badge badge-primary badge-pill badge-lg">
                                        {{ $treino->exercicios->count() }} exercício(s)
                                    </span>
                                </p>
                                <ul class="list-group list-group-flush">
                                    @foreach($treino->exercicios->take(3) as $exercicio)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-check-circle text-success"></i> {{ $exercicio->nome_exercicio }}</span>
                                            <span class="badge badge-secondary">{{ $exercicio->series }}x{{ $exercicio->repeticoes_tempo }}</span>
                                        </li>
                                    @endforeach
                                    @if($treino->exercicios->count() > 3)
                                        <li class="list-group-item text-center text-muted">
                                            <small>+ {{ $treino->exercicios->count() - 3 }} exercício(s)</small>
                                        </li>
                                    @endif
                                </ul>
                            @else
                                <p class="text-muted text-center">Nenhum exercício cadastrado</p>
                            @endif
                        </div>
                        <div class="card-footer text-center">
                            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#treinoModal{{ $treino->id }}">
                                <i class="fas fa-eye"></i> Ver Detalhes
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal com detalhes do treino -->
                <div class="modal fade" id="treinoModal{{ $treino->id }}" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-treino-{{ $index % 5 }} text-white">
                                <h5 class="modal-title">
                                    <i class="fas fa-dumbbell"></i> Treino {{ $treino->nome_treino }} - Detalhes
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @if($treino->exercicios->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th><i class="fas fa-hashtag"></i></th>
                                                    <th><i class="fas fa-running"></i> Exercício</th>
                                                    <th class="text-center"><i class="fas fa-layer-group"></i> Séries</th>
                                                    <th class="text-center"><i class="fas fa-redo"></i> Rep/Tempo</th>
                                                    <th class="text-center"><i class="fas fa-pause-circle"></i> Descanso</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($treino->exercicios as $key => $exercicio)
                                                    <tr>
                                                        <td class="font-weight-bold">{{ $key + 1 }}</td>
                                                        <td class="font-weight-bold">{{ $exercicio->nome_exercicio }}</td>
                                                        <td class="text-center">
                                                            <span class="badge badge-primary">{{ $exercicio->series }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge badge-info">{{ $exercicio->repeticoes_tempo }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge badge-warning">{{ $exercicio->descanso }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted text-center">Nenhum exercício cadastrado para este treino.</p>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    <i class="fas fa-times"></i> Fechar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .bg-treino-0 {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .bg-treino-1 {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .bg-treino-2 {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    .bg-treino-3 {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }

    .bg-treino-4 {
        background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
    }

    .treino-card {
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }

    .treino-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3) !important;
    }

    .badge-lg {
        font-size: 1rem;
        padding: 0.5rem 1rem;
    }

    .list-group-item {
        border-left: none;
        border-right: none;
    }

    .list-group-item:first-child {
        border-top: none;
    }

    .modal-content {
        border-radius: 15px;
        overflow: hidden;
    }

    .table thead th {
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
</style>

<!-- Scripts do Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
