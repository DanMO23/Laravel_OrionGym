@extends('layouts.user-layout')

@section('title', 'Detalhes do Aluno')

@section('content')
<div class="container py-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-user"></i> Detalhes do Aluno</h4>
                </div>

                <div class="card-body">
                    <!-- Informações Pessoais -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="info-group mb-3">
                                <label class="text-muted small">Nome Completo</label>
                                <p class="font-weight-bold mb-0">{{ $aluno->nome }}</p>
                            </div>
                            
                            <div class="info-group mb-3">
                                <label class="text-muted small">CPF</label>
                                <p class="font-weight-bold mb-0">{{ $aluno->cpf }}</p>
                            </div>

                            <div class="info-group mb-3">
                                <label class="text-muted small">Data de Nascimento</label>
                                <p class="font-weight-bold mb-0">{{ \Carbon\Carbon::parse($aluno->data_nascimento)->format('d/m/Y') }}</p>
                            </div>

                            <div class="info-group mb-3">
                                <label class="text-muted small">Sexo</label>
                                <p class="font-weight-bold mb-0">{{ $aluno->sexo == 'M' ? 'Masculino' : 'Feminino' }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-group mb-3">
                                <label class="text-muted small">Email</label>
                                <p class="font-weight-bold mb-0">{{ $aluno->email ?: 'Não informado' }}</p>
                            </div>

                            <div class="info-group mb-3">
                                <label class="text-muted small">Telefone</label>
                                <p class="font-weight-bold mb-0">{{ $aluno->telefone }}</p>
                            </div>

                            <div class="info-group mb-3">
                                <label class="text-muted small">Endereço</label>
                                <p class="font-weight-bold mb-0">{{ $aluno->endereco }}</p>
                            </div>

                            <div class="info-group mb-3">
                                <label class="text-muted small">Número de Matrícula</label>
                                <p class="font-weight-bold mb-0">{{ $aluno->numero_matricula }}</p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Status da Matrícula e Dias Restantes -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <label class="text-muted small d-block">Status da Matrícula</label>
                                    @php
                                        $statusClass = '';
                                        $statusText = '';
                                        switch($aluno->matricula_ativa) {
                                            case 'ativa':
                                                $statusClass = 'badge-success';
                                                $statusText = 'Ativa';
                                                break;
                                            case 'inativa':
                                                $statusClass = 'badge-secondary';
                                                $statusText = 'Inativa';
                                                break;
                                            case 'trancado':
                                                $statusClass = 'badge-warning';
                                                $statusText = 'Trancada';
                                                break;
                                            case 'bloqueado':
                                                $statusClass = 'badge-danger';
                                                $statusText = 'Bloqueada';
                                                break;
                                            default:
                                                $statusClass = 'badge-secondary';
                                                $statusText = ucfirst($aluno->matricula_ativa);
                                        }
                                    @endphp
                                    <h3 class="mb-0">
                                        <span class="badge {{ $statusClass }} p-2">{{ $statusText }}</span>
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <label class="text-muted small d-block">Dias Restantes</label>
                                    <h3 class="mb-0">
                                        <span class="badge {{ $aluno->dias_restantes > 0 ? 'badge-primary' : 'badge-danger' }} p-2">
                                            {{ $aluno->dias_restantes }} dias
                                        </span>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <a href="{{ route('alunos.edit', $aluno->id) }}" class="btn btn-primary m-1">
                            <i class="fas fa-edit"></i> Editar
                        </a>

                        <a href="{{ route('alunos.transferir.dias.form', $aluno->id) }}" class="btn btn-info m-1">
                            <i class="fas fa-exchange-alt"></i> Transferir Dias
                        </a>

                        <form action="{{ route('alunos.destroy', $aluno->id) }}" method="POST" 
                              onsubmit="return confirm('Tem certeza que deseja excluir este aluno?')" 
                              class="d-inline m-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Excluir
                            </button>
                        </form>

                        <a href="{{ route('alunos.index') }}" class="btn btn-secondary m-1">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .info-group label {
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .info-group p {
        font-size: 1rem;
        color: #333;
    }

    .gap-2 {
        gap: 0.5rem;
    }

    .card {
        border-radius: 10px;
    }

    .badge {
        font-size: 1rem;
        font-weight: 500;
    }
</style>
@endsection