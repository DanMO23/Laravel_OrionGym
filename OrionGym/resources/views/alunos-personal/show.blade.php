@extends('layouts.user-layout')

@section('header-user', 'Detalhes do Aluno de Personal')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-user"></i> Informações do Aluno</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="border-bottom pb-2 mb-3">Dados Pessoais</h5>
                    <p><strong><i class="fas fa-user"></i> Nome:</strong> {{ $alunoPersonal->nome_completo }}</p>
                    <p><strong><i class="fas fa-id-card"></i> CPF:</strong> {{ $alunoPersonal->cpf ?: 'Não informado' }}</p>
                    <p>
                        <strong><i class="fas fa-tag"></i> Tipo:</strong> 
                        <span class="badge badge-{{ $alunoPersonal->tipo_aluno == 'matriculado' ? 'primary' : 'secondary' }}">
                            {{ $alunoPersonal->tipo_aluno == 'matriculado' ? 'Aluno Matriculado' : 'Aluno Externo' }}
                        </span>
                    </p>
                    @if($alunoPersonal->tipo_aluno == 'matriculado' && $alunoPersonal->aluno)
                        <p><strong><i class="fas fa-id-badge"></i> Matrícula Academia:</strong> {{ $alunoPersonal->aluno->numero_matricula }}</p>
                    @endif
                </div>

                <div class="col-md-6">
                    <h5 class="border-bottom pb-2 mb-3">Informações do Personal</h5>
                    @if($alunoPersonal->professor)
                        <p><strong><i class="fas fa-dumbbell"></i> Personal Trainer:</strong> {{ $alunoPersonal->professor->nome_completo }}</p>
                        @if($alunoPersonal->professor->numero_matricula)
                            <p><strong><i class="fas fa-id-badge"></i> Matrícula Personal:</strong> {{ $alunoPersonal->professor->numero_matricula }}</p>
                        @endif
                        <p><strong><i class="fas fa-phone"></i> Contato Personal:</strong> {{ $alunoPersonal->professor->telefone }}</p>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Professor não encontrado ou foi removido.
                        </div>
                    @endif
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <h5 class="border-bottom pb-2 mb-3">Informações Financeiras</h5>
                    <p><strong><i class="fas fa-calendar"></i> Dia de Vencimento Fixo:</strong> 
                        <span class="badge badge-info">Todo dia {{ $alunoPersonal->dia_vencimento }}</span>
                    </p>
                    <p><strong><i class="fas fa-calendar-alt"></i> Próximo Vencimento:</strong> 
                        <span class="badge badge-{{ $alunoPersonal->vencido ? 'danger' : ($alunoPersonal->dias_restantes <= 5 ? 'warning' : 'success') }}">
                            {{ $alunoPersonal->proximo_vencimento->format('d/m/Y') }}
                        </span>
                    </p>
                    <p><strong><i class="fas fa-hourglass-half"></i> Dias Restantes:</strong> 
                        <span class="badge badge-pill badge-{{ $alunoPersonal->dias_restantes > 5 ? 'success' : ($alunoPersonal->dias_restantes > 0 ? 'warning' : 'danger') }}">
                            {{ $alunoPersonal->dias_restantes }} dias
                        </span>
                    </p>
                    <p><strong><i class="fas fa-money-bill-wave"></i> Valor Mensalidade:</strong> 
                        R$ {{ number_format($alunoPersonal->valor_mensalidade ?? 0, 2, ',', '.') }}
                    </p>
                    <p>
                        <strong><i class="fas fa-flag"></i> Status:</strong> 
                        <span class="badge badge-{{ $alunoPersonal->status == 'ativo' ? 'success' : 'secondary' }}">
                            {{ ucfirst($alunoPersonal->status) }}
                        </span>
                    </p>
                    <p>
                        <strong><i class="fas fa-check-circle"></i> Status Pagamento:</strong> 
                        @php
                            $statusBadge = '';
                            $statusText = '';
                            switch($alunoPersonal->status_pagamento) {
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
                    </p>
                </div>

                <div class="col-md-6">
                    <h5 class="border-bottom pb-2 mb-3">Histórico de Pagamentos</h5>
                    @if($alunoPersonal->ultimo_pagamento)
                        <p><strong><i class="fas fa-calendar-check"></i> Último Pagamento:</strong> 
                            {{ $alunoPersonal->ultimo_pagamento->format('d/m/Y') }}
                        </p>
                    @else
                        <p class="text-muted">Nenhum pagamento registrado ainda.</p>
                    @endif

                    <div class="mt-3">
                        @if($alunoPersonal->status_pagamento != 'pago')
                            <form action="{{ route('alunos-personal.registrar-pagamento', $alunoPersonal->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fas fa-check"></i> Registrar Pagamento
                                </button>
                            </form>
                        @else
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i> Pagamento em dia!
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if($alunoPersonal->observacoes)
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="border-bottom pb-2 mb-3">Observações</h5>
                        <div class="bg-light p-3 rounded">
                            {{ $alunoPersonal->observacoes }}
                        </div>
                    </div>
                </div>
            @endif

            <hr>

            <div class="row">
                <div class="col-md-12">
                    <h5 class="border-bottom pb-2 mb-3">Dados do Registro</h5>
                    <p><strong><i class="fas fa-calendar-plus"></i> Data de Cadastro:</strong> {{ $alunoPersonal->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong><i class="fas fa-calendar-check"></i> Última Atualização:</strong> {{ $alunoPersonal->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('alunos-personal.edit', $alunoPersonal->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('alunos-personal.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
