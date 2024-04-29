@extends('layouts.user-layout')

@section('header-user', 'Lista de Pacotes')

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
                <div class="card-header">Lista de Pacotes</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('pacotes.create') }}" class="btn btn-primary mb-3">Criar Novo Pacote</a>
                        </div>
                    </div>

                    @if ($pacotes->isEmpty())
                    <p>Nenhum pacote encontrado.</p>
                    @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Valor</th>
                                <th>Validade</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pacotes as $pacote)
                            <tr>
                                <td>{{ $pacote->nome_pacote }}</td>
                                <td>{{ $pacote->valor }}</td>
                                <td>{{ $pacote->validade }} dias</td>
                                <td>

                                    <a href="{{ route('pacotes.edit', $pacote->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                    <form action="{{ route('pacotes.destroy', $pacote->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este pacote?')">Excluir</button>
                                    </form>
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