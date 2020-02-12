<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Smartsupp Live Chat script -->
    <script src="{{asset('js/smartsupp_chat.js')}}" type="text/javascript"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Consultas - Uniremington Manizales</title>

    <!--Favicon-->
    <link rel="shortcut icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" href="{{asset ('css/welcome/blue_background.css')}}">
    <link rel="stylesheet" href="{{asset ('css/welcome/styles_welcome.css')}}">
    <link rel="stylesheet" href="{{asset ('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset ('css/fontawesome.all.min.css')}}">

</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#"><img src="{{asset ('img/welcome/uniremington_horizontal.png')}}" alt=""
                width="200"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Plataformas académicas
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item"
                            href="https://virtual.uniremingtonmanizales.edu.co/moodle/login/index.php"
                            target="_blank"><i class="fas fa-chalkboard-teacher"></i> Moodle</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item"
                            href="https://site4.q10.com/login?ReturnUrl=%2F&aplentId=a2e25504-9d7b-4e4e-861a-5f015f373d8f"
                            target="_blank"><i class="fas fa-graduation-cap"></i> Sistema Académico</a>
                    </div>
                </li>
            </ul>
            @if (Route::has('login'))
            @auth
            <a href="{{ url('/home') }}"><button class="btn btn-outline-light my-2 my-sm-0">Inicio</button></a>
            @else
            <a href="{{ route('login') }}"><button class="btn btn-outline-light my-2 my-sm-0">Iniciar
                    Sesion</button></a>
            @endauth
            @endif
        </div>
    </nav>

    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4" style="font-size:35px;">Plataforma de consultas</h1>
            <hr class="my-4">
            <p class="lead">Contamos con los siguientes servicios para que te puedas conectar con la U de una manera
                ágil y eficiente.</p>
        </div>
    </div>
    <br>
    <!-- Imágenes en círculos -->
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <center>
                    <div class="zoom"><img src="{{ asset('img/welcome/credenciales.svg')}}" alt="" width="200"></div>
                    <h3>Credenciales</h3>
                    <p>Adquiere el usuario y contraseña de la Biblioteca Virtual y el correo general de Uniremington</p>
                </center>
            </div>
            <div class="col-sm">
                <center>
                    <div class="zoom"><img src="{{ asset('img/welcome/docente.svg')}}" alt="" width="200"></div>
                    <h3>Seguimiento a docentes</h3>
                    <p>Consulta el estado de tu seguimiento como docente Uniremington</p>
                </center>
            </div>
            <div class="col-sm">
                <center>
                    <div class="zoom"><img src="{{ asset('img/welcome/computador.svg')}}" alt="" width="200"></div>
                    <h3>Próximos servicios...</h3>
                </center>
            </div>
        </div>
    </div>

    <!-- <hr class="featurette-divider"> -->
    <br><br>
    <div class="campus-logo"><img src="{{ asset ('img/welcome/campus_blue.png')}}" alt="" width="300"></div>

    <footer class="footer">
        <p style="color:#626262;"><a href="https://www.uniremington.edu.co/manizales/" target="_blank">Uniremington
            </a>es una Institución de
            Educación Superior sujeta a la inspección y vigilancia del Ministerio de Educación Nacional de Colombia.</p>
        <!-- <p>
            <a href="#">Regresar arriba</a>
        </p> -->
        <p style="color:#626262;">
            Sede Plaza Bolívar: Calle 22 # 21-14 / PBX: 882 8373 - Sede Cable: Carrera 23C N° 64 - 53 / PBX: 885 2121
        </p>
    </footer>

    <script src="{{ asset('js/welcome/jquery-slim.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/fontawesome.all.min.js') }}"></script>
</body>

</html>