@extends('layouts.layout')

@section('header')
    <h1>Dashboard do Usuário</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <!-- Aqui você pode adicionar o conteúdo específico da página -->
            <h2>Seja bem-vindo ao Dashboard do Usuário</h2>
           
        </div>
    </div>
@stop

@section('partials.sidebar-menu')
    <!-- Sidebar Menu -->
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Dashboard -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <!-- Alunos -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user-graduate"></i>
                <p>Alunos</p>
            </a>
        </li>
        <!-- Professores -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chalkboard-teacher"></i>
                <p>Professores</p>
            </a>
        </li>
        <!-- Funcionários -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user-tie"></i>
                <p>Funcionários</p>
            </a>
        </li>
        <!-- Pacotes -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-box-open"></i>
                <p>Pacotes</p>
            </a>
        </li>
    </ul>
    <!-- /.sidebar-menu -->
@stop

@section('footer')
    @parent
    <!-- Aqui você pode adicionar o rodapé específico da página -->
@stop
