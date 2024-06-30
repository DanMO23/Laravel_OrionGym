@extends('layouts.user-layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Detalhes do Funcionário</div>

                <div class="card-body">
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" class="form-control" id="nome" value="{{ $funcionario->nome_completo }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="text" class="form-control" id="email" value="{{ $funcionario->email }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="telefone">Telefone:</label>
                        <input type="text" class="form-control" id="telefone" value="{{ $funcionario->telefone }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="cargo">Cargo:</label>
                        <input type="text" class="form-control" id="cargo" value="{{ $funcionario->cargo }}" readonly>
                    </div>

                    @if($funcionario->foto)
                    <div class="form-group offset-md-4">
                        <label for="foto">Foto:</label><br>
                        <img src="{{ asset('uploads/' . $funcionario->foto) }}" alt="Foto do Funcionário" style="max-width: 300px;">
                    </div>
                    @endif

                    <div class="col-md-6">
                        <a href="{{ route('funcionarios.index') }}" class="btn btn-primary">Voltar</a>
                    </div>

                    <!-- Formulário para deletar funcionário -->
                    <div class="col-md-6 mt-3">
                        <form action="{{ route('funcionarios.destroy', $funcionario->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja deletar este funcionário?')">Deletar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
