<!-- resources/views/compra/historico.blade.php -->

@extends('layouts.user-layout')

@section('content')
    <div class="container">
    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
        <h1>Histórico de Compras</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Matricula</th>
                    <th>Aluno</th>

                    <th>Pacote</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Validade</th>
                    <th>Data da Compra</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($compras as $compra)
                <tr>
                    <td>{{ $compra->aluno->numero_matricula }}</td>
                    <td>{{ $compra->aluno->nome }}</td>
                    <td>{{ $compra->pacote->nome_pacote }}</td>
                    <td>{{ $compra->descricao_pagamento }}</td>
                    <td>R$ {{ $compra->valor_pacote }}</td>
                    <td>{{ $compra->pacote->validade }} dias</td>
                    <td>{{ $compra->created_at->format('d/m/Y H:i:s') }}</td>
                    <td>
                                            <a href="{{ route('compras.edit', $compra->id) }}" class="btn btn-primary btn-sm">Editar</a>
                                            <form action="{{ route('compras.destroy', $compra->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja deletar esta compra?')">Deletar</button>
                                            </form>
                                        </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
