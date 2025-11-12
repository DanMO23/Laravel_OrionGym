@extends('layouts.user-layout')

@section('header-user', 'Cadastrar Aluno de Personal')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-user-plus"></i> Novo Aluno de Personal</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('alunos-personal.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="professor_id">Personal Trainer *</label>
                            <select name="professor_id" id="professor_id" class="form-control @error('professor_id') is-invalid @enderror" required>
                                <option value="">Selecione...</option>
                                @foreach($professores as $prof)
                                    <option value="{{ $prof->id }}" {{ old('professor_id') == $prof->id ? 'selected' : '' }}>
                                        {{ $prof->numero_matricula }} - {{ $prof->nome_completo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('professor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tipo_aluno">Tipo de Aluno *</label>
                            <select name="tipo_aluno" id="tipo_aluno" class="form-control @error('tipo_aluno') is-invalid @enderror" required>
                                <option value="">Selecione...</option>
                                <option value="matriculado" {{ old('tipo_aluno') == 'matriculado' ? 'selected' : '' }}>Aluno Matriculado</option>
                                <option value="externo" {{ old('tipo_aluno') == 'externo' ? 'selected' : '' }}>Aluno Externo</option>
                            </select>
                            @error('tipo_aluno')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Campo para aluno matriculado -->
                <div id="campoAlunoMatriculado" style="display: none;">
                    <div class="form-group">
                        <label for="aluno_id">Selecione o Aluno Matriculado</label>
                        <select name="aluno_id" id="aluno_id" class="form-control">
                            <option value="">Selecione...</option>
                            @foreach($alunos as $aluno)
                                <option value="{{ $aluno->id }}">{{ $aluno->numero_matricula }} - {{ $aluno->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Campos para aluno externo -->
                <div id="camposAlunoExterno" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="nome_completo">Nome Completo *</label>
                                <input type="text" name="nome_completo" id="nome_completo" 
                                       class="form-control @error('nome_completo') is-invalid @enderror" 
                                       value="{{ old('nome_completo') }}">
                                @error('nome_completo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cpf">CPF *</label>
                                <input type="text" name="cpf" id="cpf" 
                                       class="form-control @error('cpf') is-invalid @enderror" 
                                       value="{{ old('cpf') }}"
                                       placeholder="000.000.000-00"
                                       maxlength="14">
                                @error('cpf')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dia_vencimento">Dia do Vencimento *</label>
                            <select name="dia_vencimento" id="dia_vencimento" 
                                    class="form-control @error('dia_vencimento') is-invalid @enderror" required>
                                <option value="">Selecione o dia...</option>
                                @for($i = 1; $i <= 28; $i++)
                                    <option value="{{ $i }}" {{ old('dia_vencimento') == $i ? 'selected' : '' }}>
                                        Dia {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            @error('dia_vencimento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> O pagamento vencerá todo dia {{ old('dia_vencimento', 'X') }} do mês
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="valor_mensalidade">Valor da Mensalidade</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">R$</span>
                                </div>
                                <input type="number" step="0.01" name="valor_mensalidade" id="valor_mensalidade" 
                                       class="form-control" value="{{ old('valor_mensalidade') }}"
                                       placeholder="0,00">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="observacoes">Observações</label>
                    <textarea name="observacoes" id="observacoes" rows="3" class="form-control">{{ old('observacoes') }}</textarea>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    <strong>Sistema de Vencimento:</strong> O pagamento será renovado automaticamente todo mês no dia escolhido.
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Salvar
                    </button>
                    <a href="{{ route('alunos-personal.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Máscara para CPF
    document.getElementById('cpf').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length <= 11) {
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        }
        e.target.value = value;
    });

    // Toggle campos baseado no tipo de aluno
    document.getElementById('tipo_aluno').addEventListener('change', function() {
        const tipo = this.value;
        const campoMatriculado = document.getElementById('campoAlunoMatriculado');
        const camposExterno = document.getElementById('camposAlunoExterno');
        
        if (tipo === 'matriculado') {
            campoMatriculado.style.display = 'block';
            camposExterno.style.display = 'none';
            document.getElementById('aluno_id').required = true;
            document.getElementById('nome_completo').required = false;
            document.getElementById('cpf').required = false;
        } else if (tipo === 'externo') {
            campoMatriculado.style.display = 'none';
            camposExterno.style.display = 'block';
            document.getElementById('aluno_id').required = false;
            document.getElementById('nome_completo').required = true;
            document.getElementById('cpf').required = true;
        } else {
            campoMatriculado.style.display = 'none';
            camposExterno.style.display = 'none';
        }
    });

    // Atualizar informação do dia de vencimento
    document.getElementById('dia_vencimento').addEventListener('change', function() {
        const dia = this.value;
        const info = this.parentElement.querySelector('.form-text');
        if (dia) {
            info.innerHTML = '<i class="fas fa-info-circle"></i> O pagamento vencerá todo dia ' + dia + ' do mês';
        }
    });
</script>
@endsection
