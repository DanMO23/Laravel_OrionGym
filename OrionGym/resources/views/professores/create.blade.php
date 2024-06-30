@extends('layouts.user-layout')

@section('header-user', 'Cadastrar Professor')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Cadastrar Professor</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Professores</a></li>
                    <li class="breadcrumb-item active">Cadastrar</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('professores.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="funcionario_id">Selecione o funcionário:</label>
                                <select name="funcionario_id" id="funcionario_id" class="form-control">
                                    <!-- Opções de funcionários -->
                                    @foreach($funcionarios as $funcionario)
                                        <option value="{{ $funcionario->id }}">{{ $funcionario->nome_completo}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tipo">Tipo de Professor:</label>
                                <select name="tipo" id="tipo" class="form-control">
                                    <option value="integral">Professor Integral</option>
                                    <option value="personal">Personal Trainer</option>
                                    <option value="teste">teste</option>
                                    <option value="ambos">Ambos</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
