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

                        <button type="submit" class="btn btn-primary">Finalizar Compra</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
