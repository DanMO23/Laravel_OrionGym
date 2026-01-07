@extends('layouts.user-layout')

@section('header-user')
    Editar Turma
@stop

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-primary font-weight-bold">Editar Turma: {{ $turma->nome }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('turmas.update', $turma->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="nome" class="font-weight-bold text-muted small text-uppercase">Nome da Turma / Modalidade</label>
                        <input type="text" name="nome" id="nome" class="form-control form-control-lg bg-light border-0" value="{{ $turma->nome }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dia_semana" class="font-weight-bold text-muted small text-uppercase">Dia da Semana</label>
                                <select name="dia_semana" id="dia_semana" class="form-control form-control-lg bg-light border-0" required>
                                    @foreach(['Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado', 'Domingo'] as $dia)
                                        <option value="{{ $dia }}" {{ $turma->dia_semana == $dia ? 'selected' : '' }}>{{ $dia }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="horario" class="font-weight-bold text-muted small text-uppercase">Horário</label>
                                <input type="time" name="horario" id="horario" class="form-control form-control-lg bg-light border-0" value="{{ $turma->horario }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">

                        <label for="nome_professor" class="font-weight-bold text-muted small text-uppercase">Nome do Professor Responsável</label>
                        <input type="text" name="nome_professor" id="nome_professor" class="form-control form-control-lg bg-light border-0" value="{{ $turma->nome_professor }}" required>
                    </div>

                    <div class="form-group mt-4 d-flex justify-content-between">
                         <button type="button" class="btn btn-outline-danger border-0" onclick="if(confirm('Tem certeza que deseja excluir esta turma?')) document.getElementById('delete-form').submit();">
                            <i class="fas fa-trash-alt mr-1"></i> Excluir Turma
                        </button>
                        <div>
                            <a href="{{ route('turmas.index') }}" class="btn btn-link text-muted">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">Salvar Alterações</button>
                        </div>
                    </div>
                </form>

                <form id="delete-form" action="{{ route('turmas.destroy', $turma->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>
@stop
