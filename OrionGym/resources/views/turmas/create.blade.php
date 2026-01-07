@extends('layouts.user-layout')

@section('header-user')
    Nova Turma
@stop

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-primary font-weight-bold">Cadastrar Nova Turma</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('turmas.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nome" class="font-weight-bold text-muted small text-uppercase">Nome da Turma / Modalidade</label>
                        <input type="text" name="nome" id="nome" class="form-control form-control-lg bg-light border-0" placeholder="Ex: Treino Funcional, Zumba..." required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dia_semana" class="font-weight-bold text-muted small text-uppercase">Dia da Semana</label>
                                <select name="dia_semana" id="dia_semana" class="form-control form-control-lg bg-light border-0" required>
                                    <option value="">Selecione...</option>
                                    <option value="Segunda-feira">Segunda-feira</option>
                                    <option value="Terça-feira">Terça-feira</option>
                                    <option value="Quarta-feira">Quarta-feira</option>
                                    <option value="Quinta-feira">Quinta-feira</option>
                                    <option value="Sexta-feira">Sexta-feira</option>
                                    <option value="Sábado">Sábado</option>
                                    <option value="Domingo">Domingo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="horario" class="font-weight-bold text-muted small text-uppercase">Horário</label>
                                <input type="time" name="horario" id="horario" class="form-control form-control-lg bg-light border-0" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">

                        <label for="nome_professor" class="font-weight-bold text-muted small text-uppercase">Nome do Professor Responsável</label>
                        <input type="text" name="nome_professor" id="nome_professor" class="form-control form-control-lg bg-light border-0" placeholder="Ex: João Silva" required>
                    </div>

                    <div class="form-group mt-4 text-right">
                        <a href="{{ route('turmas.index') }}" class="btn btn-link text-muted">Cancelar</a>
                        <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">Salvar Turma</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
