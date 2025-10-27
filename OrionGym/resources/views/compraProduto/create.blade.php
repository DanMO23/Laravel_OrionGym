@extends('layouts.user-layout')

@section('title', 'Realizar Compra')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-shopping-cart"></i> Realizar Venda</h4>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Atenção!</strong> Por favor, corrija os seguintes erros:
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('compraProduto.store') }}" method="POST">
                        @csrf

                        <!-- Produto Selecionado -->
                        <div class="section-title mb-3">
                            <h5 class="text-primary"><i class="fas fa-box"></i> Produto Selecionado</h5>
                            <hr>
                        </div>

                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    @if($produto->foto)
                                        <div class="col-md-3">
                                            <img src="{{ asset('uploads/produtos/' . $produto->foto) }}" 
                                                 class="img-thumbnail" 
                                                 alt="{{ $produto->nome }}"
                                                 style="max-width: 100%; height: auto;">
                                        </div>
                                    @endif
                                    <div class="col-md-{{ $produto->foto ? '9' : '12' }}">
                                        <h5 class="mb-2">{{ $produto->nome }}</h5>
                                        <p class="mb-1"><strong>Valor Unitário:</strong> R$ {{ number_format($produto->valor, 2, ',', '.') }}</p>
                                        <p class="mb-0"><strong>Estoque Disponível:</strong> {{ $produto->estoque }} unidades</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="produto_id" value="{{ $produto->id }}">

                        <!-- Informações da Venda -->
                        <div class="section-title mb-3">
                            <h5 class="text-primary"><i class="fas fa-user"></i> Informações do Comprador</h5>
                            <hr>
                        </div>

                        <div class="form-group">
                            <label for="nome_comprador" class="font-weight-bold">Nome do Comprador <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="nome_comprador" id="nome_comprador"
                                       class="form-control @error('nome_comprador') is-invalid @enderror" 
                                       value="{{ old('nome_comprador') }}" required>
                                @error('nome_comprador')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Quantidade e Valor -->
                        <div class="section-title mb-3 mt-4">
                            <h5 class="text-primary"><i class="fas fa-calculator"></i> Detalhes da Venda</h5>
                            <hr>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quantidade" class="font-weight-bold">Quantidade <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-sort-numeric-up"></i></span>
                                        </div>
                                        <input type="number" name="quantidade" id="quantidade"
                                               class="form-control @error('quantidade') is-invalid @enderror" 
                                               value="{{ old('quantidade', 1) }}" min="1" max="{{ $produto->estoque }}" required>
                                        @error('quantidade')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <small class="form-text text-muted">Máximo: {{ $produto->estoque }} unidades</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox mb-2">
                                        <input type="checkbox" class="custom-control-input" id="alterar_valor" name="alterar_valor" {{ old('alterar_valor') ? 'checked' : '' }}>
                                        <label class="custom-control-label font-weight-bold" for="alterar_valor">
                                            <i class="fas fa-edit"></i> Alterar Valor Unitário
                                        </label>
                                    </div>
                                    
                                    <label for="valor_produto" class="font-weight-bold">Valor Unitário (R$) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="number" name="valor_produto" id="valor_produto"
                                               class="form-control @error('valor_produto') is-invalid @enderror" 
                                               value="{{ old('valor_produto', $produto->valor) }}" step="0.01" required disabled>
                                        @error('valor_produto')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Resumo da Venda -->
                        <div class="card bg-primary text-white mt-4">
                            <div class="card-body">
                                <h5 class="mb-3"><i class="fas fa-receipt"></i> Resumo da Venda</h5>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="mb-1">Quantidade:</p>
                                        <h4 id="resumo-quantidade">1</h4>
                                    </div>
                                    <div class="col-6 text-right">
                                        <p class="mb-1">Valor Total:</p>
                                        <h4 id="resumo-total">R$ {{ number_format($produto->valor, 2, ',', '.') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botões de Ação -->
                        <div class="d-flex justify-content-center mt-4 gap-2">
                            <button type="submit" class="btn btn-success btn-lg px-5 m-1">
                                <i class="fas fa-check"></i> Finalizar Venda
                            </button>
                            <a href="{{ route('produto.index') }}" class="btn btn-secondary btn-lg px-5 m-1">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
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

    .form-group label {
        font-size: 0.9rem;
        color: #495057;
    }

    .form-control {
        border-radius: 5px;
        padding: 0.6rem 0.75rem;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .card {
        border-radius: 10px;
        border: none;
    }

    .gap-2 {
        gap: 0.5rem;
    }

    .btn-lg {
        font-weight: 500;
    }

    .text-danger {
        font-weight: bold;
    }

    .input-group-text {
        background-color: #e9ecef;
        border: 1px solid #ced4da;
    }

    .custom-control-label {
        cursor: pointer;
    }
</style>

<script>
    // Função para atualizar o resumo
    function atualizarResumo() {
        const quantidade = parseInt(document.getElementById('quantidade').value) || 0;
        const valorUnitario = parseFloat(document.getElementById('valor_produto').value) || 0;
        const valorTotal = quantidade * valorUnitario;

        document.getElementById('resumo-quantidade').textContent = quantidade;
        document.getElementById('resumo-total').textContent = 'R$ ' + valorTotal.toFixed(2).replace('.', ',');
    }

    // Habilitar/desabilitar campo de valor
    document.getElementById('alterar_valor').addEventListener('change', function() {
        const valorProdutoInput = document.getElementById('valor_produto');
        valorProdutoInput.disabled = !this.checked;
        
        if (!this.checked) {
            valorProdutoInput.value = '{{ $produto->valor }}';
            atualizarResumo();
        }
    });

    // Atualizar resumo ao mudar quantidade ou valor
    document.getElementById('quantidade').addEventListener('input', atualizarResumo);
    document.getElementById('valor_produto').addEventListener('input', atualizarResumo);

    // Inicializar resumo
    atualizarResumo();
</script>
@endsection
