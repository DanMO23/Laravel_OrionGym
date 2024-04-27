@extends('layouts.user-layout')

@section('title', 'Lista de Alunos')

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
                        <h4>Lista de Alunos</h4>
                        <a href="{{ route('alunos.create') }}" class="btn btn-primary btn-sm float-right">Novo Aluno</a>
                    </div>
                   
                    <br>
                    <form action="{{ route('alunos.index') }}" method="GET" class="form-">
                            <input type="text" id="search" name="search" class="form-control mr-sm-4" placeholder="Buscar alunos">
                            <button type="submit" class="btn btn-outline-primary">Buscar</button>
                        </form>

                    
                </div>

                <div class="card-body">
                    @if ($alunos->isEmpty())
                        <p>Não há alunos cadastrados.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Telefone</th>
                                    
                                    <th>Sexo</th>
                                    
                                    <th>Ver Mais</th> <!-- Nova coluna para as ações -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alunos as $aluno)
                                    <tr>
                                        
                                        <td>{{ $aluno->nome }}</td>
                                        <td>{{ $aluno->email }}</td>
                                        <td>{{ $aluno->telefone }}</td>
                                        
                                        <td>{{ $aluno->sexo == 'M' ? 'Masculino' : 'Feminino' }}</td>
                                        
                                        <td>
                                            <a href="{{ route('alunos.show', $aluno->id) }}" class="btn btn-info btn-sm">Detalhes</a>
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
