@extends('layouts.user-layout')

@section('title', 'Lista de Produtos')

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
                <h4 class="mb-0"><i class="fas fa-shopping-bag"></i> Galeria de Produtos</h4>
                <div class="btn-group-actions mt-2 mt-md-0">
                    <a href="{{ route('produto.create') }}" class="btn btn-light btn-sm m-1">
                        <i class="fas fa-plus"></i> Adicionar Produto
                    </a>
                    <a href="{{ route('compraProduto.historico') }}" class="btn btn-info btn-sm m-1">
                        <i class="fas fa-history"></i> Histórico de Vendas
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if ($produtos->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-2"></i>
                    <p class="mb-0">Não há produtos cadastrados.</p>
                </div>
            @else
                <div class="row">
                    @foreach ($produtos as $produto)
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card h-100 product-card">
                            <div class="product-image-container">
                                @if($produto->foto)
                                    <img src="{{ asset('uploads/produtos/' . $produto->foto) }}" 
                                         class="card-img-top product-image" 
                                         alt="{{ $produto->nome }}">
                                @else
                                    <div class="no-image-placeholder">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                        <p class="text-muted">Sem imagem</p>
                                    </div>
                                @endif
                                
                                <!-- Badge de estoque -->
                                @if($produto->estoque <= 5 && $produto->estoque > 0)
                                    <span class="badge badge-warning stock-badge">
                                        <i class="fas fa-exclamation-triangle"></i> Estoque baixo
                                    </span>
                                @elseif($produto->estoque == 0)
                                    <span class="badge badge-danger stock-badge">
                                        <i class="fas fa-times-circle"></i> Sem estoque
                                    </span>
                                @endif
                            </div>
                            
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $produto->nome }}</h5>
                                
                                <div class="product-info mb-3">
                                    <div class="price-tag">
                                        <span class="price-label">Valor</span>
                                        <span class="price-value">R$ {{ number_format($produto->valor, 2, ',', '.') }}</span>
                                    </div>
                                    
                                    <div class="stock-info mt-2">
                                        <i class="fas fa-boxes"></i>
                                        <span class="ml-1">
                                            Estoque: 
                                            <strong class="{{ $produto->estoque <= 5 ? 'text-danger' : 'text-success' }}">
                                                {{ $produto->estoque }}
                                            </strong>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="mt-auto">
                                    <div class="btn-group btn-group-sm d-flex" role="group">
                                        <a href="{{ route('produto.edit', $produto->id) }}" 
                                           class="btn btn-outline-primary flex-fill"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <button type="button" 
                                                class="btn btn-outline-danger flex-fill" 
                                                data-toggle="modal" 
                                                data-target="#confirmarDelecao{{$produto->id}}"
                                                title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        
                                        @if($produto->estoque > 0)
                                            <a href="{{ route('compraProduto.create', ['produto_id' => $produto->id]) }}" 
                                               class="btn btn-outline-success flex-fill"
                                               title="Vender">
                                                <i class="fas fa-shopping-cart"></i>
                                            </a>
                                        @else
                                            <button class="btn btn-outline-secondary flex-fill" disabled title="Sem estoque">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal de Confirmação de Exclusão -->
                        <div class="modal fade" id="confirmarDelecao{{$produto->id}}" tabindex="-1">
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
                                        <p>Tem certeza que deseja excluir este produto?</p>
                                        <p class="font-weight-bold">{{ $produto->nome }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            <i class="fas fa-times"></i> Cancelar
                                        </button>
                                        <form action="{{ route('produto.destroy', $produto->id) }}" method="POST" class="d-inline">
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
                    </div>
                    @endforeach
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

    .product-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid #e0e0e0;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    .product-image-container {
        position: relative;
        width: 100%;
        height: 250px;
        overflow: hidden;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .no-image-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
    }

    .stock-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 5px 10px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .price-tag {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 10px;
        border-radius: 8px;
        text-align: center;
    }

    .price-label {
        display: block;
        font-size: 0.75rem;
        opacity: 0.9;
        margin-bottom: 5px;
    }

    .price-value {
        display: block;
        font-size: 1.5rem;
        font-weight: bold;
    }

    .stock-info {
        padding: 8px;
        background-color: #f8f9fa;
        border-radius: 5px;
        text-align: center;
    }

    .btn-group-actions .btn {
        font-weight: 500;
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
