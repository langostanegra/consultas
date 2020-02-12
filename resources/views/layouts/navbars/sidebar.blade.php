<div class="sidebar" data-color="remington_blue" data-background-color="white"
    data-image="{{ asset('material') }}/img/sidebar-1.jpg">
    <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
    <div class="logo">
        <a href="{{ url ('/home')}}" class="simple-text logo-normal">
            <img src="{{ asset('img/welcome/uniremington_horizontal_blue.png') }}" alt="" width="250">
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <!-- Pagina Inicial -->
            <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="material-icons">dashboard</i>
                    <p>Página inicial</p>
                </a>
            </li>

            <!-- Laravel examples -->
            <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
                    <i class="material-icons">assignment</i>
                    <p>{{ __('Administración') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="laravelExample">
                    <ul class="nav">
                        <li class="nav-item{{ $activePage == 'importar_credenciales' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('importar_credenciales') }}">
                                <i class="material-icons">backup</i>
                                <span class="sidebar-normal">{{ __('Importar Credenciales') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('user.index') }}">
                                <span class="sidebar-mini"> UM </span>
                                <span class="sidebar-normal"> {{ __('User Management') }} </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Finis Laravel examples -->

                <!-- Importar Usuarios -->
            <li class="nav-item{{ $activePage == '' ? ' active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="material-icons">import_export</i>
                    <p>{{ __('Importar Usuarios') }}</p>
                </a>
            </li>
            </li>
        </ul>
    </div>
</div>