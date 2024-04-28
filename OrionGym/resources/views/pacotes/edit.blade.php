@extends('layouts.user-layout')

@section('title', 'Editar Pacote')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Pacote</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('pacotes.update', $pacote->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nome">Nome do Pacote</label>
                            <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome', $pacote->nome) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="valor">Valor do Pacote</label>
                            <input type="number" name="valor" id="valor" class="form-control" value="{{ old('valor', $pacote->valor) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="validade">Validade do Pacote(em dias)</label>
                            <input type="number" name="validade" id="validade" class="form-control" value="{{ old('validade', $pacote->validade) }}" required>
                        </div>

                        <a href="{{ route('pacotes.index') }}" class="btn btn-secondary">Voltar</a>
                        <button type="submit" class="btn btn-primary">Atualizar Pacote</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
