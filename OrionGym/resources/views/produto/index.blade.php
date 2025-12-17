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
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('produto.create') }}" class="btn btn-light btn-sm m-1">
                            <i class="fas fa-plus"></i> Adicionar Produto
                        </a>
                    @endif
                    <a href="{{ route('compraProduto.historico') }}" class="btn btn-info btn-sm m-1">
                        <i class="fas fa-history"></i> Histórico de Vendas
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Barra de Pesquisa -->
            <div class="search-bar mb-4">
                <form action="{{ route('produto.index') }}" method="GET">
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
                               placeholder="Pesquisar produtos por nome..."
                               value="{{ request('search') }}"
                               autofocus>
                        @if(request('search'))
                            <div class="input-group-append">
                                <a href="{{ route('produto.index') }}" class="btn btn-outline-secondary" title="Limpar busca">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </form>
                @if(request('search'))
                    <small class="text-muted mt-2 d-block">
                        <i class="fas fa-info-circle"></i> 
                        Mostrando resultados para: <strong>"{{ request('search') }}"</strong>
                    </small>
                @endif
            </div>

            @if ($produtos->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-2"></i>
                    @if(request('search'))
                        <p class="mb-0">Nenhum produto encontrado para "{{ request('search') }}".</p>
                        <a href="{{ route('produto.index') }}" class="btn btn-sm btn-primary mt-2">
                            <i class="fas fa-arrow-left"></i> Ver todos os produtos
                        </a>
                    @else
                        <p class="mb-0">Não há produtos cadastrados.</p>
                    @endif
                </div>
            @else
                <!-- Informação de ordenação -->
                <div class="alert alert-light border d-flex justify-content-between align-items-center mb-3">
                    <span>
                        <i class="fas fa-sort-amount-down text-primary"></i> 
                        <strong>{{ $produtos->count() }}</strong> produto(s) encontrado(s) - Ordenados por quantidade em estoque
                    </span>
                    <div class="badge-group">
                        <span class="badge badge-success">
                            <i class="fas fa-check-circle"></i> 
                            Disponíveis: {{ $produtos->where('estoque', '>', 0)->count() }}
                        </span>
                        <span class="badge badge-danger ml-1">
                            <i class="fas fa-times-circle"></i> 
                            Esgotados: {{ $produtos->where('estoque', 0)->count() }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    @foreach ($produtos as $produto)
                    <div class="col-md-4 col-lg-3 mb-4 produto-card" data-nome="{{ strtolower($produto->nome) }}">
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
                                @else
                                    <span class="badge badge-success stock-badge">
                                        <i class="fas fa-check-circle"></i> Disponível
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
                                            {{ $produto->estoque == 1 ? 'unidade' : 'unidades' }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="mt-auto">
                                    <div class="btn-group btn-group-sm d-flex" role="group">
                                        @if(auth()->user()->hasRole('admin'))
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
                                        @endif
                                        
                                        @if($produto->estoque > 0)
                                            <a href="{{ route('compraProduto.create', ['produto_id' => $produto->id]) }}" 
                                               class="btn btn-outline-success {{ auth()->user()->hasRole('admin') ? 'flex-fill' : 'btn-block' }}"
                                               title="Vender">
                                                <i class="fas fa-shopping-cart"></i> Vender
                                            </a>
                                        @else
                                            <button class="btn btn-outline-secondary {{ auth()->user()->hasRole('admin') ? 'flex-fill' : 'btn-block' }}" 
                                                    disabled 
                                                    title="Sem estoque">
                                                <i class="fas fa-shopping-cart"></i> Sem estoque
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal de Confirmação de Exclusão -->
                        @if(auth()->user()->hasRole('admin'))
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
                                        @if($produto->estoque > 0)
                                            <div class="alert alert-warning">
                                                <i class="fas fa-exclamation-circle"></i>
                                                Este produto ainda tem {{ $produto->estoque }} unidade(s) em estoque!
                                            </div>
                                        @endif
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
                        @endif
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

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
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .search-bar .input-group-prepend .input-group-text {
        border: 2px solid #e0e0e0;
        border-right: none;
    }

    .badge-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

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

        .badge-group {
            flex-direction: column;
            width: 100%;
        }

        .badge-group .badge {
            width: 100%;
        }
    }
</style>

<!-- Scripts do Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Busca em tempo real (opcional - complementa a busca por submit)
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
