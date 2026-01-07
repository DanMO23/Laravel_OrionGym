@extends('layouts.user-layout')

@section('header-user')
    Detalhes da Turma
@stop

@section('content')
<div class="row">
    <!-- Class Info and Add Student -->
    <div class="col-md-5 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h3 class="font-weight-bold text-primary mb-1">{{ $turma->nome }}</h3>
                <p class="text-muted"><i class="far fa-user mr-1"></i> Prof. {{ $turma->nome_professor }}</p>
                
                <div class="d-flex align-items-center mb-4">
                    <span class="badge badge-primary px-3 py-2 mr-2 lead text-md">{{ $turma->dia_semana }}</span>
                    <span class="text-secondary font-weight-bold h5 mb-0"><i class="far fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($turma->horario)->format('H:i') }}</span>
                </div>

                <hr class="my-4">

                <h5 class="font-weight-bold mb-3">Adicionar Aluno</h5>
                <form action="{{ route('turmas.addAluno', $turma->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="nome_aluno" class="form-control form-control-lg bg-light border-0" placeholder="Nome do aluno..." required>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <small class="form-text text-muted ml-1">Digite o nome do aluno para adicionar à lista.</small>
                    </div>
                </form>

                <div class="mt-5">
                    <a href="{{ route('turmas.index') }}" class="btn btn-outline-secondary btn-block rounded-pill">
                        <i class="fas fa-arrow-left mr-2"></i> Voltar para Turmas
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Student List -->
    <div class="col-md-7 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 border-bottom-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold text-secondary">Alunos Matriculados <span class="badge badge-light ml-2">{{ $turma->alunos->count() }}</span></h5>
                    <button class="btn btn-link text-muted btn-sm" onclick="window.print()"><i class="fas fa-print"></i> Imprimir</button>
                </div>
            </div>
            <div class="card-body p-0">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mx-3 my-2" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="pl-4 border-0">Nome do Aluno</th>
                                <th class="text-right pr-4 border-0">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($turma->alunos as $aluno)
                                <tr>
                                    <td class="pl-4 align-middle font-weight-medium">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-primary text-white mr-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; border-radius: 50%;">
                                                {{ strtoupper(substr($aluno->nome_aluno, 0, 1)) }}
                                            </div>
                                            {{ $aluno->nome_aluno }}
                                        </div>
                                    </td>
                                    <td class="text-right pr-4 align-middle">
                                        <form action="{{ route('turmas.removeAluno', $aluno->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm border-0 rounded-circle" title="Remover aluno" onclick="return confirm('Remover {{ $aluno->nome_aluno }} desta turma?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center py-5 text-muted">
                                        <i class="far fa-sad-tear fa-2x mb-2 d-block opacity-50"></i>
                                        Nenhum aluno cadastrado nesta turma ainda.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
