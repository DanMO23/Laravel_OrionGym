@extends('layouts.user-layout')

@section('title', 'Alunos Vencidos - Dança')

@section('content')
<div class="container py-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Header -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-gradient-warning text-dark">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h4 class="mb-0 font-weight-bold">
                    <i class="fas fa-music"></i> Alunos Vencidos — Dança
                </h4>
                <div class="mt-2 mt-md-0">
                    <a href="{{ route('alunos.vencidos') }}" class="btn btn-dark btn-sm">
                        <i class="fas fa-arrow-left"></i> Todos os Vencidos
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Cards -->
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 stat-card stat-total">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center mr-3">
                        <i class="fas fa-music fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="mb-0 font-weight-bold">{{ $totalDanca }}</h2>
                        <p class="mb-0 text-muted">Total Vencidos Dança</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 stat-card stat-contato">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center mr-3">
                        <i class="fab fa-whatsapp fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="mb-0 font-weight-bold text-success">{{ $totalDanca }}</h2>
                        <p class="mb-0 text-muted">Para Contatar</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 stat-card stat-inativos">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mr-3">
                        <i class="fas fa-ban fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="mb-0 font-weight-bold text-secondary">{{ $inativos }}</h2>
                        <p class="mb-0 text-muted">Matrículas Inativas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Busca -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-3">
            <form action="{{ route('alunos.vencidos.danca') }}" method="GET">
                <div class="input-group search-bar-danca">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-warning border-0 text-dark">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                    <input type="text" 
                           name="search" 
                           id="searchInputDanca"
                           class="form-control border-0 shadow-none" 
                           placeholder="Pesquisar por nome, matrícula ou telefone..."
                           value="{{ $search }}"
                           autofocus>
                    @if($search)
                        <div class="input-group-append">
                            <a href="{{ route('alunos.vencidos.danca') }}" class="btn btn-outline-secondary border-0" title="Limpar busca">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </form>
            @if($search)
                <small class="text-muted mt-2 d-block">
                    <i class="fas fa-info-circle"></i> 
                    Resultados para: <strong>"{{ $search }}"</strong>
                </small>
            @endif
        </div>
    </div>

    @if ($alunosVencidos->isEmpty())
        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">
                <i class="fas fa-music fa-4x text-warning mb-3" style="opacity: 0.5;"></i>
                <h5 class="text-muted">Nenhum aluno vencido de Dança encontrado</h5>
                @if($search)
                    <p class="text-muted">Nenhum resultado para "{{ $search }}".</p>
                    <a href="{{ route('alunos.vencidos.danca') }}" class="btn btn-warning btn-sm mt-2">
                        <i class="fas fa-arrow-left"></i> Ver todos
                    </a>
                @else
                    <p class="text-muted mb-0">Não há alunos com pacotes de Dança vencidos no momento.</p>
                @endif
            </div>
        </div>
    @else
        <!-- Agrupamento por Pacote -->
        @foreach ($pacotesDanca as $nomePacote => $alunosDoPacote)
        <div class="card shadow-sm border-0 mb-4 pacote-card">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1 font-weight-bold text-dark">
                            <span class="pacote-badge mr-2">
                                <i class="fas fa-music"></i>
                            </span>
                            {{ $nomePacote }}
                        </h5>
                        <small class="text-muted">
                            <i class="fas fa-users"></i> {{ $alunosDoPacote->count() }} aluno(s) vencido(s)
                        </small>
                    </div>
                    <span class="badge badge-warning badge-pill px-3 py-2 font-weight-bold">
                        {{ $alunosDoPacote->count() }}
                    </span>
                </div>
            </div>
            <div class="card-body pt-2">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="text-muted" style="font-size: 0.85rem;">
                                <th class="border-0 pb-3"><i class="fas fa-id-card"></i> Matrícula</th>
                                <th class="border-0 pb-3"><i class="fas fa-user"></i> Nome</th>
                                <th class="border-0 pb-3"><i class="fas fa-phone"></i> Telefone</th>
                                <th class="border-0 pb-3"><i class="fas fa-money-bill-wave"></i> Valor Pago</th>
                                <th class="border-0 pb-3"><i class="fas fa-calendar"></i> Data Compra</th>
                                <th class="border-0 pb-3"><i class="fas fa-calendar-times"></i> Vencimento</th>
                                <th class="border-0 pb-3 text-center"><i class="fab fa-whatsapp"></i> Contato</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alunosDoPacote as $aluno)
                            <tr class="aluno-row">
                                <td>
                                    <span class="font-weight-bold text-dark">{{ $aluno->numero_matricula }}</span>
                                </td>
                                <td>
                                    <span class="font-weight-bold">{{ $aluno->nome }}</span>
                                </td>
                                <td>
                                    <a href="https://wa.me/55{{ preg_replace('/\D/', '', $aluno->telefone) }}" 
                                       target="_blank" class="text-success text-decoration-none"
                                       title="Enviar WhatsApp">
                                        <i class="fab fa-whatsapp"></i> {{ $aluno->telefone }}
                                    </a>
                                </td>
                                <td>
                                    @if($aluno->ultimaCompra)
                                        <span class="font-weight-bold text-success">
                                            R$ {{ number_format($aluno->ultimaCompra->valor_pacote ?? $aluno->ultimaCompra->pacote->valor ?? 0, 2, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($aluno->ultimaCompra)
                                        <span class="text-muted">
                                            {{ $aluno->ultimaCompra->created_at->format('d/m/Y') }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-danger font-weight-bold">
                                        {{ $aluno->created_at->format('d/m/Y') }}
                                    </span>
                                    <br>
                                    <small class="text-muted">{{ $aluno->created_at->diffForHumans() }}</small>
                                </td>
                                <td class="text-center">
                                    @php
                                        $pacoteNome = $aluno->ultimaCompra?->pacote?->nome_pacote ?? 'Dan' . chr(0xC3) . chr(0xA7) . 'a';
                                        $texto  = "Ol" . mb_chr(0xE1) . ", {$aluno->nome}!\n\n";
                                        $texto .= "Tudo bem? Aqui " . mb_chr(0xE9) . " da *Academia Orion*!\n\n";
                                        $texto .= "Passando para avisar que seu pacote *{$pacoteNome}* venceu.\n\n";
                                        $texto .= "Queremos muito te ver de volta! Que tal renovar seu plano e continuar arrasando nas aulas?\n\n";
                                        $texto .= "Entre em contato conosco para conferir as condi" . mb_chr(0xE7) . mb_chr(0xF5) . "es especiais que preparamos para voc" . mb_chr(0xEA) . "!\n\n";
                                        $texto .= "Aguardamos seu retorno!";
                                        $mensagem = rawurlencode($texto);
                                        $telefone = preg_replace('/\D/', '', $aluno->telefone);
                                    @endphp
                                    <div class="d-flex flex-wrap justify-content-center">
                                        <a href="https://wa.me/55{{ $telefone }}?text={{ $mensagem }}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-whatsapp m-1"
                                           title="Enviar mensagem no WhatsApp">
                                            <i class="fab fa-whatsapp"></i> Contatar
                                        </a>
                                        <a href="{{ route('alunos.show', $aluno->aluno_id) }}" 
                                           class="btn btn-sm btn-outline-info m-1"
                                           title="Ver Detalhes">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Dica -->
        <div class="card shadow-sm border-0 mt-2 border-left-success" style="border-left: 4px solid #25d366 !important;">
            <div class="card-body py-3">
                <div class="d-flex align-items-center">
                    <i class="fab fa-whatsapp text-success fa-lg mr-3"></i>
                    <div>
                        <strong class="text-dark">Dica:</strong>
                        <span class="text-muted">Clique no botão <span class="badge badge-success"><i class="fab fa-whatsapp"></i> Contatar</span> para enviar uma mensagem pronta convidando o aluno a renovar o pacote de dança!</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>



<style>
    .stat-card {
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        min-width: 60px;
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
    }

    .search-bar-danca {
        background: #f8f9fa;
        border-radius: 50px;
        overflow: hidden;
    }

    .search-bar-danca .form-control {
        padding: 0.8rem 1rem;
        font-size: 1rem;
        background: transparent;
    }

    .search-bar-danca .input-group-text {
        padding: 0.8rem 1rem;
    }

    .pacote-card {
        border-radius: 12px;
        overflow: hidden;
        transition: box-shadow 0.2s ease;
    }

    .pacote-card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.08) !important;
    }

    .pacote-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #ffc107, #ff9800);
        color: #fff;
        border-radius: 8px;
        font-size: 0.85rem;
    }

    .aluno-row {
        transition: background-color 0.15s ease;
    }

    .aluno-row:hover {
        background-color: #fffbf0 !important;
    }

    .aluno-row td {
        vertical-align: middle;
        padding: 0.85rem 0.75rem;
        border-bottom: 1px solid #f0f0f0;
        border-top: none;
    }

    .table thead th {
        font-weight: 600;
        border-top: none;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .btn-whatsapp {
        background: #25d366;
        color: #fff;
        border: none;
        border-radius: 20px;
        padding: 0.35rem 0.9rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-whatsapp:hover {
        background: #1da851;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
    }

    .btn-whatsapp:active {
        transform: translateY(0);
    }

    @media (max-width: 768px) {
        .stat-icon {
            width: 45px;
            height: 45px;
            min-width: 45px;
        }

        .stat-icon i {
            font-size: 1.2rem !important;
        }

        .table th, .table td {
            font-size: 0.8rem;
            padding: 0.5rem 0.4rem;
        }

        .btn-sm {
            padding: 0.2rem 0.4rem;
            font-size: 0.7rem;
        }
    }
</style>

<!-- Scripts do Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    let searchTimeout;
    document.getElementById('searchInputDanca').addEventListener('keyup', function(e) {
        clearTimeout(searchTimeout);
        if (e.key !== 'Enter') {
            searchTimeout = setTimeout(() => {
                this.form.submit();
            }, 500);
        }
    });
</script>
@endsection
