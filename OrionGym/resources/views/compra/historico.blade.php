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
                    <th>Aluno</th>
                    <th>Pacote</th>
                    <th>Descrição</th>
                    <th>Validade do Pacote</th>
                    <th>Data da Compra</th>
                </tr>
            </thead>
            <tbody>
                @foreach($compras as $compra)
                <tr>
                    <td>{{ $compra->aluno->nome }}</td>
                    <td>{{ $compra->pacote->nome_pacote }}</td>
                    <td>{{ $compra->descricao_pagamento }}</td>
                    <td>{{ $compra->pacote->validade }} dias restantes</td>
                    <td>{{ $compra->created_at->format('d/m/Y H:i:s') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
