@extends('layouts.user-layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <div class="card-header">Funcionários</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Telefone</th>
                                <th>E-mail</th>
                                <th>Cargo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($funcionarios as $funcionario)
                            <tr>
                                <td>{{ $funcionario->nome_completo }}</td>
                                <td>{{ $funcionario->telefone}}</td>
                                <td>{{ $funcionario->email }}</td>
                                <td>{{ $funcionario->cargo }}</td>
                                <td>
                                    <a href="{{ route('funcionarios.show', $funcionario->id) }}" class="btn btn-primary">Detalhes</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
