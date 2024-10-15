@extends('layouts.user-layout')

@section('title', 'Realizar Compra')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Realizar Compra</div>

                <div class="card-body">
                    <form action="{{ route('compraProduto.store') }}" method="POST">
                        @csrf

                        <!-- Exibir informações do produto selecionado -->
                        <div class="form-group">
                            <label for="produto">Produto Selecionado</label>
                            <input type="text" class="form-control" value="{{ $produto->nome }} - R$ {{ number_format($produto->valor, 2, ',', '.') }}" disabled>
                            <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                        </div>

                        <div class="form-group">
                            <label for="nome_comprador">Nome do Comprador</label>
                            <input type="text" name="nome_comprador" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="quantidade">Quantidade</label>
                            <input type="number" name="quantidade" class="form-control" value="1" min="1">
                        </div>

                        <!-- Adicionar o checkbox para alterar o valor -->
                        <div class="form-group">
                            <label for="alterar_valor">Alterar Valor do Produto?</label>
                            <input type="checkbox" id="alterar_valor" name="alterar_valor">
                        </div>

                        <!-- Campo para inserir o novo valor do produto -->
                        <div class="form-group">
                            <label for="valor_produto">Valor do Produto:</label>
                            <input type="number" step="0.01" name="valor_produto" id="valor_produto" class="form-control" value="{{ $produto->valor }}" required disabled>
                        </div>

                        <button type="submit" class="btn btn-primary">Finalizar Compra</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para habilitar/desabilitar o campo de valor do produto -->
<script>
    document.getElementById('alterar_valor').addEventListener('change', function() {
        var valorProdutoInput = document.getElementById('valor_produto');
        valorProdutoInput.disabled = !this.checked; // Habilita se checkbox está marcado, desabilita caso contrário
        if (!this.checked) {
            valorProdutoInput.value = '{{ $produto->valor }}'; // Se desabilitado, volta ao valor original
        }
    });
</script>

@endsection
