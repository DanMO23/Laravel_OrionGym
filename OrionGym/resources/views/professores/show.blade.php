@extends('layouts.user-layout')

@section('header-user', 'Detalhes do Professor')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-user-tie"></i> Informações do Professor</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Coluna da Foto -->
                        <div class="col-md-4 text-center">
                            @if($professor->foto)
                                <img src="{{ asset('uploads/' . $professor->foto) }}" 
                                     alt="Foto do Professor" 
                                     class="img-thumbnail mb-3 shadow" 
                                     style="max-width: 300px; border-radius: 10px;">
                            @else
                                <div class="text-muted mb-3">
                                    <i class="fas fa-user-circle" style="font-size: 150px; color: #6c757d;"></i>
                                    <p class="mt-2">Foto não disponível</p>
                                </div>
                            @endif

                            @if($professor->numero_matricula)
                                <div class="alert alert-info shadow-sm">
                                    <strong><i class="fas fa-id-badge"></i> Matrícula:</strong><br>
                                    <h3 class="mb-0 text-primary">{{ $professor->numero_matricula }}</h3>
                                </div>
                            @endif

                            @if(in_array($professor->tipo, ['personal', 'ambos']))
                                <div class="alert alert-success shadow-sm">
                                    <i class="fas fa-dumbbell"></i> <strong>Personal Trainer</strong><br>
                                    <small>{{ $professor->alunosPersonal->count() }} aluno(s) cadastrado(s)</small>
                                </div>
                            @endif
                        </div>

                        <!-- Coluna dos Dados -->
                        <div class="col-md-8">
                            <h5 class="border-bottom pb-2 mb-3 text-primary">
                                <i class="fas fa-user"></i> Dados Pessoais
                            </h5>
                            
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong><i class="fas fa-user text-muted"></i> Nome:</strong><br>
                                        <span class="ml-4">{{ $professor->nome_completo }}</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong><i class="fas fa-venus-mars text-muted"></i> Sexo:</strong><br>
                                        <span class="ml-4">{{ $professor->sexo == 'M' ? 'Masculino' : 'Feminino' }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong><i class="fas fa-envelope text-muted"></i> Email:</strong><br>
                                        <span class="ml-4">{{ $professor->email ?: 'Não informado' }}</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong><i class="fas fa-phone text-muted"></i> Telefone:</strong><br>
                                        <span class="ml-4">{{ $professor->telefone }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong><i class="fas fa-briefcase text-muted"></i> Cargo:</strong><br>
                                        <span class="ml-4">{{ $professor->cargo }}</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong><i class="fas fa-dumbbell text-muted"></i> Tipo:</strong><br>
                                        <span class="ml-4">
                                            @php
                                                $tipoBadge = '';
                                                $tipoTexto = '';
                                                switch($professor->tipo) {
                                                    case 'integral':
                                                        $tipoBadge = 'badge-info';
                                                        $tipoTexto = 'Professor Integral';
                                                        break;
                                                    case 'personal':
                                                        $tipoBadge = 'badge-success';
                                                        $tipoTexto = 'Personal Trainer';
                                                        break;
                                                    case 'ambos':
                                                        $tipoBadge = 'badge-primary';
                                                        $tipoTexto = 'Integral e Personal';
                                                        break;
                                                    default:
                                                        $tipoBadge = 'badge-secondary';
                                                        $tipoTexto = ucfirst($professor->tipo);
                                                }
                                            @endphp
                                            <span class="badge {{ $tipoBadge }}">{{ $tipoTexto }}</span>
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <p class="mb-2">
                                        <strong><i class="fas fa-map-marker-alt text-muted"></i> Endereço:</strong><br>
                                        <span class="ml-4">{{ $professor->endereco ?: 'Não informado' }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(in_array($professor->tipo, ['personal', 'ambos']))
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="border-bottom pb-2 mb-3 text-primary">
                                    <i class="fas fa-user-friends"></i> Alunos de Personal 
                                    <span class="badge badge-primary ml-2">{{ $professor->alunosPersonal->count() }}</span>
                                </h5>

                                @if($professor->alunosPersonal->isEmpty())
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> Nenhum aluno cadastrado para este personal trainer.
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th><i class="fas fa-user"></i> Aluno</th>
                                                    <th><i class="fas fa-tag"></i> Tipo</th>
                                                    <th><i class="fas fa-calendar-alt"></i> Vencimento</th>
                                                    <th><i class="fas fa-hourglass-half"></i> Dias</th>
                                                    <th><i class="fas fa-flag"></i> Status</th>
                                                    <th><i class="fas fa-cog"></i> Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($professor->alunosPersonal as $alunoP)
                                                <tr class="{{ $alunoP->vencido ? 'table-danger' : ($alunoP->dias_restantes <= 5 ? 'table-warning' : '') }}">
                                                    <td>{{ $alunoP->nome_completo }}</td>
                                                    <td>
                                                        <span class="badge badge-{{ $alunoP->tipo_aluno == 'matriculado' ? 'primary' : 'secondary' }} badge-sm">
                                                            {{ $alunoP->tipo_aluno == 'matriculado' ? 'Matriculado' : 'Externo' }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $alunoP->data_vencimento->format('d/m/Y') }}</td>
                                                    <td>
                                                        <span class="badge badge-pill badge-{{ $alunoP->dias_restantes > 5 ? 'success' : ($alunoP->dias_restantes > 0 ? 'warning' : 'danger') }}">
                                                            {{ $alunoP->dias_restantes }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-{{ $alunoP->status == 'ativo' ? 'success' : 'secondary' }}">
                                                            {{ ucfirst($alunoP->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('alunos-personal.show', $alunoP->id) }}" 
                                                           class="btn btn-sm btn-info"
                                                           title="Ver detalhes">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="mt-3">
                                        <a href="{{ route('alunos-personal.index', ['professor_id' => $professor->id]) }}" 
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-list"></i> Ver Todos os Alunos
                                        </a>
                                        <a href="{{ route('alunos-personal.create') }}?professor_id={{ $professor->id }}" 
                                           class="btn btn-success btn-sm">
                                            <i class="fas fa-plus"></i> Adicionar Aluno
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <hr class="my-4">
                    <div class="mt-4">
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('professores.edit', $professor->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                        @endif
                        <a href="{{ route('professores.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
        border: none;
    }
    
    .img-thumbnail {
        border: 3px solid #e9ecef;
    }

    .table td, .table th {
        vertical-align: middle;
    }

    .badge-sm {
        font-size: 0.75rem;
    }
</style>
@endsection
