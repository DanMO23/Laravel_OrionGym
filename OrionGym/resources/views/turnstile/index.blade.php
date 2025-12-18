@extends('layouts.user-layout')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Gerenciamento de Catraca</h1>
        </div>
    </div>

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Monitoramento de Catraca</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-12 d-flex justify-content-end align-items-center">
                    <form action="{{ route('turnstile.open') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-door-open mr-2"></i> Liberar Acesso
                        </button>
                    </form>
                </div>
            </div>

            <div class="row">
                <!-- Pooling Log (Comandos) -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h3 class="card-title">Pooling Log (Comandos)</h3>
                        </div>
                        <div class="card-body p-0 table-responsive" style="height: 400px;">
                            <table class="table table-sm table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tipo</th>
                                        <th>Status</th>
                                        <th>Criado em</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($turnstileCommands as $cmd)
                                        <tr>
                                            <td>{{ $cmd->id }}</td>
                                            <td>{{ $cmd->type }}</td>
                                            <td>
                                                @if($cmd->status == 'pending')
                                                    <span class="badge badge-warning">Pendente</span>
                                                @elseif($cmd->status == 'completed')
                                                    <span class="badge badge-success">Concluído</span>
                                                @else
                                                    <span class="badge badge-danger">Falha</span>
                                                @endif
                                            </td>
                                            <td>{{ $cmd->created_at->format('H:i:s') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center">Sem comandos recentes</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Access Log (Eventos) -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <h3 class="card-title">Logs de Acesso (Eventos)</h3>
                        </div>
                        <div class="card-body p-0 table-responsive" style="height: 400px;">
                            <table class="table table-sm table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Evento</th>
                                        <th>Usuário</th>
                                        <th>Direção</th>
                                        <th>Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($turnstileEvents as $evt)
                                        <tr>
                                            <td>
                                                @if($evt->success)
                                                    <span class="badge badge-success">Sucesso</span>
                                                @else
                                                    <span class="badge badge-danger">Negado</span>
                                                @endif
                                            </td>
                                            <td>{{ $evt->user_name ?? 'Desconhecido' }}</td>
                                            <td>
                                                @if($evt->direction == 'entry')
                                                    <i class="fas fa-sign-in-alt text-success"></i> Entrada
                                                @else
                                                    <i class="fas fa-sign-out-alt text-danger"></i> Saída
                                                @endif
                                            </td>
                                            <td>{{ $evt->timestamp->format('H:i:s') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center">Sem eventos recentes</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
