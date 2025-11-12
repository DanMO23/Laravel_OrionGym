@extends('layouts.user-layout')

@section('header-user', 'Painel de Pagamentos - Personal Trainer')

@section('content')
<div class="container-fluid py-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <!-- Estatísticas -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Total de Alunos</h6>
                            <h2 class="mb-0">{{ $totalAlunos }}</h2>
                        </div>
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Pagos Este Mês</h6>
                            <h2 class="mb-0">{{ $pagosEsseMes }}</h2>
                        </div>
                        <i class="fas fa-check-circle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card bg-danger text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Atrasados</h6>
                            <h2 class="mb-0">{{ $atrasados }}</h2>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Total Recebido</h6>
                            <h2 class="mb-0">R$ {{ number_format($totalRecebido, 2, ',', '.') }}</h2>
                        </div>
                        <i class="fas fa-dollar-sign fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros e Tabela -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-money-bill-wave"></i> Controle de Pagamentos</h4>
        </div>

        <div class="card-body">
            <!-- Filtros -->
            <form action="{{ route('alunos-personal.painel-pagamentos') }}" method="GET" class="mb-4">
                <div class="row">
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
                        <select name="status_pagamento" class="form-control">
                            <option value="">Todos os Status</option>
                            <option value="pago" {{ request('status_pagamento') == 'pago' ? 'selected' : '' }}>Pago</option>
                            <option value="pendente" {{ request('status_pagamento') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                            <option value="atrasado" {{ request('status_pagamento') == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="mes" class="form-control">
                            <option value="">Todos os Meses</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('mes') == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                    </div>
                </div>
            </form>

            <!-- Tabela -->
            @if($alunos->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-2"></i>
                    <p>Nenhum registro encontrado.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Aluno</th>
                                <th>CPF</th>
                                <th>Personal</th>
                                <th>Dia Vencimento</th>
                                <th>Próximo Vencimento</th>
                                <th>Valor</th>
                                <th>Último Pagamento</th>
                                <th>Status</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alunos as $aluno)
                            <tr class="{{ $aluno->status_pagamento == 'atrasado' ? 'table-danger' : ($aluno->status_pagamento == 'pendente' ? 'table-warning' : 'table-success') }}">
                                <td><strong>{{ $aluno->nome_completo }}</strong></td>
                                <td>{{ $aluno->cpf ?: '-' }}</td>
                                <td>{{ $aluno->professor->nome_completo }}</td>
                                <td class="text-center">
                                    <span class="badge badge-info">Dia {{ $aluno->dia_vencimento }}</span>
                                </td>
                                <td>{{ $aluno->proximo_vencimento->format('d/m/Y') }}</td>
                                <td><strong>R$ {{ number_format($aluno->valor_mensalidade ?? 0, 2, ',', '.') }}</strong></td>
                                <td>
                                    @if($aluno->ultimo_pagamento)
                                        {{ $aluno->ultimo_pagamento->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">Nunca pagou</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusBadge = '';
                                        $statusText = '';
                                        switch($aluno->status_pagamento) {
                                            case 'pago':
                                                $statusBadge = 'badge-success';
                                                $statusText = 'Pago';
                                                break;
                                            case 'pendente':
                                                $statusBadge = 'badge-warning';
                                                $statusText = 'Pendente';
                                                break;
                                            case 'atrasado':
                                                $statusBadge = 'badge-danger';
                                                $statusText = 'Atrasado';
                                                break;
                                        }
                                    @endphp
                                    <span class="badge {{ $statusBadge }}">{{ $statusText }}</span>
                                </td>
                                <td class="text-center">
                                    @if($aluno->status_pagamento != 'pago')
                                        <form action="{{ route('alunos-personal.registrar-pagamento', $aluno->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Registrar Pagamento">
                                                <i class="fas fa-check"></i> Pagar
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-success"><i class="fas fa-check-circle"></i> Pago</span>
                                    @endif
                                    <a href="{{ route('alunos-personal.show', $aluno->id) }}" class="btn btn-sm btn-info" title="Ver Detalhes">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $alunos->links('pagination::bootstrap-5') }}
            @endif
        </div>
    </div>
</div>

<style>
    .opacity-50 {
        opacity: 0.5;
    }
    
    .table td, .table th {
        vertical-align: middle;
    }
</style>
@endsection
