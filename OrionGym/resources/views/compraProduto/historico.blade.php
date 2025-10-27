@extends('layouts.user-layout')

@section('title', 'Histórico de Vendas')

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
                <h4 class="mb-0"><i class="fas fa-history"></i> Histórico de Vendas de Produtos</h4>
                <div class="btn-group-actions mt-2 mt-md-0">
                    <a href="{{ route('produto.index') }}" class="btn btn-light btn-sm m-1">
                        <i class="fas fa-shopping-bag"></i> Ver Produtos
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if ($compras->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-2"></i>
                    <p class="mb-0">Não há vendas registradas.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th><i class="fas fa-user"></i> Comprador</th>
                                <th><i class="fas fa-box"></i> Produto</th>
                                <th><i class="fas fa-dollar-sign"></i> Valor Unitário</th>
                                <th><i class="fas fa-sort-numeric-up"></i> Quantidade</th>
                                <th><i class="fas fa-receipt"></i> Valor Total</th>
                                <th><i class="fas fa-clock"></i> Data</th>
                                <th class="text-center"><i class="fas fa-cog"></i> Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($compras as $compra)
                            <tr>
                                <td class="font-weight-bold">{{ $compra->comprador }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $compra->produto->nome }}</span>
                                </td>
                                <td>R$ {{ number_format($compra->valor_total / $compra->quantidade, 2, ',', '.') }}</td>
                                <td>
                                    <span class="badge badge-secondary">{{ $compra->quantidade }}</span>
                                </td>
                                <td class="font-weight-bold text-success">
                                    R$ {{ number_format($compra->valor_total, 2, ',', '.') }}
                                </td>
                                <td>
                                    <small>{{ $compra->created_at->format('d/m/Y') }}</small>
                                    <br>
                                    <small class="text-muted">{{ $compra->created_at->format('H:i:s') }}</small>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger"
                                                data-toggle="modal" 
                                                data-target="#confirmarDelecao{{$compra->id}}"
                                                title="Excluir">
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
                                                    <p>Tem certeza que deseja excluir esta venda?</p>
                                                    <div class="alert alert-warning">
                                                        <strong>Comprador:</strong> {{ $compra->comprador }}<br>
                                                        <strong>Produto:</strong> {{ $compra->produto->nome }}<br>
                                                        <strong>Quantidade:</strong> {{ $compra->quantidade }}
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                        <i class="fas fa-times"></i> Cancelar
                                                    </button>
                                                    <form action="{{ route('compraProduto.destroy', $compra->id) }}" method="POST" class="d-inline">
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
