@extends('layouts.app', ['activePage' => 'gestionar_credenciales', 'titlePage' => __('User Management')])

@section('content')

<link href="{{ asset('css/checkbox.css')}}" rel="stylesheet" />
<br><br><br><br>
<!-- Tabla que muestra todos los usuarios que cuentan con credenciales institucionales -->
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
</div><br><br>

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
            <table id="data_table_revisar_credencial" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th style="cursor: pointer;"><strong>Id</strong></th>
                        <th style="cursor: pointer;"><strong>Cédula</strong></th>
                        <th style="cursor: pointer;"><strong>Nombre</strong></th>
                        <th style="cursor: pointer;"><strong>Usuario Medellín</strong></th>
                        <th style="cursor: pointer;"><strong>Contraseña Medellín</strong></th>
                        <th style="cursor: pointer;"><strong>Reportado</strong></th>
                        <th style="cursor: pointer;"><strong>Finalizado</strong></th>
                        <th><strong>Estado</strong></th>
                        <th WIDTH="100"><strong>
                                <center>Acciones</center>
                            </strong></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div><br><br>

<!-- Zona para maquetar el correo electrónico que se envía a mesa de ayuda con los datos personales de los estudiantes -->
<div class="container-fluid">
    <div class="card card-nav-tabs text-left">
        <div class="card-header card-header-primary">
            <h4 class="card-title ">{{ __('Maquetar plantilla de correo electrónico') }}</h4>
            <p class="card-category">Acá podrá realizar un correo dinámico que proporcionará agilidad al momento de
                enviar información a mesa de ayuda
            </p>
        </div>
        <div class="card-body">
            <div class="col-12 text-right">
            </div>
            <label>Redactar mensaje dinámico</label>
            <div class="dropdown">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Variables
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a style="cursor:pointer;" class="dropdown-item" data-value="##cedula##"
                        id="variable_mensaje_dinamico">Cedula</a>
                    <a style="cursor:pointer;" class="dropdown-item" data-value="##nombre##"
                        id="variable_mensaje_dinamico">Nombre</a>
                    <a style="cursor:pointer;" class="dropdown-item" data-value="##correo_institucional##"
                        id="variable_mensaje_dinamico">Correo Institucional</a>
                    <a style="cursor:pointer;" class="dropdown-item" data-value="##usuario_medellin##"
                        id="variable_mensaje_dinamico">Usuario Medellín</a>
                    <a style="cursor:pointer;" class="dropdown-item" data-value="##password_medellin##"
                        id="variable_mensaje_dinamico">Password Medellín</a>
                </div>
            </div>
            <form class="form-horizontal" role="form">
                <textarea maxlength="1000" rows="10" cols="100" class="form-control" id="mensaje_dinamico"
                    name="mensaje_dinamico" value=""
                    required>@foreach($plantilla_correo as $plantillas){{$plantillas->plantilla}}@endforeach</textarea>
        </div>
        <div class="container-fluid">
            <div class="col-12 text-right">
                <button type="button" class="btn btn btn-primary btn_submit_mensaje_dinamico">Crear</button>
            </div>
        </div><br>
        </form>
    </div>
</div>

<!-- Modal para insertar una nueva credencial de usuario en la base de datos -->
<div class="modal fade" id="modal_anadir_credencial_usuario" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Añadir una nueva credencial de usuario</h5>
                <button id="limpiar_modal_anadir_credencial" style="outline:none;" type="button" class="close"
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

<!-- Modal para modificar una credencial de usuario -->
<div class="modal fade" id="modal_editar_credencial_usuario" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar información del usuario</h5>
                <button id="limpiar_modal_usuarios" style="outline:none;" type="button" class="close"
                    data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <input type="hidden" id="credencial_id" value="" name="credencial_id">
                    <!-- Input cedula -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Cédula</label>
                        <input type="text" class="form-control" id="editar_cedula" name="editar_cedula" required>
                    </div>
                    <!-- Input nombre -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre</label>
                        <input type="text" class="form-control" id="editar_nombre" name="editar_nombre" required>
                    </div>
                    <!-- Input correo institucional -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Correo institucional</label>
                        <input type="text" class="form-control" id="editar_correo_institucional"
                            name="editar_correo_institucional" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btn_submit_editar_credencial_usuario" type="button"
                    class="btn btn-primary">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para modificar una credencial de usuario que está en la tabla de revisón -->
<div class="modal fade" id="modal_editar_credencial_revisar" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar credenciales de usuario Uniremington</h5>
                <button id="limpiar_modal_usuarios" style="outline:none;" type="button" class="close"
                    data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <input type="hidden" id="cedula_credencial_revisar" name="cedula_credencial_revisar">
                    <input type="hidden" id="credencial_revisar_id" value="" name="credencial_revisar_id">
                    <!-- Input del correo electrónico institucional -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Correo Uniremington Medellín</label>
                        <input type="text" class="form-control" id="editar_usuario_medellin_revisar"
                            name="editar_usuario_medellin_revisar" required>
                    </div>
                    <!-- Input del password medellín -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Password Medellín</label>
                        <input type="text" class="form-control" id="editar_password_medellin_revisar"
                            name="editar_password_medellin_revisar" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btn_submit_editar_credencial_revisar" type="button"
                    class="btn btn-primary">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar una nueva nota de una credencial en revision -->
<div class="modal fade" id="modal_nota_credencial_revision" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nota</h5>
                <button id="limpiar_modal_anadir_nota" style="outline:none;" type="button" class="close"
                    data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <input type="hidden" id="credencial_nota_id" value="" name="credencial_nota_id">
                    <div class="form-group">
                        <!-- textarea para añadir una nueva nota  -->
                        <textarea maxlength="250" rows="4" cols="50" class="form-control" id="nota_credencial_revision"
                            name="nota_credencial_revision" value="" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btn_submit_nota_credencial_revision" type="button" class="btn btn-primary">Añadir</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para mostrar el correo electrónico que se emviará a mesa de ayuda de Medellín -->
<div class="modal fade" id="modal_correo_maquetado" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Correo electrónico para mesa de ayuda</h5>
                <button id="limpiar_modal_anadir_nota" style="outline:none;" type="button" class="close"
                    data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">                
                    <div class="form-group">
                        <!-- textarea para añadir una nueva nota  -->
                        <textarea maxlength="1500" rows="10" cols="10" class="form-control" id="textarea_correo_maquetado"
                            name="textarea_correo_maquetado" value="" required></textarea>
                    </div>                
            </div>
            <div class="modal-footer">
            <button id="btn_copiar_correo_maquetado" type="button" class="btn btn-success">Copiar</button>
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
                data: 'usuario_medellin'
            },
            {
                data: 'password_medellin'
            },
            {
                data: 'fecha_inicio'
            },
            {
                data: 'fecha_fin'
            },
            {
                data: 'estado'
            },
            {
                data: 'acciones'
            },
        ],
        "language": {
            "info": "_TOTAL_ Usuarios en la lista de revisión",
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