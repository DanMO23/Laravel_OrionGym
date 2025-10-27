@extends('layouts.user-layout')

@section('title', 'Resgate de Alunos')

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
                <h4 class="mb-0"><i class="fas fa-undo"></i> Alunos para Resgate</h4>
                <div class="btn-group-actions mt-2 mt-md-0">
                    <a href="{{ route('alunos.index') }}" class="btn btn-light btn-sm m-1">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Formulário de Adição -->
            <div class="section-title mb-3">
                <h5 class="text-primary"><i class="fas fa-plus-circle"></i> Adicionar Alunos ao Resgate</h5>
                <hr>
            </div>

            <form action="{{ route('alunos.resgatar') }}" method="POST" class="mb-4">
                @csrf
                <div class="form-group">
                    <label for="numero_matricula" class="font-weight-bold">Matrículas dos alunos (separadas por vírgula) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input type="text" id="numero_matricula" name="numero_matricula" 
                               class="form-control" 
                               placeholder="Ex: 2222, 2223, 2224" required>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Adicionar
                            </button>
                        </div>
                    </div>
                    <small class="form-text text-muted">Digite as matrículas separadas por vírgula</small>
                </div>
            </form>

            <!-- Lista de Alunos -->
            <div class="section-title mb-3">
                <h5 class="text-primary"><i class="fas fa-list"></i> Lista de Resgate</h5>
                <hr>
            </div>

            @if ($alunosResgate->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-2"></i>
                    <p class="mb-0">Nenhum aluno na lista de resgate.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th><i class="fas fa-id-card"></i> Matrícula</th>
                                <th><i class="fas fa-user"></i> Nome</th>
                                <th><i class="fas fa-phone"></i> Telefone</th>
                                <th><i class="fas fa-clock"></i> Data de Último Acesso</th>
                                <th class="text-center"><i class="fas fa-cog"></i> Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alunosResgate as $aluno)
                            <tr>
                                <td class="font-weight-bold">{{ $aluno->numero_matricula }}</td>
                                <td>{{ $aluno->nome }}</td>
                                <td>{{ $aluno->telefone }}</td>
                                @php
                                    $alunoVencido = $alunosVencidos->where('numero_matricula', $aluno->numero_matricula)->first();
                                @endphp
                                <td>
                                    @if($alunoVencido)
                                        <small>{{ $alunoVencido->created_at->format('d/m/Y') }}</small>
                                        <br>
                                        <small class="text-muted">{{ $alunoVencido->created_at->format('H:i:s') }}</small>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-success"
                                                data-toggle="modal" 
                                                data-target="#confirmarContato{{$aluno->id}}"
                                                title="Confirmar Contato">
                                            <i class="fas fa-check"></i> Entrei em Contato
                                        </button>
                                    </div>

                                    <!-- Modal de Confirmação -->
                                    <div class="modal fade" id="confirmarContato{{$aluno->id}}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-success text-white">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-check-circle"></i> Confirmar Contato
                                                    </h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <i class="fas fa-phone fa-3x text-success mb-3"></i>
                                                    <p>Confirmar que entrou em contato com:</p>
                                                    <p class="font-weight-bold">{{ $aluno->nome }}</p>
                                                    <p class="text-muted">{{ $aluno->telefone }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                        <i class="fas fa-times"></i> Cancelar
                                                    </button>
                                                    <form action="{{ route('alunos.resgate.remover', $aluno->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="fas fa-check"></i> Confirmar
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .section-title h5 {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .section-title hr {
        margin-top: 0.5rem;
        border-top: 2px solid #007bff;
        opacity: 0.3;
    }

    .card {
        border-radius: 10px;
        border: none;
    }

    .table th {
        font-weight: 600;
        font-size: 0.9rem;
        border-top: none;
    }

    .table td {
        vertical-align: middle;
    }

    .btn-group-actions .btn {
        font-weight: 500;
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

<!-- Scripts do Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection