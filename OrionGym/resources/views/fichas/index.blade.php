@extends('layouts.user-layout')

@section('content')
<div class="container">
    <h2>Fichas de Treino</h2>
    <a href="{{ route('fichas.create') }}" class="btn btn-primary">Nova Ficha</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Aluno</th>
                <th>Objetivo da Ficha</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fichas as $ficha)
                <tr>
                    <td>{{ $ficha->nome_aluno }}</td>
                    <td>{{ $ficha->nome_ficha }}</td>
                    <td>
                        <a href="{{ route('fichas.show', $ficha->id) }}" class="btn btn-info">Mostrar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
