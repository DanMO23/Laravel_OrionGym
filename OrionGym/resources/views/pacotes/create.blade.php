@extends('layouts.user-layout')

@section('title', 'Criar Novo Pacote')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Criar Novo Pacote</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('pacotes.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="nome" class="col-md-4 col-form-label text-md-right">Nome do Pacote:</label>
                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" required autocomplete="nome" autofocus>

                                @error('nome')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="valor" class="col-md-4 col-form-label text-md-right">Valor do Pacote:</label>
                            <div class="col-md-6">
                                <input id="valor" type="number" class="form-control @error('valor') is-invalid @enderror" name="valor" value="{{ old('valor') }}" required autocomplete="valor">

                                @error('valor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="validade" class="col-md-4 col-form-label text-md-right">Validade do Pacote(em dias):</label>
                            <div class="col-md-6">
                                <input id="number" type="text" class="form-control @error('validade') is-invalid @enderror" name="validade" value="{{ old('validade') }}" required autocomplete="validade">

                                @error('validade')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Adicione outros campos conforme necessário -->

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Salvar Pacote</button>
                                <a href="{{ route('pacotes.index') }}" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
