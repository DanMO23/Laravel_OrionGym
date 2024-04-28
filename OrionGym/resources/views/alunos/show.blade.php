@extends('layouts.user-layout')

@section('title', 'Detalhes do Aluno')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Detalhes do Aluno</div>

                <div class="card-body">
                    <div class="form-group row">
                        <label for="nome" class="col-md-4 col-form-label text-md-right">Nome:</label>
                        <div class="col-md-6">
                            <p>{{ $aluno->nome }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">Email:</label>
                        <div class="col-md-6">
                            <p>{{ $aluno->email }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="telefone" class="col-md-4 col-form-label text-md-right">Telefone:</label>
                        <div class="col-md-6">
                            <p>{{ $aluno->telefone }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="data_nascimento" class="col-md-4 col-form-label text-md-right">Data de Nascimento:</label>
                        <div class="col-md-6">
                            <p>{{ $aluno->data_nascimento }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cpf" class="col-md-4 col-form-label text-md-right">CPF:</label>
                        <div class="col-md-6">
                            <p>{{ $aluno->cpf }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="sexo" class="col-md-4 col-form-label text-md-right">Sexo:</label>
                        <div class="col-md-6">
                            <p>{{ $aluno->sexo }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="endereco" class="col-md-4 col-form-label text-md-right">Endereço:</label>
                        <div class="col-md-6">
                            <p>{{ $aluno->endereco }}</p>
                        </div>
                    </div>

                    <!-- Adicione mais campos conforme necessário -->

                    <div class="form-group mb-0">
                        <div class="col-md-6 offset-md-10">
                            <!-- Botão para Editar -->
                            <a href="{{ route('alunos.edit', $aluno->id) }}" class="btn btn-primary mr-2">Editar</a>

                            <!-- Botão para Excluir com Confirmação -->
                            <form action="{{ route('alunos.destroy', $aluno->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este aluno?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mr-2">Excluir</button>
                            </form>
                        </div>
                        <div class="col-md-6 offset-md-4">
                            <a href="{{ route('alunos.index') }}" class="btn btn-primary">Voltar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection