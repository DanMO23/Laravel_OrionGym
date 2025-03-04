@extends('layouts.user-layout')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Criar Ficha de Treino</h1>
        
        <form action="{{ route('fichas.store') }}" method="POST">
            @csrf

            <!-- Nome do Aluno e Nome da Ficha -->
            <div class="mb-4">
                <label for="nome_aluno" class="block text-sm font-medium text-gray-700">Nome do Aluno</label>
                <input type="text" id="nome_aluno" name="nome_aluno" class="mt-1 block w-full p-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="nome_ficha" class="block text-sm font-medium text-gray-700">Objetivo da Ficha</label>
                <input type="text" id="nome_ficha" name="nome_ficha" class="mt-1 block w-full p-2 border rounded-md" required>
            </div>

            <!-- Seleção de Treinos -->
            <div class="mb-4">
                <h2 class="text-lg font-semibold">Selecione os treinos</h2>
                <div class="flex items-center space-x-4">
                    <div>
                        <input type="checkbox" id="treinoC" name="treinoC" class="mr-2">
                        <label for="treinoC" class="text-sm font-medium">Treino C</label>
                    </div>
                    <div>
                        <input type="checkbox" id="treinoD" name="treinoD" class="mr-2">
                        <label for="treinoD" class="text-sm font-medium">Treino D</label>
                    </div>
                </div>
            </div>

            <!-- Exercícios - Tabelas -->
            <div class="mb-4">
                <h2 class="text-lg font-semibold">Exercícios</h2>
                <!-- Treino A -->
                <div class="mb-4" id="treinoA">
                    <h3 class="font-semibold text-md">Treino A</h3>
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="border p-2">Exercício</th>
                                <th class="border p-2">Séries</th>
                                <th class="border p-2">Repetições/Tempo</th>
                                <th class="border p-2">Descanso</th>
                                <th class="border p-2">Ação</th>
                            </tr>
                        </thead>
                        <tbody id="treinoA_exercicios">
                            <tr class="exercicio-row">
                                <td><input type="text" name="exercicios[A][0][nome_exercicio]" class="p-2 border w-full" required></td>
                                <td><input type="number" name="exercicios[A][0][series]" class="p-2 border w-full" required min="1"></td>
                                <td><input type="text" name="exercicios[A][0][repeticoes_tempo]" class="p-2 border w-full" required></td>
                                <td><input type="text" name="exercicios[A][0][descanso]" class="p-2 border w-full" required></td>
                                <td><button type="button" class="btn-remove bg-red-500 text-black p-2 rounded">Remover</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" id="addTreinoA" class="bg-blue-500 text-black p-2 rounded mt-2">Adicionar Exercício</button>
                </div>

                <!-- Treino B -->
                <div class="mb-4" id="treinoB">
                    <h3 class="font-semibold text-md">Treino B</h3>
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="border p-2">Exercício</th>
                                <th class="border p-2">Séries</th>
                                <th class="border p-2">Repetições/Tempo</th>
                                <th class="border p-2">Descanso</th>
                                <th class="border p-2">Ação</th>
                            </tr>
                        </thead>
                        <tbody id="treinoB_exercicios">
                            <tr class="exercicio-row">
                                <td><input type="text" name="exercicios[B][0][nome_exercicio]" class="p-2 border w-full" required></td>
                                <td><input type="number" name="exercicios[B][0][series]" class="p-2 border w-full" required min="1"></td>
                                <td><input type="text" name="exercicios[B][0][repeticoes_tempo]" class="p-2 border w-full" required></td>
                                <td><input type="text" name="exercicios[B][0][descanso]" class="p-2 border w-full" required></td>
                                <td><button type="button" class="btn-remove bg-red-500 text-black p-2 rounded">Remover</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" id="addTreinoB" class="bg-blue-500 text-black p-2 rounded mt-2">Adicionar Exercício</button>
                </div>

                <!-- Treino C -->
                <div class="mb-4 hidden" id="treinoC_div">
                    <h3 class="font-semibold text-md">Treino C</h3>
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="border p-2">Exercício</th>
                                <th class="border p-2">Séries</th>
                                <th class="border p-2">Repetições/Tempo</th>
                                <th class="border p-2">Descanso</th>
                                <th class="border p-2">Ação</th>
                            </tr>
                        </thead>
                        <tbody id="treinoC_exercicios">
                            <tr class="exercicio-row">
                                <td><input type="text" name="exercicios[C][0][nome_exercicio]" class="p-2 border w-full" required></td>
                                <td><input type="number" name="exercicios[C][0][series]" class="p-2 border w-full" required min="1"></td>
                                <td><input type="text" name="exercicios[C][0][repeticoes_tempo]" class="p-2 border w-full" required></td>
                                <td><input type="text" name="exercicios[C][0][descanso]" class="p-2 border w-full" required></td>
                                <td><button type="button" class="btn-remove bg-red-500 text-black p-2 rounded">Remover</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" id="addTreinoC" class="bg-blue-500 text-black p-2 rounded mt-2">Adicionar Exercício</button>
                </div>

                <!-- Treino D -->
                <div class="mb-4 hidden" id="treinoD_div">
                    <h3 class="font-semibold text-md">Treino D</h3>
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="border p-2">Exercício</th>
                                <th class="border p-2">Séries</th>
                                <th class="border p-2">Repetições/Tempo</th>
                                <th class="border p-2">Descanso</th>
                                <th class="border p-2">Ação</th>
                            </tr>
                        </thead>
                        <tbody id="treinoD_exercicios">
                            <tr class="exercicio-row">
                                <td><input type="text" name="exercicios[D][0][nome_exercicio]" class="p-2 border w-full" required></td>
                                <td><input type="number" name="exercicios[D][0][series]" class="p-2 border w-full" required min="1"></td>
                                <td><input type="text" name="exercicios[D][0][repeticoes_tempo]" class="p-2 border w-full" required></td>
                                <td><input type="text" name="exercicios[D][0][descanso]" class="p-2 border w-full" required></td>
                                <td><button type="button" class="btn-remove bg-red-500 text-black p-2 rounded">Remover</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" id="addTreinoD" class="bg-blue-500 text-black p-2 rounded mt-2">Adicionar Exercício</button>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="flex justify-between mt-4">
                <button type="submit" class="bg-green-500 text-black p-2 rounded">Salvar Ficha</button>
                <a href="{{ route('fichas.index') }}" class="bg-gray-500 text-black p-2 rounded">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        // Função para adicionar exercício
        function addExercicio(treinoLetra) {
            let tbody = document.getElementById(`treino${treinoLetra}_exercicios`);
            let rows = tbody.getElementsByClassName('exercicio-row');
            let index = rows.length;
            
            let newRow = rows[0].cloneNode(true);
            
            // Atualiza os nomes dos campos
            newRow.querySelectorAll('input').forEach(input => {
                let currentName = input.getAttribute('name');
                input.setAttribute('name', currentName.replace(/\[\d+\]/, `[${index}]`));
                input.value = ''; // Limpa os valores
            });

            // Adiciona evento de remoção
            newRow.querySelector('.btn-remove').addEventListener('click', function() {
                if (rows.length > 1) { // Mantém pelo menos uma linha
                    newRow.remove();
                }
            });

            tbody.appendChild(newRow);
        }

        // Função para gerenciar a visibilidade dos treinos C e D
        function gerenciarTreinoCeD() {
            const treinoCCheckbox = document.getElementById('treinoC');
            const treinoDCheckbox = document.getElementById('treinoD');
            const treinoCDiv = document.getElementById('treinoC_div');
            const treinoDDiv = document.getElementById('treinoD_div');

            // Gerenciar Treino C
            if (treinoCCheckbox && treinoCDiv) {
                if (treinoCCheckbox.checked) {
                    treinoCDiv.style.display = 'block';
                    treinoCDiv.classList.remove('hidden');
                    // Habilitar campos required
                    treinoCDiv.querySelectorAll('input').forEach(input => {
                        input.required = true;
                    });
                } else {
                    treinoCDiv.style.display = 'none';
                    treinoCDiv.classList.add('hidden');
                    // Desabilitar campos required e limpar valores
                    treinoCDiv.querySelectorAll('input').forEach(input => {
                        input.required = false;
                        input.value = '';
                    });
                }
            }

            // Gerenciar Treino D
            if (treinoDCheckbox && treinoDDiv) {
                if (treinoDCheckbox.checked) {
                    treinoDDiv.style.display = 'block';
                    treinoDDiv.classList.remove('hidden');
                    // Habilitar campos required
                    treinoDDiv.querySelectorAll('input').forEach(input => {
                        input.required = true;
                    });
                } else {
                    treinoDDiv.style.display = 'none';
                    treinoDDiv.classList.add('hidden');
                    // Desabilitar campos required e limpar valores
                    treinoDDiv.querySelectorAll('input').forEach(input => {
                        input.required = false;
                        input.value = '';
                    });
                }
            }
        }

        // Inicialização quando o DOM estiver carregado
        document.addEventListener('DOMContentLoaded', function() {
            // Configurar estado inicial
            gerenciarTreinoCeD();

            // Adicionar listeners para os checkboxes
            document.getElementById('treinoC').addEventListener('change', gerenciarTreinoCeD);
            document.getElementById('treinoD').addEventListener('change', gerenciarTreinoCeD);

            // Configurar botões de adicionar exercício
            ['A', 'B', 'C', 'D'].forEach(letra => {
                const addButton = document.getElementById(`addTreino${letra}`);
                if (addButton) {
                    addButton.addEventListener('click', () => addExercicio(letra));
                }
            });

            // Configurar botões de remover exercício
            document.querySelectorAll('.btn-remove').forEach(button => {
                button.addEventListener('click', function() {
                    const tbody = this.closest('tbody');
                    if (tbody.getElementsByClassName('exercicio-row').length > 1) {
                        this.closest('.exercicio-row').remove();
                    }
                });
            });
        });
    </script>
@endsection
