@extends('layouts.user-layout')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-shopping-cart"></i> Comprar Pacote</h4>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Atenção!</strong> Por favor, corrija os seguintes erros:
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

                    <form action="{{ route('compra.store') }}" method="POST">
                        @csrf

                        <!-- Seleção de Aluno e Pacote -->
                        <div class="section-title mb-3">
                            <h5 class="text-primary"><i class="fas fa-user-check"></i> Informações da Compra</h5>
                            <hr>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="aluno" class="font-weight-bold">Selecione o Aluno <span class="text-danger">*</span></label>
                                    <select name="aluno" id="aluno" class="form-control @error('aluno') is-invalid @enderror" required>
                                        <option value="">Escolha um aluno...</option>
                                        @foreach($alunos as $aluno)
                                            <option value="{{ $aluno->id }}" {{ old('aluno') == $aluno->id ? 'selected' : '' }}>
                                                {{ $aluno->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('aluno')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pacote" class="font-weight-bold">Selecione o Pacote <span class="text-danger">*</span></label>
                                    <select name="pacote" id="pacote" class="form-control @error('pacote') is-invalid @enderror" required>
                                        <option value="">Escolha um pacote...</option>
                                        @foreach($pacotes as $pacote)
                                            <option value="{{ $pacote->id }}" 
                                                    data-valor="{{ $pacote->valor }}" 
                                                    data-nome="{{ strtolower($pacote->nome_pacote) }}"
                                                    {{ old('pacote') == $pacote->id ? 'selected' : '' }}>
                                                {{ $pacote->nome_pacote }} - R$ {{ number_format($pacote->valor, 2, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pacote')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Dias Extras (Apenas para pacotes mensais) -->
                        <div id="dias-extras-section" style="display: none;">
                            <div class="section-title mb-3 mt-4">
                                <h5 class="text-success"><i class="fas fa-calendar-plus"></i> Dias Extras</h5>
                                <hr>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" class="custom-control-input" id="adicionar_dias_extras" name="adicionar_dias_extras" value="1" {{ old('adicionar_dias_extras') ? 'checked' : '' }}>
                                            <label class="custom-control-label font-weight-bold" for="adicionar_dias_extras">
                                                <i class="fas fa-plus-circle"></i> Adicionar Dias Extras ao Pacote Mensal
                                            </label>
                                        </div>
                                        <small class="form-text text-muted">
                                            <i class="fas fa-info-circle"></i> Disponível apenas para pacotes mensais. Os dias extras serão somados ao período do pacote.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="input-dias-extras" style="display: none;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="quantidade_dias_extras" class="font-weight-bold">Quantidade de Dias Extras</label>
                                        <div class="input-group">
                                            <input type="number" 
                                                   name="quantidade_dias_extras" 
                                                   id="quantidade_dias_extras" 
                                                   class="form-control @error('quantidade_dias_extras') is-invalid @enderror" 
                                                   min="1" 
                                                   max="365"
                                                   value="{{ old('quantidade_dias_extras') }}"
                                                   placeholder="Ex: 5">
                                            <div class="input-group-append">
                                                <span class="input-group-text">dias</span>
                                            </div>
                                            @error('quantidade_dias_extras')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <small class="form-text text-muted">Digite o número de dias extras (1 a 365 dias).</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="valor_dias_extras" class="font-weight-bold">Valor dos Dias Extras (R$)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">R$</span>
                                            </div>
                                            <input type="number" 
                                                   step="0.01" 
                                                   name="valor_dias_extras" 
                                                   id="valor_dias_extras" 
                                                   class="form-control @error('valor_dias_extras') is-invalid @enderror" 
                                                   value="{{ old('valor_dias_extras', '0.00') }}"
                                                   placeholder="0.00">
                                            @error('valor_dias_extras')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <small class="form-text text-muted">Valor adicional pelos dias extras.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Valor do Pacote -->
                        <div class="section-title mb-3 mt-4">
                            <h5 class="text-primary"><i class="fas fa-dollar-sign"></i> Valor</h5>
                            <hr>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox mb-3">
                                        <input type="checkbox" class="custom-control-input" id="alterar_valor" name="alterar_valor" {{ old('alterar_valor') ? 'checked' : '' }}>
                                        <label class="custom-control-label font-weight-bold" for="alterar_valor">
                                            <i class="fas fa-edit"></i> Alterar Valor do Pacote
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="valor_pacote" class="font-weight-bold">Valor do Pacote (R$) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="number" step="0.01" name="valor_pacote" id="valor_pacote" 
                                               class="form-control @error('valor_pacote') is-invalid @enderror" 
                                               value="{{ old('valor_pacote') }}" required readonly>
                                        @error('valor_pacote')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <small class="form-text text-muted">Marque a opção acima para alterar o valor padrão do pacote.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Valor Total (se houver dias extras) -->
                        <div class="row" id="valor-total-section" style="display: none;">
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <strong><i class="fas fa-calculator"></i> Valor Total:</strong>
                                    <span class="float-right">
                                        <span id="valor-total-display">R$ 0,00</span>
                                    </span>
                                    <br>
                                    <small>Pacote + Dias Extras</small>
                                </div>
                            </div>
                        </div>

                        <!-- Descrição do Pagamento -->
                        <div class="section-title mb-3 mt-4">
                            <h5 class="text-primary"><i class="fas fa-file-alt"></i> Observações</h5>
                            <hr>
                        </div>

                        <div class="form-group">
                            <label for="descricao_pagamento" class="font-weight-bold">Descrição do Pagamento <span class="text-danger">*</span></label>
                            <textarea name="descricao_pagamento" id="descricao_pagamento" 
                                      class="form-control @error('descricao_pagamento') is-invalid @enderror" 
                                      rows="4" required placeholder="Informe detalhes sobre o pagamento...">{{ old('descricao_pagamento') }}</textarea>
                            @error('descricao_pagamento')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Botões de Ação -->
                        <div class="d-flex justify-content-center mt-4 gap-2">
                            <button type="submit" class="btn btn-success btn-lg px-5 m-1">
                                <i class="fas fa-check"></i> Confirmar Compra
                            </button>
                            <a href="{{ route('compra.historico') }}" class="btn btn-secondary btn-lg px-5 m-1">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .section-title h5 {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .section-title hr {
        margin-top: 0.5rem;
        border-top: 2px solid #007bff;
        opacity: 0.3;
    }

    .form-group label {
        font-size: 0.9rem;
        color: #495057;
    }

    .form-control {
        border-radius: 5px;
        padding: 0.6rem 0.75rem;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .card {
        border-radius: 10px;
        border: none;
    }

    .gap-2 {
        gap: 0.5rem;
    }

    .btn-lg {
        font-weight: 500;
    }

    .text-danger {
        font-weight: bold;
    }

    .custom-control-label {
        cursor: pointer;
    }

    .input-group-text {
        background-color: #e9ecef;
        border: 1px solid #ced4da;
    }

    #dias-extras-section {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        margin-top: 1rem;
    }
</style>

<script>
    // Verificar se o pacote é mensal e mostrar opção de dias extras
    document.getElementById('pacote').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var valor = selectedOption.getAttribute('data-valor');
        var nomePacote = selectedOption.getAttribute('data-nome');
        var valorPacoteInput = document.getElementById('valor_pacote');
        var diasExtrasSection = document.getElementById('dias-extras-section');
        
        // Atualizar valor do pacote
        if (valor) {
            valorPacoteInput.value = parseFloat(valor).toFixed(2);
        }

        // Mostrar seção de dias extras se for pacote mensal
        if (nomePacote && nomePacote.includes('mensal')) {
            diasExtrasSection.style.display = 'block';
        } else {
            diasExtrasSection.style.display = 'none';
            document.getElementById('adicionar_dias_extras').checked = false;
            document.getElementById('input-dias-extras').style.display = 'none';
        }

        calcularValorTotal();
    });

    // Habilitar ou desabilitar o campo de valor do pacote
    document.getElementById('alterar_valor').addEventListener('change', function() {
        var valorPacoteInput = document.getElementById('valor_pacote');
        
        if (this.checked) {
            valorPacoteInput.removeAttribute('readonly');
            valorPacoteInput.focus();
        } else {
            valorPacoteInput.setAttribute('readonly', 'readonly');
            var selectedOption = document.getElementById('pacote').options[document.getElementById('pacote').selectedIndex];
            var valor = selectedOption.getAttribute('data-valor');
            if (valor) {
                valorPacoteInput.value = parseFloat(valor).toFixed(2);
            }
        }
        calcularValorTotal();
    });

    // Mostrar campo de dias extras quando checkbox for marcado
    document.getElementById('adicionar_dias_extras').addEventListener('change', function() {
        var inputDiasExtras = document.getElementById('input-dias-extras');
        if (this.checked) {
            inputDiasExtras.style.display = 'flex';
            inputDiasExtras.style.flexDirection = 'row';
        } else {
            inputDiasExtras.style.display = 'none';
            document.getElementById('quantidade_dias_extras').value = '';
            document.getElementById('valor_dias_extras').value = '0.00';
        }
        calcularValorTotal();
    });

    // Calcular valor total quando houver alteração
    document.getElementById('valor_pacote').addEventListener('input', calcularValorTotal);
    document.getElementById('valor_dias_extras').addEventListener('input', calcularValorTotal);
    document.getElementById('quantidade_dias_extras').addEventListener('input', calcularValorTotal);

    function calcularValorTotal() {
        var valorPacote = parseFloat(document.getElementById('valor_pacote').value) || 0;
        var valorDiasExtras = parseFloat(document.getElementById('valor_dias_extras').value) || 0;
        var adicionarDias = document.getElementById('adicionar_dias_extras').checked;
        
        var valorTotalSection = document.getElementById('valor-total-section');
        var valorTotalDisplay = document.getElementById('valor-total-display');
        
        if (adicionarDias && valorDiasExtras > 0) {
            var valorTotal = valorPacote + valorDiasExtras;
            valorTotalDisplay.textContent = 'R$ ' + valorTotal.toFixed(2).replace('.', ',');
            valorTotalSection.style.display = 'block';
        } else {
            valorTotalSection.style.display = 'none';
        }
    }
</script>
@endsection
