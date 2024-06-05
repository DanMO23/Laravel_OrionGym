@extends('layouts.user-layout')
@section('header-user', 'Pré-inscrições')
@section('content')
<section class="pre-registrations-section spad" style="background-color: #f7f7f7;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-title">
                    <h2>Pré-inscrições</h2>
                    <p>Lista de todas as pré-inscrições recebidas.</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Email</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Data de Inscrição</th>
                            <th scope="col">Entrei em Contato?</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($preRegistrations as $preRegistration)
                            <tr>
                                <td>{{ $preRegistration->name }}</td>
                                <td>{{ $preRegistration->email }}</td>
                                <td>{{ $preRegistration->tel}}</td>
                                <td>{{ $preRegistration->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                            <input type="checkbox" name="contacted" value="1"
                                                {{ $preRegistration->contacted ? 'checked' : '' }}>
                                        </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
