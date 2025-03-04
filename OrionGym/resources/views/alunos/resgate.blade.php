@extends('layouts.user-layout')

@section('title', 'Resgate de Alunos')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <div class="card-header d-flex justify-content-between">
                    <h4>Alunos para Resgate</h4>
                    <a href="{{ route('alunos.index') }}" class="btn btn-secondary btn-sm">Voltar</a>
                </div>

                <div class="card-body">
                    @if(Auth::user()->hasRole('admin'))
                    <form action="{{ route('alunos.resgatar') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="numero_matricula">Matrículas dos alunos (separadas por vírgula):</label>
                            <input type="text" id="numero_matricula" name="numero_matricula" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Adicionar ao Resgate</button>
                    </form>
                    @endif

                    <hr>

                    @if ($alunosResgate->isEmpty())
                    <p>Nenhum aluno na lista de resgate.</p>
                    @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Matrícula</th>
                                <th>Nome</th>
                                <th>Telefone</th>
                                <th>Data de Ultimo Acesso a Academia</th> <!-- Nova coluna -->
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alunosResgate as $aluno)
                            <tr>
                                <td>{{ $aluno->numero_matricula }}</td>
                                <td>{{ $aluno->nome }}</td>
                                <td>{{ $aluno->telefone }}</td>
                                <!-- Exibir data formatada -->
                                @php
                                    $alunoVencido = $alunosVencidos->where('numero_matricula', $aluno->numero_matricula)->first();
                                @endphp
                                <td>{{ $alunoVencido ? $alunoVencido->created_at->format('d/m/Y H:i:s') : 'N/A' }}</td>
                                <td>
                                    <form action="{{ route('alunos.resgate.remover', $aluno->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Entrei em contato?</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection