@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Alunos</h3>
            <div class="card-tools">
                <a href="{{ route('alunos.create') }}" class="btn btn-success">Novo Aluno</a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Data de Nascimento</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($alunos as $aluno)
                    <tr>
                        <td>{{ $aluno->nome }}</td>
                        <td>{{ $aluno->cpf }}</td>
                        <td>{{ $aluno->data_nascimento }}</td>
                        <td>{{ $aluno->telefone }}</td>
                        <td>{{ $aluno->email }}</td>
                        <td>
                            <a href="{{ route('alunos.show', $aluno->id) }}" class="btn btn-primary btn-sm">Ver</a>
                            <a href="{{ route('alunos.edit', $aluno->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('alunos.destroy', $aluno->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@endsection
