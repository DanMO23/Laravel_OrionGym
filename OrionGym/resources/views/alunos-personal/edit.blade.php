@extends('layouts.user-layout')

@section('header-user', 'Editar Aluno de Personal')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0"><i class="fas fa-edit"></i> Editar Aluno de Personal</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('alunos-personal.update', $alunoPersonal->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> 
                            <strong>Aluno:</strong> {{ $alunoPersonal->nome_completo }} 
                            @if($alunoPersonal->tipo_aluno == 'matriculado')
                                - <strong>Tipo:</strong> Aluno Matriculado
                            @else
                                - <strong>Tipo:</strong> Aluno Externo
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="professor_id">Personal Trainer *</label>
                            <select name="professor_id" id="professor_id" class="form-control @error('professor_id') is-invalid @enderror" required>
                                <option value="">Selecione...</option>
                                @foreach($professores as $prof)
                                    <option value="{{ $prof->id }}" {{ old('professor_id', $alunoPersonal->professor_id) == $prof->id ? 'selected' : '' }}>
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
                            <label for="status">Status *</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="ativo" {{ old('status', $alunoPersonal->status) == 'ativo' ? 'selected' : '' }}>Ativo</option>
                                <option value="inativo" {{ old('status', $alunoPersonal->status) == 'inativo' ? 'selected' : '' }}>Inativo</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="telefone">Telefone</label>
                            <input type="text" name="telefone" id="telefone" 
                                   class="form-control @error('telefone') is-invalid @enderror" 
                                   value="{{ old('telefone', $alunoPersonal->telefone) }}">
                            @error('telefone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $alunoPersonal->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="data_vencimento">Data de Vencimento *</label>
                            <input type="date" name="data_vencimento" id="data_vencimento" 
                                   class="form-control @error('data_vencimento') is-invalid @enderror" 
                                   value="{{ old('data_vencimento', $alunoPersonal->data_vencimento->format('Y-m-d')) }}" required>
                            @error('data_vencimento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="valor_mensalidade">Valor da Mensalidade</label>
                            <input type="number" step="0.01" name="valor_mensalidade" id="valor_mensalidade" 
                                   class="form-control @error('valor_mensalidade') is-invalid @enderror" 
                                   value="{{ old('valor_mensalidade', $alunoPersonal->valor_mensalidade) }}">
                            @error('valor_mensalidade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="observacoes">Observações</label>
                    <textarea name="observacoes" id="observacoes" rows="3" 
                              class="form-control @error('observacoes') is-invalid @enderror">{{ old('observacoes', $alunoPersonal->observacoes) }}</textarea>
                    @error('observacoes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Atualizar
                    </button>
                    <a href="{{ route('alunos-personal.show', $alunoPersonal->id) }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
