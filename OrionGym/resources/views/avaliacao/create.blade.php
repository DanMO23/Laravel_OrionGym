@extends('layouts.user-layout')

@section('header-user', 'Nova Avaliação Física')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-clipboard-check"></i> Nova Avaliação Física</h4>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-exclamation-triangle"></i> Atenção!</strong> Por favor, corrija os seguintes erros:
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('avaliacao.store') }}" method="POST">
                        @csrf

                        <!-- Informações Pessoais -->
                        <div class="section-title mb-3">
                            <h5 class="text-primary"><i class="fas fa-user"></i> Informações Pessoais</h5>
                            <hr>
                        </div>

                        @if(isset($aluno))
                        <!-- Preenche os dados do aluno -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nome" class="font-weight-bold">Nome da Pessoa</label>
                                    <input type="text" name="nome" id="nome" class="form-control bg-light" value="{{ $aluno->nome }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cpf" class="font-weight-bold">CPF</label>
                                    <input type="text" name="cpf" id="cpf" class="form-control bg-light" value="{{ $aluno->cpf }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefone" class="font-weight-bold">Telefone</label>
                                    <input type="text" name="telefone" id="telefone" class="form-control bg-light" value="{{ $aluno->telefone }}" readonly>
                                </div>
                            </div>
                        </div>
                        @else
                        <!-- Campos em branco caso seja uma nova avaliação -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nome" class="font-weight-bold">Nome da Pessoa <span class="text-danger">*</span></label>
                                    <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" 
                                           placeholder="Digite o nome completo" value="{{ old('nome') }}" required>
                                    @error('nome')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cpf" class="font-weight-bold">CPF <span class="text-danger">*</span></label>
                                    <input type="text" name="cpf" id="cpf" class="form-control @error('cpf') is-invalid @enderror" 
                                           placeholder="000.000.000-00" value="{{ old('cpf') }}" required>
                                    @error('cpf')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefone" class="font-weight-bold">Telefone <span class="text-danger">*</span></label>
                                    <input type="text" name="telefone" id="telefone" class="form-control @error('telefone') is-invalid @enderror" 
                                           placeholder="(00) 00000-0000" value="{{ old('telefone') }}" required>
                                    @error('telefone')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Informações da Avaliação -->
                        <div class="section-title mb-3 mt-4">
                            <h5 class="text-primary"><i class="fas fa-file-medical-alt"></i> Informações da Avaliação</h5>
                            <hr>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="avaliacao_fisica" class="font-weight-bold">Pacote</label>
                                    <input type="text" name="user" class="form-control bg-light" value="Avaliação Física" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="valor_avaliacao" class="font-weight-bold">Valor da Avaliação</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="number" step="0.01" name="valor_avaliacao" id="valor_avaliacao" 
                                               class="form-control" value="50.00" disabled>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <input type="checkbox" id="alterar_valor" name="alterar_valor" class="mr-1">
                                                <label for="alterar_valor" class="mb-0 small">Alterar</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data e Horário -->
                        <div class="section-title mb-3 mt-4">
                            <h5 class="text-primary"><i class="fas fa-calendar-alt"></i> Data e Hora da Compra</h5>
                            <hr>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="data_avaliacao" class="font-weight-bold">Data da Compra <span class="text-danger">*</span></label>
                                    <input type="date" name="data_avaliacao" id="data_avaliacao" 
                                           class="form-control @error('data_avaliacao') is-invalid @enderror" required>
                                    @error('data_avaliacao')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="horario_avaliacao" class="font-weight-bold">Hora da Compra <span class="text-danger">*</span></label>
                                    <input type="time" name="horario_avaliacao" id="horario_avaliacao" 
                                           class="form-control @error('horario_avaliacao') is-invalid @enderror" required>
                                    @error('horario_avaliacao')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Descrição do Pagamento -->
                        <div class="section-title mb-3 mt-4">
                            <h5 class="text-primary"><i class="fas fa-comment-dollar"></i> Pagamento</h5>
                            <hr>
                        </div>

                        <div class="form-group">
                            <label for="descricao_pagamento" class="font-weight-bold">Descrição do Pagamento</label>
                            <textarea name="descricao_pagamento" id="descricao_pagamento" 
                                      class="form-control" rows="3" 
                                      placeholder="Descreva o método de pagamento ou observações...">{{ old('descricao_pagamento') }}</textarea>
                        </div>

                        <!-- Botões de Ação -->
                        <div class="d-flex justify-content-center mt-4 gap-2">
                            <button type="submit" class="btn btn-primary btn-lg px-5 m-1">
                                <i class="fas fa-check"></i> Registrar Avaliação
                            </button>
                            <a href="{{ route('avaliacao.index') }}" class="btn btn-secondary btn-lg px-5 m-1">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preencher data e hora atuais automaticamente
    const hoje = new Date();
    const dataFormatada = hoje.toISOString().split('T')[0];
    document.getElementById('data_avaliacao').value = dataFormatada;

    // Preencher hora atual exata no input time
    const horaAtual = String(hoje.getHours()).padStart(2, '0');
    const minutoAtual = String(hoje.getMinutes()).padStart(2, '0');
    const horaFormatada = horaAtual + ':' + minutoAtual;
    document.getElementById('horario_avaliacao').value = horaFormatada;

    // Habilitar/desabilitar campo de valor da avaliação
    document.getElementById('alterar_valor').addEventListener('change', function() {
        document.getElementById('valor_avaliacao').disabled = !this.checked;
    });
});
</script>

<style>
.section-title h5 {
    margin-bottom: 0;
}
.section-title hr {
    margin-top: 0.5rem;
}
.card {
    border: none;
    border-radius: 10px;
}
.card-header {
    border-radius: 10px 10px 0 0 !important;
}
</style>
@endsection