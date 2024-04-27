@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Cadastrar Novo Aluno</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('alunos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input type="text" name="cpf" id="cpf" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="data_nascimento">Data de Nascimento</label>
                    <input type="text" name="data_nascimento" id="data_nascimento" class="form-control datepicker" required>
                </div>
                <div class="form-group">
                    <label for="endereco">Endereço</label>
                    <input type="text" name="endereco" id="endereco" class="form-control">
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="text" name="telefone" id="telefone" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control-file">
                </div>
                <input type="submit" value="Cadastrar" class="btn btn-success">
                

                <a href="{{ route('alunos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                language: 'pt-BR',
                autoclose: true,
            });
        });
    </script>
@endsection
