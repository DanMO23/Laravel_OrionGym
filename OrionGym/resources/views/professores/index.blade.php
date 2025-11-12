@extends('layouts.user-layout')

@section('header-user', 'Lista de Professores')

@section('content')
<div class="container py-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h4 class="mb-0"><i class="fas fa-chalkboard-teacher"></i> Professores</h4>
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('professores.create') }}" class="btn btn-light btn-sm mt-2 mt-md-0">
                        <i class="fas fa-plus"></i> Novo Professor
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body">
            @if($professores->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-2"></i>
                    <p class="mb-0">Nenhum professor encontrado.</p>
                </div>
            @else
                <!-- Filtros de busca -->
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar por nome, email ou telefone...">
                        </div>
                        <div class="col-md-3">
                            <select id="filterTipo" class="form-control">
                                <option value="">Todos os Tipos</option>
                                <option value="integral">Professor Integral</option>
                                <option value="personal">Personal Trainer</option>
                                <option value="ambos">Ambos</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="professoresTable">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 100px;"><i class="fas fa-image"></i> Foto</th>
                                <th><i class="fas fa-id-badge"></i> Matrícula</th>
                                <th><i class="fas fa-user"></i> Nome</th>
                                <th><i class="fas fa-envelope"></i> Email</th>
                                <th><i class="fas fa-phone"></i> Telefone</th>
                                <th><i class="fas fa-briefcase"></i> Cargo</th>
                                <th><i class="fas fa-dumbbell"></i> Tipo</th>
                                <th><i class="fas fa-user-friends"></i> Alunos</th>
                                <th class="text-center" style="width: 150px;"><i class="fas fa-cog"></i> Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($professores as $professor)
                            <tr data-tipo="{{ $professor->tipo }}">
                                <td>
                                    @if($professor->foto)
                                        <img src="{{ asset('uploads/' . $professor->foto) }}" 
                                             alt="Foto do Professor" 
                                             class="img-thumbnail shadow-sm" 
                                             style="max-width: 70px; max-height: 70px; object-fit: cover; border-radius: 8px;">
                                    @else
                                        <div class="text-center text-muted" style="width: 70px;">
                                            <i class="fas fa-user-circle fa-3x"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($professor->numero_matricula)
                                        <span class="badge badge-primary badge-lg">{{ $professor->numero_matricula }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td><strong>{{ $professor->nome_completo }}</strong></td>
                                <td>{{ $professor->email ?: '-' }}</td>
                                <td>{{ $professor->telefone }}</td>
                                <td>{{ $professor->cargo }}</td>
                                <td>
                                    @php
                                        $tipoBadge = '';
                                        $tipoTexto = '';
                                        switch($professor->tipo) {
                                            case 'integral':
                                                $tipoBadge = 'badge-info';
                                                $tipoTexto = 'Integral';
                                                break;
                                            case 'personal':
                                                $tipoBadge = 'badge-success';
                                                $tipoTexto = 'Personal';
                                                break;
                                            case 'ambos':
                                                $tipoBadge = 'badge-primary';
                                                $tipoTexto = 'Ambos';
                                                break;
                                            default:
                                                $tipoBadge = 'badge-secondary';
                                                $tipoTexto = ucfirst($professor->tipo);
                                        }
                                    @endphp
                                    <span class="badge {{ $tipoBadge }}">{{ $tipoTexto }}</span>
                                </td>
                                <td class="text-center">
                                    @if(in_array($professor->tipo, ['personal', 'ambos']))
                                        <span class="badge badge-pill badge-{{ $professor->alunosPersonal->count() > 0 ? 'success' : 'secondary' }}">
                                            {{ $professor->alunosPersonal->count() }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('professores.show', $professor->id) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Detalhes">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(auth()->user()->hasRole('admin'))
                                            <a href="{{ route('professores.edit', $professor->id) }}" 
                                               class="btn btn-sm btn-warning" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    data-toggle="modal" 
                                                    data-target="#deleteModal{{ $professor->id }}"
                                                    title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal de Confirmação de Exclusão -->
                            @if(auth()->user()->hasRole('admin'))
                            <div class="modal fade" id="deleteModal{{ $professor->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">
                                                <i class="fas fa-exclamation-triangle"></i> Confirmar Exclusão
                                            </h5>
                                            <button type="button" class="close text-white" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <i class="fas fa-user-times fa-3x text-danger mb-3"></i>
                                            <p>Tem certeza que deseja excluir o professor:</p>
                                            <p class="font-weight-bold">{{ $professor->nome_completo }}?</p>
                                            @if(in_array($professor->tipo, ['personal', 'ambos']) && $professor->alunosPersonal->count() > 0)
                                                <div class="alert alert-warning">
                                                    <i class="fas fa-exclamation-circle"></i> 
                                                    Este professor possui {{ $professor->alunosPersonal->count() }} aluno(s) de personal cadastrado(s).
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                <i class="fas fa-times"></i> Cancelar
                                            </button>
                                            <form action="{{ route('professores.destroy', $professor->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i> Confirmar Exclusão
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Estatísticas -->
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="card bg-info text-white shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-users fa-2x mb-2"></i>
                                <h5>{{ $professores->count() }}</h5>
                                <small>Total de Professores</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-dumbbell fa-2x mb-2"></i>
                                <h5>{{ $professores->whereIn('tipo', ['personal', 'ambos'])->count() }}</h5>
                                <small>Personal Trainers</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-primary text-white shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-chalkboard-teacher fa-2x mb-2"></i>
                                <h5>{{ $professores->where('tipo', 'integral')->count() }}</h5>
                                <small>Professores Integrais</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-user-friends fa-2x mb-2"></i>
                                <h5>{{ $professores->sum(function($p) { return $p->alunosPersonal->count(); }) }}</h5>
                                <small>Alunos de Personal</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .table td {
        vertical-align: middle;
    }

    .badge-lg {
        font-size: 0.9rem;
        padding: 0.5rem 0.75rem;
    }

    .img-thumbnail {
        border: 2px solid #e9ecef;
    }

    .btn-group .btn {
        margin: 0 2px;
    }

    .card {
        border-radius: 10px;
    }
</style>

<script>
    // Busca em tempo real
    document.getElementById('searchInput').addEventListener('keyup', function() {
        filterTable();
    });

    document.getElementById('filterTipo').addEventListener('change', function() {
        filterTable();
    });

    function filterTable() {
        const searchValue = document.getElementById('searchInput').value.toLowerCase();
        const tipoValue = document.getElementById('filterTipo').value;
        const table = document.getElementById('professoresTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const nome = row.cells[2].textContent.toLowerCase();
            const email = row.cells[3].textContent.toLowerCase();
            const telefone = row.cells[4].textContent.toLowerCase();
            const tipo = row.getAttribute('data-tipo');

            const matchSearch = nome.includes(searchValue) || email.includes(searchValue) || telefone.includes(searchValue);
            const matchTipo = tipoValue === '' || tipo === tipoValue;

            if (matchSearch && matchTipo) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    }
</script>
@endsection
