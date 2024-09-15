@extends('layouts.user-layout')

@section('content')
<div class="container">
    <h2>Lista de Avaliações Físicas</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Data da Avaliação</th>
                <th>Horário da Avaliação</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($avaliacoes as $avaliacao)
            <tr>
                <td>{{ $avaliacao->nome }}</td>
                <td>{{ $avaliacao->cpf }}</td>
                <td>{{ $avaliacao->data_avaliacao }}</td>
                <td>{{ $avaliacao->horario_avaliacao }}</td>
                <td>{{ $avaliacao->descricao_pagamento }}</td>
                <td>R$ {{ number_format($avaliacao->valor_avaliacao, 2, ',', '.') }}</td>
                <td>{{ $avaliacao->status }}</td>
                <td>
                    @if($avaliacao->status == 'Pendente')
                        <a href="{{ route('avaliacao.confirmar', $avaliacao->id) }}" class="btn btn-success btn-sm">Confirmar Avaliação</a>
                        <a href="{{ route('avaliacao.cancelar', $avaliacao->id) }}" class="btn btn-danger btn-sm">Cancelar e Apagar Avaliação</a>
                    @else
                        <span class="badge badge-success">Avaliação Confirmada</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
