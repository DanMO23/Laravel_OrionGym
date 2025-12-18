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
            <a href="{{ route('dashboardUser.index') }}" class="nav-link {{ request()->routeIs('dashboardUser.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>

        <!-- Alunos -->
        <li class="nav-item has-treeview {{ request()->is('alunos*') && !request()->is('alunos-personal*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('alunos*') && !request()->is('alunos-personal*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-graduate"></i>
                <p>
                    Alunos
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('alunos.create') }}" class="nav-link {{ request()->routeIs('alunos.create') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cadastrar Novo Aluno</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('alunos.index') }}" class="nav-link {{ request()->routeIs('alunos.index') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Exibir Alunos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('alunos.vencidos') }}" class="nav-link {{ request()->routeIs('alunos.vencidos') ? 'active' : '' }}">
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
        <li class="nav-item has-treeview {{ request()->is('funcionarios*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('funcionarios*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>
                    Funcionários
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @if(auth()->user()->hasRole('admin'))
                <li class="nav-item">
                    <a href="{{ route('funcionarios.create') }}" class="nav-link {{ request()->routeIs('funcionarios.create') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Novo Funcionario</p>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('funcionarios.index') }}" class="nav-link {{ request()->routeIs('funcionarios.index') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Exibir Funcionarios</p>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Personal Trainers -->
        <li class="nav-item has-treeview {{ request()->is('professores*') || request()->is('alunos-personal*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('professores*') || request()->is('alunos-personal*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-dumbbell"></i>
                <p>
                    Personal Trainers
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('professores.index') }}" class="nav-link {{ request()->routeIs('professores.index') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Exibir Professores</p>
                    </a>
                </li>
                @if(auth()->user()->hasRole('admin'))
                <li class="nav-item">
                    <a href="{{ route('professores.create') }}" class="nav-link {{ request()->routeIs('professores.create') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Adicionar Professor</p>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('alunos-personal.index') }}" class="nav-link {{ request()->routeIs('alunos-personal.*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Alunos de Personal</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('alunos-personal.painel-pagamentos') }}" class="nav-link {{ request()->routeIs('alunos-personal.painel-pagamentos') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Painel de Pagamentos</p>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Ficha -->
        <li class="nav-item has-treeview {{ request()->is('avaliacao*') || request()->is('fichas*') || request()->is('pesquisaFicha*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('avaliacao*') || request()->is('fichas*') || request()->is('pesquisaFicha*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>
                    Fichas
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('avaliacao.create') }}" class="nav-link {{ request()->routeIs('avaliacao.create') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Nova Avaliação Física</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('avaliacao.index') }}" class="nav-link {{ request()->routeIs('avaliacao.index') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Exibir Avaliações</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('fichas.index') }}" class="nav-link {{ request()->routeIs('fichas.index') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Lista de Fichas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('fichas.create') }}" class="nav-link {{ request()->routeIs('fichas.create') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Criar Ficha</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pesquisaFicha.index') }}" class="nav-link {{ request()->routeIs('pesquisaFicha.index') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pesquisar Ficha</p>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Produtos -->
        <li class="nav-item has-treeview {{ request()->is('produto*') || request()->is('compraProduto*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('produto*') || request()->is('compraProduto*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-shopping-cart"></i>
                <p>
                    Produtos
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @if(auth()->user()->hasRole('admin'))
                <li class="nav-item">
                    <a href="{{ route('produto.create') }}" class="nav-link {{ request()->routeIs('produto.create') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Adicionar Produto</p>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('produto.index') }}" class="nav-link {{ request()->routeIs('produto.index') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Exibir Produtos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('compraProduto.historico') }}" class="nav-link {{ request()->routeIs('compraProduto.historico') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Histórico de Compras</p>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Gympass -->
        <li class="nav-item">
            <a href="{{ route('gympass.index') }}" class="nav-link {{ request()->routeIs('gympass.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-id-card"></i>
                <p>Gympass</p>
            </a>
        </li>

        <!-- Pacotes -->
        <li class="nav-item has-treeview {{ request()->is('pacotes*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('pacotes*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-box-open"></i>
                <p>
                    Pacotes
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('pacotes.index') }}" class="nav-link {{ request()->routeIs('pacotes.index') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Exibir Pacotes</p>
                    </a>
                </li>
                @if(auth()->user()->hasRole('admin'))
                <li class="nav-item">
                    <a href="{{ route('pacotes.create') }}" class="nav-link {{ request()->routeIs('pacotes.create') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Novo Pacote</p>
                    </a>
                </li>
                @endif
            </ul>
        </li>

        <!-- Botões de Ação -->
        <a href="{{ route('compra.create') }}" class="btn btn-block btn-outline-success">
            <i class="fas fa-plus-circle mr-2"></i>Nova Compra
        </a>
        <a href="{{ route('compra.historico') }}" class="btn btn-block btn-outline-info">
            <i class="fas fa-history mr-2"></i>Histórico de Compras
        </a>
    </ul>
</nav>
<!-- /.sidebar-menu -->
@stop

@section('footer')
@parent
<!-- Aqui você pode adicionar o rodapé específico da página -->
@stop