<!-- resources/views/compra/create.blade.php -->

@extends('layouts.user-layout')

@section('content')
    <div class="container">
    
        <h2>Comprar Pacote</h2>
        <form action="{{ route('compra.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="aluno">Selecione o Aluno:</label>
                <select name="aluno" id="aluno" class="form-control">
                    @foreach($alunos as $aluno)
                        <option value="{{ $aluno->id }}">{{ $aluno->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="pacote">Selecione o Pacote:</label>
                <select name="pacote" id="pacote" class="form-control">
                    @foreach($pacotes as $pacote)
                        <option value="{{ $pacote->id }}">{{ $pacote->nome_pacote }} - R$ {{ $pacote->valor }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="descricao_pagamento">Descrição do Pagamento:</label>
                <textarea name="descricao_pagamento" id="descricao_pagamento" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Comprar Pacote</button>
        </form>
    </div>
@endsection
