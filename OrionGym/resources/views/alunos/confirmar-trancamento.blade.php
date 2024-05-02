<!-- resources/views/alunos/confirmar-trancamento.blade.php -->
@extends('layouts.user-layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Confirmação de Trancamento de Matrícula') }}</div>

                    <div class="card-body">
                        <p>Deseja realmente trancar a matrícula do aluno {{ $aluno->nome }}?</p>
                        <form action="{{ route('alunos.confirmarTrancamento', $aluno->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                Confirmar Trancamento
                                <i class="fa fa-lock"></i> <!-- Ícone de cadeado -->
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
