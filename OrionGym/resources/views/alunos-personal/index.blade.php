@extends('layouts.user-layout')

@section('header-user', 'Alunos de Personal Trainer')

@section('content')
<div class="container py-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-user-friends"></i> Alunos de Personal</h4>
                <a href="{{ route('alunos-personal.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus"></i> Novo Aluno
                </a>
            </div>
        </div>

        <div class="card-body">
            <!-- Filtros -->
            <form action="{{ route('alunos-personal.index') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Buscar por nome..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="professor_id" class="form-control">
                            <option value="">Todos os Personal Trainers</option>
                            @foreach($professores as $prof)
                                <option value="{{ $prof->id }}" {{ request('professor_id') == $prof->id ? 'selected' : '' }}>
                                    {{ $prof->nome_completo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">Todos os Status</option>
                            <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                            <option value="inativo" {{ request('status') == 'inativo' ? 'selected' : '' }}>Inativo</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                    </div>
                </div>
            </form>

            @if($alunosPersonal->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-2"></i>
                    <p>Nenhum aluno de personal cadastrado.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Aluno</th>
                                <th>Personal Trainer</th>
                                <th>Tipo</th>
                                <th>Vencimento</th>
                                <th>Dias Restantes</th>
                                <th>Valor</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alunosPersonal as $alunoP)
                            <tr class="{{ $alunoP->vencido ? 'table-danger' : ($alunoP->dias_restantes <= 5 ? 'table-warning' : '') }}">
                                <td>{{ $alunoP->nome_completo }}</td>
                                <td>{{ $alunoP->professor->nome_completo }}</td>
                                <td>
                                    <span class="badge badge-{{ $alunoP->tipo_aluno == 'matriculado' ? 'primary' : 'secondary' }}">
                                        {{ $alunoP->tipo_aluno == 'matriculado' ? 'Matriculado' : 'Externo' }}
                                    </span>
                                </td>
                                <td>{{ $alunoP->data_vencimento->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge badge-pill badge-{{ $alunoP->dias_restantes > 5 ? 'success' : ($alunoP->dias_restantes > 0 ? 'warning' : 'danger') }}">
                                        {{ $alunoP->dias_restantes }} dias
                                    </span>
                                </td>
                                <td>R$ {{ number_format($alunoP->valor_mensalidade ?? 0, 2, ',', '.') }}</td>
                                <td>
                                    <span class="badge badge-{{ $alunoP->status == 'ativo' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($alunoP->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('alunos-personal.show', $alunoP->id) }}" 
                                       class="btn btn-sm btn-info" title="Detalhes">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('alunos-personal.edit', $alunoP->id) }}" 
                                       class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('alunos-personal.destroy', $alunoP->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Deseja remover este aluno?')" title="Remover">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $alunosPersonal->links('pagination::bootstrap-5') }}
            @endif
        </div>
    </div>
</div>
@endsection
