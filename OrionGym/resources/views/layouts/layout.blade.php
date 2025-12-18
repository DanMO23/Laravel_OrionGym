<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia Orion</title>
    <link rel="icon" href="/img/logo.png" type="image/x-icon">

    <!-- AdminLTE3 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        .main-sidebar {
            background: #2c3e50;
            box-shadow: 2px 0 8px rgba(0,0,0,0.1);
        }

        .brand-link {
            background: rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 1.2rem;
            transition: background 0.3s;
        }

        .brand-link:hover {
            background: rgba(0, 0, 0, 0.15);
        }

        .brand-text {
            color: #fff !important;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .brand-image {
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .nav-sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 0.75rem 1rem;
            margin: 0.2rem 0.5rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .nav-sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            padding-left: 1.2rem;
        }

        .nav-sidebar .nav-link.active {
            background: #3498db;
            color: #fff;
            box-shadow: 0 2px 6px rgba(52, 152, 219, 0.3);
        }

        .nav-treeview {
            background: rgba(0, 0, 0, 0.1);
            margin: 0.2rem 0.5rem;
            border-radius: 6px;
        }

        .nav-treeview .nav-link {
            padding: 0.6rem 1rem 0.6rem 2.2rem;
            font-size: 0.9rem;
            margin: 0;
        }

        .nav-icon {
            font-size: 1rem;
            margin-right: 0.75rem;
            width: 18px;
            text-align: center;
        }

        .nav-treeview .nav-icon {
            font-size: 0.4rem;
        }

        .btn-block {
            margin: 0.5rem;
            border-radius: 6px;
            font-weight: 500;
            padding: 0.65rem;
            transition: all 0.3s;
            text-align: center;
        }

        .btn-outline-success {
            border: 2px solid #27ae60;
            color: #27ae60;
            background: transparent;
        }

        .btn-outline-success:hover {
            background: #27ae60;
            border-color: #27ae60;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(39, 174, 96, 0.3);
        }

        .btn-outline-info {
            border: 2px solid #3498db;
            color: #3498db;
            background: transparent;
        }

        .btn-outline-info:hover {
            background: #3498db;
            border-color: #3498db;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(52, 152, 219, 0.3);
        }

        .main-header {
            background: #fff;
            border-bottom: 1px solid #dee2e6;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .sidebar-toggle {
            background: none;
            border: none;
            color: #495057;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0.5rem 1rem;
            transition: all 0.3s;
            border-radius: 5px;
        }

        .sidebar-toggle:hover {
            background: #f8f9fa;
            color: #3498db;
        }

        .navbar-nav .nav-link {
            color: #495057;
            transition: all 0.3s;
        }

        .navbar-nav .nav-link:hover {
            color: #3498db;
        }

        .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
        }

        .dropdown-item {
            padding: 0.7rem 1.5rem;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background: #f8f9fa;
            color: #3498db;
            padding-left: 1.7rem;
        }

        .content-wrapper {
            background: #f4f6f9;
        }

        .main-footer {
            background: #fff;
            border-top: 1px solid #dee2e6;
            padding: 1rem;
            color: #6c757d;
        }

        .main-footer a {
            color: #3498db;
            text-decoration: none;
            transition: color 0.3s;
        }

        .main-footer a:hover {
            color: #2980b9;
        }

        /* Animação para as setas dos menus */
        .nav-link .right {
            transition: transform 0.3s;
        }

        .nav-item.menu-open > .nav-link .right {
            transform: rotate(-90deg);
        }

        /* Scrollbar customizada para sidebar */
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Ajuste do menu collapse */
        .sidebar-collapse .main-sidebar {
            margin-left: -250px;
        }
    </style>
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
                <!-- User Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user-circle fa-lg"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt mr-2"></i> Sair
                        </a>
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
                <img src="/img/logo copy.png" alt="OrionGym Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Academia Orion</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
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
                    @yield('header')
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.6
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

        // Adicionar classe active ao item de menu atual
        $(document).ready(function() {
            var currentUrl = window.location.href;
            $('.nav-link').each(function() {
                if (this.href === currentUrl) {
                    $(this).addClass('active');
                    $(this).parents('.nav-item.has-treeview').addClass('menu-open');
                    $(this).parents('.nav-item.has-treeview').children('.nav-link').addClass('active');
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>