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

            <!-- Gestionar usuarios -->
            <li class="nav-item{{ $activePage == 'gestionar-usuarios' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('usuarios') }}">
                    <i class="material-icons">assignment_ind</i>
                    <span class="sidebar-normal"> {{ __('Gestionar Usuarios') }} </span>
                </a>
            </li>

            <!-- Opción Credenciales -->
            <li class="nav-item {{ ($activePage == '' || $activePage == 'credenciales') ? ' active' : '' }}">
                <a class="nav-link collapse" data-toggle="collapse" href="#laravelExample" aria-expanded="false">
                    <i class="material-icons">assignment</i>
                    <p>{{ __('Credenciales') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="laravelExample">
                    <ul class="nav">
                        <!-- Importar credenciales -->
                        <li class="nav-item{{ $activePage == 'importar_credenciales' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('importar_credenciales') }}">
                                <i class="material-icons">backup</i>
                                <span class="sidebar-normal">{{ __('Importar Credenciales') }} </span>
                            </a>
                        </li>
                        <!-- Gestionar credenciales -->
                        <li class="nav-item{{ $activePage == 'gestionar_credenciales' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('gestionar_credenciales') }}">
                                <i class="material-icons">vpn_key</i>
                                <span class="sidebar-normal">Gestionar credenciales</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Cerrar sesión -->
            <li class="nav-item{{ $activePage == '' ? ' active' : '' }}">
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                        class="material-icons">keyboard_return</i>
                    <p>Salir</p>
                </a>
                </a>
            </li>
            <!-- Finish opción Administración -->

            <!-- Importar Usuarios -->
            <!-- <li class="nav-item{{ $activePage == '' ? ' active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="material-icons">import_export</i>
                    <p>{{ __('Importar Usuarios') }}</p>
                </a>
            </li> -->
            </li>
        </ul>
    </div>
</div>