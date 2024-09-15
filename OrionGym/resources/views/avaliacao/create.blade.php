@extends('layouts.user-layout')

@section('content')
<div class="container">
    <h2>Nova Avaliação Física</h2>
    <form action="{{ route('avaliacao.store') }}" method="POST">
        @csrf
        @method('POST')
        <div class="form-group">
            <label for="nome">Nome da Pessoa:</label>
            <input type="text" name="nome" id="nome" class="form-control" placeholder="Digite o nome" required>
        </div>
        <div class="form-group">
            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" class="form-control" placeholder="Digite o CPF" required>
        </div>

        <div class="form-group">
            <label for="avaliacao_fisica">Pacote Avaliação Física:</label>
            
                @foreach($pacotes as $pacote)
                @if($pacote->nome_pacote == 'Avaliação Física')
                <input type="text" name="user" class="form-control" value="{{ $pacote->nome_pacote}}" readonly>
                @endif
                @endforeach
           
        </div>

        <div class="form-group">
            <label for="descricao_pagamento">Descrição do Pagamento:</label>
            <textarea name="descricao_pagamento" id="descricao_pagamento" class="form-control" rows="3" placeholder="Descreva o pagamento" required></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Registrar Compra</button>
    </form>
</div>
@endsection