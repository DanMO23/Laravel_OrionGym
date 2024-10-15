@extends('layouts.user-layout')

@section('header-user', 'Editar Produto')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('produto.update', $produto->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="foto">Foto do Produto</label>
                            <input type="file" name="foto" class="form-control-file">
                            @if($produto->foto)
                                <small>Foto atual: <img src="{{ asset('storage/' . $produto->foto) }}" alt="Foto do Produto" style="max-width: 150px;"></small>
                            @endif
                            @error('foto')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="valor">Valor do Produto (R$)</label>
                            <input type="number" name="valor" class="form-control" value="{{ old('valor', $produto->valor) }}" step="0.01" required min="0">
                            @error('valor')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
