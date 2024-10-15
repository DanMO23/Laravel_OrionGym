@extends('layouts.user-layout')

@section('title', 'Lista de Produtos')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4>Galeria de Produtos</h4>
                        <a href="{{ route('produto.create') }}" class="btn btn-primary btn-sm">Adicionar Produto</a>
                    </div>
                </div>

                <div class="card-body">
                    @if ($produtos->isEmpty())
                    <p>Não há produtos cadastrados.</p>
                    @else
                    <div class="row">
                        @foreach ($produtos as $produto)
                        <div class="col-md-4">
                            <div class="card mb-4">
                                @if($produto->foto)
                                <img src="{{ asset('uploads/produtos/' . $produto->foto) }}" class="card-img-top" alt="{{ $produto->nome }}" style="object-fit: cover; width: 100%; height: 250px;">
                                @else
                                <img src="" class="card-img-top" alt="Imagem não disponível" style="object-fit: cover; width: 100%; height: 250px;">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $produto->nome }}</h5>
                                    <p class="card-text">R$ {{ number_format($produto->valor, 2, ',', '.') }}</p>
                                    <p>Estoque : {{ $produto->estoque }}</p>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('produto.edit', $produto->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        <form action="{{ route('produto.destroy', $produto->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                        </form>
                                        <a href="{{ route('compraProduto.create', ['produto_id' => $produto->id]) }}" class="btn btn-success btn-sm">Comprar</a>
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
    </div>
</div>
@endsection
