<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gym Template">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Academia Orion</title>
    <link rel="icon" href="/img/logo copy.png" type="image/x-icon">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/flaticon.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/barfiller.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <style>
        /* Custom CSS for Mobile Button */
        .mobile-button {
            display: block;
            /* Make it a block element */
            padding: 10px 20px;
            /* Add some padding */
            background-color: #3182ce;
            /* Use your theme color */
            color: white;
            /* Text color */
            text-decoration: none;
            /* Remove underline */
            border-radius: 5px;
            /* Rounded corners */
            text-align: center;
            /* Center the text */
            margin-top: 10px;
            /* Add some space above */
            font-weight: bold;
            /* Make the text bold */
            transition: background-color 0.3s ease;
            /* Smooth transition for hover effect */
        }

        .mobile-button:hover {
            background-color: #2c5282;
            /* Darker shade on hover */
        }

        /* Hide on larger screens */
        @media (min-width: 992px) {
            .mobile-button {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Section Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="canvas-close">
            <i class="fa fa-close"></i>
        </div>
        <div class="canvas-search search-switch">
            <i class="fa fa-search"></i>
        </div>
        <nav class="canvas-menu mobile-menu">
            <ul>
                <li><a href="{{ route('home.index') }}">Home</a></li>
                <li><a href="{{ route('home.services') }}">Nosso Espaço</a></li>
                <li><a href="{{ route('home.team') }}">Nosso Time</a></li>
                <li><a href="{{ route('home.bmi') }}">Calculo IMC</a></li>
                <li><a href="{{route('home.contact')}}">Contato</a></li>
                <li><a href="{{ route('pesquisaFicha.index') }}" class="mobile-button">Pesquisar Fichas</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="canvas-social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-youtube-play"></i></a>
            <a href="https://www.instagram.com/academia.orion_" target="_blank"><i class="fa fa-instagram"></i></a>
        </div>
    </div>
    <!-- Offcanvas Menu Section End -->

    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header-logo">
                        <a href="{{ route('home.index') }}">
                            <a href="{{ route('home.index') }}"><img src="img/AcademiaOrionAmarela.png" alt=""
                                    style="width: 50%; height: auto; " id="logo-principal"></a>
                        </a>
                    </div>
                </div>
                <div class="col-lg-7">
                    <nav class="nav-menu">
                        <ul>
                            <li class="active"><a href="{{ route('home.index') }}">Home</a></li>
                            <li><a href="{{route('home.bmi')}}">Calculo IMC</a>
                            </li>
                            <li><a href="{{route('home.contact')}}">Contato</a></li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('pesquisaFicha.index') }}">Pesquisar Fichas</a>
                            </li>
                            <a href="{{ route('login') }}" class="primary-btn" style="color:black ">Login</a>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-2">
                    <div class="top-option">
                        <div class="to-search search-switch">
                            <i class="fa fa-search"></i>
                        </div>
                        <div class="to-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                            <a href="https://www.instagram.com/academia.orion_" target="_blank"
                                class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="canvas-open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header End -->

    @yield('content')

    <!-- Hero Section Begin -->
    <section class="hero-section">
        <div class="hs-slider owl-carousel">
            <div class="hs-item set-bg" data-setbg="img/hero/hero-1.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-6">
                            <div class="hi-text">
                                <span>Shape your body</span>
                                <h1>Be <strong>strong</strong> traning hard</h1>
                                <p>Aqui na academia Orion, temos os melhores equipamentos e profissionais para te ajudar a alcançar seus objetivos</p>
                                <a href="#" class="primary-btn">Conheça nossos planos</a>
                                <a href="{{ route('pesquisaFicha.index') }}" class="primary-btn">Pesquisar Fichas</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- Hero Section End -->

    <!-- Footer Section Begin -->
    <section class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="fs-about">

                        <div class="fa-logo ">
                            <a href="{{route('home.index')}}"><img src="img/AcademiaOrionAmarela.png" alt=""
                                    style="width: 50%; height: auto;"></a>
                        </div>
                        <p>Academia Orion - o melhor espaço para se treinar em Betim</p>
                        <div class="fa-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                            <a href="https://www.instagram.com/academia.orion_" target="_blank"><i
                                    class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa  fa-envelope-o"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="fs-widget">
                        <h4>Links Uteis</h4>
                        <ul>
                            <li><a href="#">Nosso espaço</a></li>
                            <li><a href="#">Nosso Time</a></li>

                            <li><a href="#">Contato</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-5 col-sm-6">
                    <div class="fs-widget">
                        <h4>Suporte</h4>
                        <ul>
                            <li><a href="#">Login</a></li>
                            <li><a href="#">Minha conta</a></li>

                            <li><a href="#">Contato</a></li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="copyright-text">
                        <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> Todos os direitos reservados | <a href="https://github.com/DanMO23">Danilo Matos - Developer </a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer Section End -->

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search model end -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/jquery.barfiller.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>


</body>

</html>