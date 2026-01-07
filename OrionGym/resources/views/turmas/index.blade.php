@extends('layouts.user-layout')

@section('header-user')
    Treino Funcional / Dança
@stop

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-primary font-weight-bold">Turmas Disponíveis</h5>
            <a href="{{ route('turmas.create') }}" class="btn btn-primary btn-sm px-4 rounded-pill">
                <i class="fas fa-plus mr-2"></i> Nova Turma
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            @forelse($turmas as $turma)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm rounded-lg hover-card" style="transition: transform 0.2s;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="badge badge-pill badge-info px-3 py-1">{{ $turma->dia_semana }}</span>
                                <small class="text-muted"><i class="far fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($turma->horario)->format('H:i') }}</small>
                            </div>
                            <h4 class="card-title font-weight-bold mb-2">{{ $turma->nome }}</h4>
                            <p class="card-text text-muted mb-3">
                                <i class="fas fa-chalkboard-teacher mr-1"></i> {{ $turma->nome_professor }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="text-secondary small"><i class="fas fa-users mr-1"></i> {{ $turma->alunos->count() }} Alunos</span>
                                <div>
                                    <a href="{{ route('turmas.show', $turma->id) }}" class="btn btn-outline-primary btn-sm rounded-pill mr-1">Gerenciar</a>
                                    <a href="{{ route('turmas.edit', $turma->id) }}" class="btn btn-outline-secondary btn-sm rounded-circle"><i class="fas fa-pen"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <img src="https://via.placeholder.com/150?text=Nada+Encontrado" alt="Empty" class="mb-3 opacity-50" style="max-width: 150px; opacity: 0.5;">
                    <p class="text-muted">Nenhuma turma cadastrada ainda.</p>
                    <a href="{{ route('turmas.create') }}" class="btn btn-link">Cadastrar primeira turma</a>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
@stop
