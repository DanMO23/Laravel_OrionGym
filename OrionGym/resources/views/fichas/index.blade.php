@extends('layouts.user-layout')

@section('header-user', 'Fichas de Treino')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="fas fa-clipboard-list"></i> Fichas de Treino</h2>
        <a href="{{ route('fichas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nova Ficha
        </a>
    </div>

    @if($fichas->isEmpty())
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle fa-2x mb-2"></i>
            <p class="mb-0">Nenhuma ficha de treino cadastrada.</p>
        </div>
    @else
        <!-- Busca -->
        <div class="mb-4">
            <input type="text" id="searchFichas" class="form-control" placeholder="Buscar por aluno ou objetivo...">
        </div>

        <!-- Gallery View -->
        <div class="row" id="fichasGallery">
            @foreach($fichas as $ficha)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4 ficha-card" data-nome="{{ strtolower($ficha->nome_aluno) }}" data-objetivo="{{ strtolower($ficha->nome_ficha) }}">
                    <div class="card shadow-sm h-100 hover-card">
                        <div class="card-header bg-gradient-primary text-white text-center">
                            <div class="avatar-circle mx-auto mb-2">
                                <i class="fas fa-user fa-2x"></i>
                            </div>
                            <h5 class="mb-0">{{ $ficha->nome_aluno }}</h5>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <p class="text-muted mb-1"><i class="fas fa-bullseye"></i> Objetivo:</p>
                                <p class="font-weight-bold">{{ $ficha->nome_ficha }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <p class="text-muted mb-1"><i class="fas fa-calendar-alt"></i> Criada em:</p>
                                <p>{{ $ficha->created_at->format('d/m/Y') }}</p>
                            </div>

                            @if($ficha->treinos)
                                <div class="mb-3">
                                    <p class="text-muted mb-1"><i class="fas fa-dumbbell"></i> Treinos:</p>
                                    <span class="badge badge-primary badge-pill">{{ $ficha->treinos->count() }} treino(s)</span>
                                </div>
                            @endif

                            <div class="mt-auto">
                                <a href="{{ route('fichas.show', $ficha->id) }}" class="btn btn-primary btn-block">
                                    <i class="fas fa-eye"></i> Ver Ficha
                                </a>
                                <div class="btn-group btn-block mt-2" role="group">
                                    <a href="{{ route('fichas.edit', $ficha->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <a href="{{ route('fichas.imprimir', $ficha->id) }}" target="_blank" class="btn btn-success btn-sm">
                                        <i class="fas fa-print"></i> Imprimir
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginação - só aparece se houver mais de uma página -->
        @if(method_exists($fichas, 'hasPages') && $fichas->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $fichas->links('pagination::bootstrap-4') }}
            </div>
        @endif
    @endif
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .avatar-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid rgba(255, 255, 255, 0.5);
    }

    .hover-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }

    .hover-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important;
    }

    .card-body {
        background: #f8f9fa;
    }

    .badge-pill {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }

    #searchFichas {
        border-radius: 50px;
        padding: 12px 20px;
        border: 2px solid #e0e0e0;
        font-size: 1rem;
    }

    #searchFichas:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .btn-block {
        border-radius: 8px;
        font-weight: 500;
    }
</style>

<script>
    // Busca em tempo real
    document.getElementById('searchFichas').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const fichas = document.querySelectorAll('.ficha-card');

        fichas.forEach(ficha => {
            const nome = ficha.getAttribute('data-nome');
            const objetivo = ficha.getAttribute('data-objetivo');

            if (nome.includes(searchValue) || objetivo.includes(searchValue)) {
                ficha.style.display = '';
            } else {
                ficha.style.display = 'none';
            }
        });
    });
</script>
@endsection
