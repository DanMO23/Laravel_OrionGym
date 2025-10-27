@extends('layouts.user-layout')

@section('title', 'Transferir Dias')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Transferir Dias de {{ $aluno->nome }}</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <p>Dias restantes de {{ $aluno->nome }}: <strong>{{ $aluno->dias_restantes }}</strong></p>

                    <form action="{{ route('alunos.transferir.dias', $aluno->id) }}" method="POST" id="formTransferir">
                        @csrf
                        <div class="form-group">
                            <label for="aluno_destino_id">Transferir para:</label>
                            <select name="aluno_destino_id" id="aluno_destino_id" class="form-control" required>
                                <option value="">Selecione um aluno</option>
                                @foreach($outrosAlunos as $outroAluno)
                                    <option value="{{ $outroAluno->id }}">{{ $outroAluno->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="dias">Quantidade de Dias:</label>
                            <input type="number" name="dias" id="dias" class="form-control" min="1" max="{{ $aluno->dias_restantes }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Transferir</button>
                        <a href="{{ route('alunos.show', $aluno->id) }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('formTransferir').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const diasInput = document.getElementById('dias');
    const alunoDestinoSelect = document.getElementById('aluno_destino_id');
    const alunoDestinoNome = alunoDestinoSelect.options[alunoDestinoSelect.selectedIndex].text;
    const diasQuantidade = diasInput.value;
    
    if (!alunoDestinoSelect.value) {
        alert('Por favor, selecione um aluno de destino.');
        return;
    }
    
    if (!diasQuantidade || diasQuantidade <= 0) {
        alert('Por favor, informe uma quantidade válida de dias.');
        return;
    }
    
    const confirmacao = confirm(
        `Você tem certeza que deseja transferir ${diasQuantidade} dia(s) para ${alunoDestinoNome}?\n\n` +
        `De: {{ $aluno->nome }}\n` +
        `Para: ${alunoDestinoNome}\n` +
        `Dias: ${diasQuantidade}\n\n` +
        `Esta ação não pode ser desfeita.`
    );
    
    if (confirmacao) {
        this.submit();
    }
});
</script>
@endsection
