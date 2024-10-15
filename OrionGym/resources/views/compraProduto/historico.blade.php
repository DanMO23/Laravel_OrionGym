@extends('layouts.user-layout')

@section('title', 'Histórico de Compras')

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

                <div class="card-header ">
                    <h4>Histórico de Compras</h4>
                </div>

                <div class="card-body">
                    @if ($compras->isEmpty())
                    <p>Não há compras registradas.</p>
                    @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nome do Comprador</th>
                                    <th>Produto</th>
                                    <th>Valor</th>
                                    <th>Quantidade</th>
                                    <th>Valor Total</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($compras as $compra)
                                <tr>
                                    <td>{{ $compra->comprador }}</td>
                                    <td>{{ $compra->produto->nome }}</td>
                                    <td>R$ {{ number_format($compra->produto->valor, 2, ',', '.') }}</td>
                                    <td>{{ $compra->quantidade }}</td>
                                    <td>R$ {{ number_format($compra->produto->valor * $compra->quantidade, 2, ',', '.') }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('compraProduto.edit', $compra->id) }}" class="btn btn-warning btn-sm mr-1">Editar</a>
                                            <form action="{{ route('compraProduto.destroy', $compra->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                            </form>
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
    </div>
</div>
@endsection
