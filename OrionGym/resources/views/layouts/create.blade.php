@extends('layouts.user-layout')

@section('title', 'Criar Aluno')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@yield('card-header')</div>

                <div class="card-body">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>
@stop
<!-- Bootstrap JS -->