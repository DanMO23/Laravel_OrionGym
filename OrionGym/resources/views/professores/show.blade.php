@extends('layouts.user-layout')

@section('header-user', 'Detalhes do Professor')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($professor->foto)
                            <div class="form-group">
                        <label for="foto">Foto:</label><br>
                        <img src="{{ asset('uploads/' . $professor->foto) }}" alt="Foto do Funcionário" style="max-width: 300px;">
                    </div>
                            @else
                            <p>Foto não disponível</p>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <p><strong>Nome:</strong> {{ $professor->nome_completo }}</p>
                            <p><strong>Email:</strong> {{ $professor->email }}</p>
                            <p><strong>Telefone:</strong> {{ $professor->telefone }}</p>
                            <p><strong>Cargo:</strong> {{ $professor->cargo }}</p>
                            <p><strong>Endereço:</strong> {{ $professor->endereco }}</p>

                        </div>
                        <div class="col-md-12">
                            <a href="{{ route('professores.index') }}" class="btn btn-primary">Voltar</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
