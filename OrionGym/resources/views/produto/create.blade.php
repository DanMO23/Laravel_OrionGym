@extends('layouts.user-layout')

@section('header-user', 'Adicionar Produto')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('produto.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="nome">Nome do Produto</label>
                            <input type="text" name="nome" class="form-control" required>
                            @error('nome')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="foto">Foto do Produto(Arquivo PNG):</label>
                            <input type="file" name="foto" class="form-control-file">
                            @error('foto')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <textarea name="descricao" class="form-control"></textarea>
                            @error('descricao')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="quantidade_estoque">Quantidade em Estoque</label>
                            <input type="number" name="quantidade_estoque" class="form-control" required min="0">
                            @error('quantidade_estoque')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="valor">Valor do Produto (R$)</label>
                            <input type="number" name="valor" class="form-control" step="0.01" required min="0">
                            @error('valor')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
