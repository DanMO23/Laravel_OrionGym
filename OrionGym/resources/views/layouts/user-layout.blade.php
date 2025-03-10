@extends('layouts.layout')

@section('header')
<h1>@yield('header-user')</h1>
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
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Dashboard -->
        <li class="nav-item">
            <a href="{{ route('dashboardUser.index') }}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>

        <!-- Alunos -->
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user-graduate"></i>
                <p>
                    Alunos
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('alunos.create') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cadastrar Novo Aluno</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('alunos.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Exibir Alunos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('alunos.vencidos') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Alunos Vencidos</p>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Pré-inscrições
        <li class="nav-item">
            <a href="{{ route('pre-registrations.index') }}" class="nav-link">
                <i class="nav-icon fas fa-user-plus"></i>
                <p>Pré-inscrições</p>
            </a>
        </li> -->

        <!-- Funcionarios -->
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                    Funcionários
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @if(auth()->user()->hasRole('admin'))
                <li class="nav-item">
                    <a href="{{ route('funcionarios.create') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Novo Funcionario</p>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('funcionarios.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Exibir Funcionarios</p>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Professores -->
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chalkboard-teacher"></i>
                <p>
                    Professores
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('professores.create') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Adicionar Professor</p>
                    </a>
                    @endif
                </li>
                <li class="nav-item">
                    <a href="{{ route('professores.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Exibir Professores</p>
                    </a>
                </li>
            </ul>
        </li>
        <!-- Ficha -->
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>
                    Fichas
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('avaliacao.create') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Nova Avaliação Física</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('avaliacao.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Exibir Avaliações</p>
                    </a>
                </li>

            </ul>
        </li>
        <!-- Produtos -->
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-shopping-cart"></i>
                <p>
                    Produtos
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('produto.create') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Adicionar Produto</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('produto.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Exibir Produtos</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('compraProduto.historico') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Histórico de Compras</p>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Pacotes -->
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-box-open"></i>
                <p>
                    Pacotes
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('pacotes.create') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Novo Pacote</p>
                    </a>
                    @endif
                </li>
                <li class="nav-item">
                    <a href="{{ route('pacotes.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Exibir Pacotes</p>
                    </a>
                </li>
            </ul>
        </li>



        <a href="{{ route('compra.create') }}" class="btn btn-block btn-outline-success">
            <i class="fas fa-plus-circle mr-2"></i>Nova Compra
        </a>
        <a href="{{ route('compra.historico') }}" class="btn btn-block btn-outline-info">
            <i class="fas fa-history mr-2"></i>Histórico de Compras
        </a>
    </ul>


</nav>



<!-- /.sidebar-footer -->
<!-- /.sidebar-menu -->

@stop

@section('footer')
@parent
<!-- Aqui você pode adicionar o rodapé específico da página -->
@stop