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
                                <option value="{{ $pacote->id }}" {{ $compra->pacote_id == $pacote->id ? 'selected' : '' }}>
                                    {{ $pacote->nome_pacote }} - R$ {{ $pacote->valor }} - {{ $pacote->validade }} dias
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="descricao_pagamento">Descrição do Pagamento</label>
                            <input type="text" name="descricao_pagamento" class="form-control" value="{{ $compra->descricao_pagamento }}" required>
                        </div>

                        <div class="form-group">
                            <input type="checkbox" id="editar_valor" name="editar_valor" value="1">
                            <label for="editar_valor">Editar Valor do Pacote</label>
                        </div>

                        <div class="form-group" id="valor_pacote_field" style="display: none;">
                            <label for="valor_pacote">Novo Valor</label>
                            <input type="number" step="0.01" name="valor_pacote" id="valor_pacote" class="form-control" value="{{ $compra->pacote->valor }}" disabled required>
                        </div>

                        <button type="submit" class="btn btn-primary">Atualizar</button>
                        <a href="{{ route('compra.historico') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editarValorCheckbox = document.getElementById('editar_valor');
        const valorPacoteField = document.getElementById('valor_pacote_field');
        const valorPacoteInput = document.getElementById('valor_pacote');

        editarValorCheckbox.addEventListener('change', function () {
            valorPacoteField.style.display = editarValorCheckbox.checked ? 'block' : 'none';
            valorPacoteInput.disabled = !editarValorCheckbox.checked;
        });

        // Initialize display based on initial checkbox state
        valorPacoteField.style.display = editarValorCheckbox.checked ? 'block' : 'none';
        valorPacoteInput.disabled = !editarValorCheckbox.checked;
    });
</script>

@endsection
