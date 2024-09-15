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
            <label for="avaliacao_fisica">Pacote:</label>


            <input type="text" name="user" class="form-control" value="Avaliação Física" readonly>


        </div>

        <div class="form-group">
            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" id="telefone" class="form-control" placeholder="Digite o telefone" required>
        </div>

        <div class="form-group">
            <label for="valor_avaliacao">Valor da Avaliação:</label>
            <input type="checkbox" id="alterar_valor" name="alterar_valor">
            <label for="alterar_valor">Alterar valor</label>

            <input type="number" step="0.01" name="valor_avaliacao" id="valor_avaliacao" class="form-control" value="50.00" disabled>
        </div>

        <div class="form-group">
            <label for="data_avaliacao">Data da Avaliação:</label>
            <input type="date" name="data_avaliacao" id="data_avaliacao" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="horario_avaliacao">Horário da Avaliação:</label>
            <select name="horario_avaliacao" id="horario_avaliacao" class="form-control" required>
                @for($h = 6; $h <= 22; $h++)
                    <option value="{{ $h }}:00">{{ $h }}:00</option>
                    @endfor
            </select>
        </div>


        <div class="form-group">
            <label for="descricao_pagamento">Descrição do Pagamento:</label>
            <textarea name="descricao_pagamento" id="descricao_pagamento" class="form-control" rows="3" placeholder="Descreva o pagamento"></textarea>
        </div>

        <script>
        document.getElementById('alterar_valor').addEventListener('change', function() {
            document.getElementById('valor_avaliacao').disabled = !this.checked;
        });
        </script>


        <button type="submit" class="btn btn-primary">Registrar Avaliação</button>
    </form>
</div>
@endsection