@extends('layouts.app', ['activePage' => 'gestionar_credenciales', 'titlePage' => __('User Management')])

@section('content')

<link href="{{ asset('css/checkbox.css')}}" rel="stylesheet" />

<!-- Tabla que muestra todos los usuarios que cuentan con credenciales institucionales -->
<div class="content">
    <div class="container-fluid">
        <div class="card card-nav-tabs text-left">
            <div class="card-header card-header-primary">
                <h4 class="card-title ">{{ __('Gestionar credenciales de usuario') }}</h4>
                <p class="card-category">Acá podrás gestionar todas las credenciales de la <strong>Biblioteca
                        Virtual</strong> y <strong>Correo General</strong> de estudiantes, docentes y adminitrativos.
                </p>
            </div>
            <div class="card-body">
                <div class="col-12 text-right">
                    <button type="button"
                        class="btn btn-sm btn-primary boton_anadir_credencial_usuario">{{ __('Añadir credencial') }}</button>
                </div>
                <table id="data_table_credenciales" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th style="cursor: pointer;"><strong>Cédula</strong></th>
                            <th style="cursor: pointer;"><strong>Nombre</strong></th>
                            <th style="cursor: pointer;"><strong>Correo Institucional</strong></th>
                            <th style="cursor: pointer;"><strong>Usuario Medellín</strong></th>
                            <th style="cursor: pointer;"><strong>Contraseña Medellín</strong></th>
                            <th><strong>Acciones</strong></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Tabla que muestra el histórico de las credenciales que han sido escalados a mesa de ayuda de Uniremington Medellín -->
<div class="container-fluid">
    <div class="card card-nav-tabs text-left">
        <div class="card-header card-header-primary">
            <h4 class="card-title ">{{ __('Credenciales en estado de revisión') }}</h4>
            <p class="card-category">Todas las credenciales que no sean efectivas aparecerán aquí para poder llevar un
                registro de los casos de mesa de ayuda
            </p>
        </div>
        <div class="card-body">
            <div class="col-12 text-right">
            </div>
            <table id="data_table_revisar_credencial" class="table table-striped table-bordered"
                style="width:100%">
                <thead>
                    <tr>
                        <th style="cursor: pointer;"><strong>Id</strong></th>
                        <th style="cursor: pointer;"><strong>Cédula</strong></th>
                        <th style="cursor: pointer;"><strong>Nombre</strong></th>
                        <th style="cursor: pointer;"><strong>Correo Institucional</strong></th>
                        <th style="cursor: pointer;"><strong>Usuario Medellín</strong></th>
                        <th style="cursor: pointer;"><strong>Contraseña Medellín</strong></th>
                        <th><strong>Estado</strong></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal para insertar una nueva credencial de usuario en la base de datos -->
<div class="modal fade" id="modal_anadir_credencial_usuario" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Añadir una nueva credencial de usuario</h5>
                <button id="limpiar_modal_usuarios" style="outline:none;" type="button" class="close"
                    data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <!-- Input cedula -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Cédula</label>
                        <input type="text" class="form-control" id="cedula" name="cedula" required>
                    </div>
                    <!-- Input nombre -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <!-- Input correo institucional -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Correo institucional</label>
                        <input type="text" class="form-control" id="correo_institucional" name="correo_institucional"
                            required>
                    </div>
                    <!-- Input usuario medellín -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Usuario Medellín</label>
                        <input type="text" class="form-control" id="usuario_medellin" name="usuario_medellin" required>
                    </div>
                    <!-- Input password medellín -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Password Medellín</label>
                        <input type="text" class="form-control" id="password_medellin" name="password_medellin"
                            required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btn_submit_credencial_usuario" type="button" class="btn btn-primary">Añadir</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#data_table_credenciales').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route ('mostrar_credenciales')}}",
        columns: [{
                data: 'cedula'
            },
            {
                data: 'nombre'
            },
            {
                data: 'correo_institucional'
            },
            {
                data: 'usuario_medellin'
            },
            {
                data: 'password_medellin'
            },
            {
                data: 'acciones'
            },
        ],
        "language": {
            "info": "_TOTAL_ Credenciales",
            "search": "Buscar",
            "paginate": {
                "next": "Siguiente",
                "previous": "Anterior",
            },
            "lengthMenu": 'Mostrar <select class="form-control form-control-sm" data-style="btn btn-link">' +
                '<option value="5">5</option>' +
                '<option value="10">10</option>' +
                '<option value="25">25</option>' +
                '<option value="50">50</option>' +
                '<option value="100">100</option>' +
                '<option value="-1">Todos</option>' +
                '<select> registros',
            "loadingRecords": "Cargando",
            "processing": "Procesando...",
            "emptyTable": "No se han encontrado registros",
            "zeroRecords": "No se han encontrado registros",
            "infoEmpty": " Mostrando 0 de 0 registros encontrados",
            "infoFiltered": ""
        },
    });
});

$(document).ready(function() {
    $('#data_table_revisar_credencial').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route ('mostrar_credenciales_revision')}}",
        columns: [{
                data: 'id'
            },
            {
                data: 'cedula'
            },
            {
                data: 'nombre'
            },
            {
                data: 'correo_institucional'
            },
            {
                data: 'usuario_medellin'
            },
            {
                data: 'password_medellin'
            },
            {
                data: 'estado'
            },
        ],
        "language": {
            "info": "_TOTAL_ Usuarios lista de usuarios",
            "search": "Buscar",
            "paginate": {
                "next": "Siguiente",
                "previous": "Anterior",
            },
            "lengthMenu": 'Mostrar <select class="form-control form-control-sm" data-style="btn btn-link">' +
                '<option value="5">5</option>' +
                '<option value="10">10</option>' +
                '<option value="25">25</option>' +
                '<option value="50">50</option>' +
                '<option value="100">100</option>' +
                '<option value="-1">Todos</option>' +
                '<select> registros',
            "loadingRecords": "Cargando",
            "processing": "Procesando...",
            "emptyTable": "No se han encontrado registros",
            "zeroRecords": "No se han encontrado registros",
            "infoEmpty": " Mostrando 0 de 0 registros encontrados",
            "infoFiltered": ""
        },
    });
});
</script>

@endsection