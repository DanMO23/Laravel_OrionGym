@extends('layouts.user-layout')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Compra</div>

                <div class="card-body">
                    <form action="{{ route('compra.update', $compra->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="user">Usuário</label>
                            <input type="text" name="user" class="form-control" value="{{ $compra->aluno->nome}}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="pacote">Selecione o Pacote:</label>
                            <select name="pacote" id="pacote" class="form-control">
                                @foreach($pacotes as $pacote)
                                <option value="{{ $pacote->id }}">{{ $pacote->nome_pacote }} - R$ {{ $pacote->valor }} - {{$pacote->validade}} dias</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="descricao_pagamento">Descrição do Pagamento</label>
                            <input type="text" name="descricao_pagamento" class="form-control" value="{{ $compra->descricao_pagamento }}" required>


                            <button type="submit" class="btn btn-primary">Atualizar</button>
                            <a href="{{ route('compra.historico') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection