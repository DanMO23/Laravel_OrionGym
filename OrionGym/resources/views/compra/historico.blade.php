<!-- resources/views/compra/historico.blade.php -->

@extends('layouts.user-layout')

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
                <h4 class="mb-0"><i class="fas fa-shopping-cart"></i> Histórico de Compras</h4>
                <div class="btn-group-actions mt-2 mt-md-0">
                    <a href="{{ route('compra.create') }}" class="btn btn-light btn-sm m-1">
                        <i class="fas fa-plus"></i> Nova Compra
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Formulário de Busca -->
            <div class="search-box mb-4">
                <form action="{{ route('compra.historico') }}" method="GET">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                        <input type="text" id="search" name="search" class="form-control" 
                               placeholder="Buscar por aluno ou matricula..." 
                               value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                            @if(request('search'))
                                <a href="{{ route('compra.historico') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Limpar
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            @if ($compras->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-2"></i>
                    <p class="mb-0">Não há compras registradas.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th><i class="fas fa-id-card"></i> Matrícula</th>
                                <th><i class="fas fa-user"></i> Aluno</th>
                                <th><i class="fas fa-box"></i> Pacote</th>
                                <th><i class="fas fa-file-alt"></i> Descrição</th>
                                <th><i class="fas fa-dollar-sign"></i> Valor</th>
                                <th><i class="fas fa-calendar-alt"></i> Validade</th>
                                <th><i class="fas fa-clock"></i> Data da Compra</th>
                                <th class="text-center"><i class="fas fa-cog"></i> Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($compras as $compra)
                            <tr>
                                <td class="font-weight-bold">{{ $compra->aluno->numero_matricula }}</td>
                                <td>{{ $compra->aluno->nome }}</td>
                                <td>
                                    @if($compra->pacote)
                                        <span class="badge badge-primary">{{ $compra->pacote->nome_pacote }}</span>
                                    @else
                                        <span class="badge badge-info">Transferência</span>
                                    @endif
                                </td>
                                <td>{{ $compra->descricao_pagamento }}</td>
                                <td class="font-weight-bold text-success">R$ {{ number_format($compra->valor_pacote, 2, ',', '.') }}</td>
                                <td>
                                    @if($compra->pacote)
                                        <span class="badge badge-secondary">{{ $compra->pacote->validade }} dias</span>
                                    @else
                                        <span class="badge badge-secondary">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $compra->created_at->format('d/m/Y') }}</small>
                                    <br>
                                    <small class="text-muted">{{ $compra->created_at->format('H:i:s') }}</small>
                                </td>
                                <td>
                                    @if($compra->pacote)
                                        <div class="d-flex flex-wrap justify-content-center">
                                            <a href="{{ route('compras.edit', $compra->id) }}" 
                                               class="btn btn-sm btn-outline-primary m-1"
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger m-1"
                                                    data-toggle="modal" data-target="#confirmarDelecao{{$compra->id}}"
                                                    title="Deletar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Modal de Confirmação -->
                                        <div class="modal fade" id="confirmarDelecao{{$compra->id}}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-exclamation-triangle"></i> Confirmar Exclusão
                                                        </h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <i class="fas fa-trash fa-3x text-danger mb-3"></i>
                                                        <p>Tem certeza que deseja deletar esta compra?</p>
                                                        <p class="font-weight-bold">{{ $compra->aluno->nome }} - {{ $compra->pacote->nome_pacote }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                            <i class="fas fa-times"></i> Cancelar
                                                        </button>
                                                        <form action="{{ route('compras.destroy', $compra->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="fas fa-trash"></i> Confirmar
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
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
