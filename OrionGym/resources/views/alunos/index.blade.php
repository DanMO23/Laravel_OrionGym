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
                                <th>Matricula</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>

                                <th>Sexo</th>
                                <th>Dias Restantes</th>
                                <th>Status</th>
                                <th>Ver Mais</th> <!-- Nova coluna para as ações -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alunos as $aluno)

                            <tr style="{{ $aluno->dias_restantes <= 5 ? 'color:red;' : '' }}">
                                <td>{{ $aluno->numero_matricula }}</td>
                                <td>{{ $aluno->nome }}</td>
                                <td>{{ $aluno->email }}</td>
                                <td>{{ $aluno->telefone }}</td>

                                <td>{{ $aluno->sexo == 'M' ? 'Masculino' : 'Feminino' }}</td>
                                <td>{{ $aluno->dias_restantes }} dias</td>
                                <td>{{ $aluno->matricula_ativa }}</td>
                                <td>
                                    @if($aluno->matricula_ativa == 'ativa')
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmarTrancamento{{$aluno->id}}">
                                    <i class="fas fa-lock"></i> Trancar Matrícula
                                    </button>
                                    <!-- Modal de confirmação para trancar -->
                                    <div class="modal fade" id="confirmarTrancamento{{$aluno->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Confirmar Trancamento</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Tem certeza de que deseja trancar a matrícula do aluno {{$aluno->nome}}?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                    <form action="{{ route('alunos.trancarMatricula', $aluno->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger">Confirmar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#confirmarDestrancamento{{$aluno->id}}">
                                    <i class="fas fa-unlock"></i>Destrancar Matrícula
                                    </button>
                                    <!-- Modal de confirmação para destrancar -->
                                    <div class="modal fade" id="confirmarDestrancamento{{$aluno->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Confirmar Destrancamento</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Tem certeza de que deseja destrancar a matrícula do aluno {{$aluno->nome}}?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                    <form action="{{ route('alunos.destrancarMatricula', $aluno->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success">Confirmar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
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


<!-- Scripts do Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Biblioteca JavaScript do Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection