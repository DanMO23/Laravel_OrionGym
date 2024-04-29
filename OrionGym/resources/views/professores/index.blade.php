@extends('layouts.user-layout')

@section('header-user', 'Lista de Professores')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    @if($professores->isEmpty())
                    <p>Nenhum professor encontrado.</p>
                    @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Cargo</th>
                                <th>Tipo</th>
                                <th>Ações</th>
                                <!-- Adicione mais colunas conforme necessário -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($professores as $professor)
                            <tr>
                                <td>
                                    @if($professor->foto)
                                    <img src="{{ asset('uploads/' . $professor->foto) }}" alt="Foto do Professor" style="max-width: 100px;">
                                    @else
                                    <p>"Foto não disponível"</p>
                                    @endif
                                </td>
                                <td>{{ $professor->nome_completo }}</td>
                                <td>{{ $professor->email }}</td>
                                <td>{{ $professor->telefone }}</td>
                                <td>{{ $professor->cargo }}</td>
                                <td>{{ $professor->tipo }}</td>
                                <td>
                                    <a href="{{ route('professores.show', $professor->id) }}" class="btn btn-info btn-sm">Detalhes</a>
                                   
                                    <form action="{{ route('professores.destroy', $professor->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este professor?')">Excluir</button>
                                    </form>
                                <!-- Adicione mais colunas conforme necessário -->
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
