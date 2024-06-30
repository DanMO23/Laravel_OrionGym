@extends('layouts.user-layout')

@section('title', 'Alunos Vencidos')

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

                <div class="card-header ">

                    <div class="d-flex justify-content-between">
                        <h4>Alunos Vencidos</h4>
                    </div>

                    <br>


                </div>

                <div class="card-body">
                    @if ($alunosVencidos->isEmpty())
                    <p>Não há alunos vencidos.</p>
                    @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Matricula</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Sexo</th>
                                <th>Status</th>
                                <th>Data de Vencimento</th>

                                <th>Ações</th> <!-- Nova coluna para as ações -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alunosVencidos as $aluno)
                            <tr>
                                <td>{{ $aluno->numero_matricula}}</td>
                                <td>{{ $aluno->nome }}</td>
                                <td>{{ $aluno->email }}</td>
                                <td>{{ $aluno->telefone }}</td>

                                <td>{{ $aluno->sexo == 'M' ? 'Masculino' : 'Feminino' }}</td>
                                <td>{{ $aluno->matricula_ativa }}</td>
                                <td>{{ $aluno->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('alunos.show', $aluno->aluno_id) }}" class="btn btn-info btn-sm">Detalhes</a>
                                    @if(!($aluno->matricula_ativa == 'bloqueado') )
                                    <form action="{{ route('alunos.bloquear', $aluno->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Aluno Bloqueado na Catraca?</button>
                                    </form>
                                    
                                    <!-- Modal de confirmação para trancar -->
                                    
                                    @endif
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