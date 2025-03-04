@extends('layouts.user-layout')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Ficha de Treino - {{ $ficha->nome_ficha }}</h1>
        <p class="text-lg font-semibold">Aluno: {{ $ficha->nome_aluno }}</p>

        <!-- Exibição dos Treinos -->
        @foreach ($treinos as $treino)
            <div class="mb-6 p-4 border rounded-md shadow-md bg-white">
                <h2 class="text-xl font-bold mb-2">Treino {{ $treino->nome_treino }}</h2>
                @if ($treino->exercicios->count() > 0)
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-2">Exercício</th>
                                <th class="border p-2">Séries</th>
                                <th class="border p-2">Repetições/Tempo</th>
                                <th class="border p-2">Descanso</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($treino->exercicios as $exercicio)
                                <tr>
                                    <td class="border p-2">{{ $exercicio->nome_exercicio }}</td>
                                    <td class="border p-2 text-center">{{ $exercicio->series }}</td>
                                    <td class="border p-2 text-center">{{ $exercicio->repeticoes_tempo }}</td>
                                    <td class="border p-2 text-center">{{ $exercicio->descanso }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-500">Nenhum exercício cadastrado para este treino.</p>
                @endif
            </div>
        @endforeach

        <!-- Botões de Ação -->
        <div class="flex justify-between mt-4">
            <a href="{{ route('fichas.edit', $ficha->id) }}" class="bg-blue-500 text-black p-2 rounded">Editar Ficha</a>
            <a href="{{ route('fichas.imprimir', $ficha->id) }}" class="bg-green-500 text-black p-2 rounded" target="_blank">Imprimir Ficha</a>
            <a href="{{ route('fichas.index') }}" class="bg-gray-500 text-black p-2 rounded">Voltar</a>
        </div>
    </div>
@endsection
