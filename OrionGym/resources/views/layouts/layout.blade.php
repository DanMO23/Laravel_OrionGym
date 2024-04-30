
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OrionGym</title>
    <link rel="icon" href="/img/logo.png" type="image/x-icon">

    <!-- AdminLTE3 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- User Icon -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
    
            <i id="logoutIcon" class="fas fa-sign-out-alt"></i>

            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- Logout Link -->
                <a href="{{ route('logout') }}" class="dropdown-item"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <!-- Logout Form -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->



        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->

            <a href="{{ route('dashboardUser.index') }}" class="brand-link">
                <span class="brand-text font-weight-light">Academia Orion</span>
                <img src="/img/logo.png" alt="OrionGym Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <!-- Aqui você pode adicionar links específicos da sua aplicação -->
                    @yield('partials.sidebar-menu')
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <!-- Aqui você pode adicionar o cabeçalho específico da página -->
                    @yield('header')
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Aqui você pode adicionar o conteúdo específico da página -->
                    @yield('content')
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.5
            </div>
            <strong>© 2024 <a href="https://github.com/DanMO23">Danilo Matos - Developer</a>.</strong> Todos os direitos reservados.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- AdminLTE3 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>


    <script>
        function toggleSidebar() {
            const body = document.body;
            body.classList.toggle('sidebar-collapse');
        }
    </script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Selecione o ícone de logout pelo ID
        const logoutIcon = document.getElementById('logoutIcon');

        // Adicione um ouvinte de evento de clique ao ícone
        logoutIcon.addEventListener('click', function() {
            // Crie um formulário oculto
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('logout') }}";

            // Adicione um campo de token CSRF ao formulário
            const token = document.createElement('input');
            token.type = 'hidden';
            token.name = '_token';
            token.value = "{{ csrf_token() }}";
            form.appendChild(token);

            // Adicione o formulário à página e envie-o
            document.body.appendChild(form);
            form.submit();
        });
    });
</script>



</body>

</html>