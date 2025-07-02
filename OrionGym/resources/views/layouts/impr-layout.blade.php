<!DOCTYPE html>
<html lang="pt-br">
@php
    use Illuminate\Support\Facades\Route;
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia Orion</title>
    <link rel="icon" href="/img/logo.png" type="image/x-icon">

    <!-- AdminLTE3 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>

<body>
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand ">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                @if(Route::currentRouteName() != 'pesquisaFicha.index')
                <li class="nav-item">
                    <a href="{{ route('pesquisaFicha.index') }}" class="nav-link ">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </li>
                @endif
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- User Icon -->
                <li class="nav-item dropdown">
                    
                    
                </li>
            </ul>
        </nav>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin-left: 0;">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    @yield('header')
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer" style="margin-left: 0;">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.5
            </div>
            <strong>© 2024 <a href="https://github.com/DanMO23">Danilo Matos - Developer</a>.</strong> Todos os direitos reservados.
        </footer>
    </div>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- AdminLTE3 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoutIcon = document.getElementById('logoutIcon');
            logoutIcon.addEventListener('click', function() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('logout') }}";

                const token = document.createElement('input');
                token.type = 'hidden';
                token.name = '_token';
                token.value = "{{ csrf_token() }}";
                form.appendChild(token);

                document.body.appendChild(form);
                form.submit();
            });
        });
    </script>
</body>
</html>