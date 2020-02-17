@extends('layouts.app', ['activePage' => 'gestionar-usuarios', 'titlePage' => __('User Management')])

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="card card-nav-tabs text-left">
            <div class="card-header card-header-primary">
                <h4 class="card-title ">{{ __('Usuarios') }}</h4>
                <p class="card-category">{{ __('Acá podrás gestionar los usuarios asociados a la plataforma') }}</p>
            </div>
            <div class="card-body">
                <div class="col-12 text-right">
                    <button type="button"
                        class="btn btn-sm btn-primary boton_anadir_usuario">{{ __('Añadir usuario') }}</button>
                </div>
                <table id="data_table_usuarios" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th style="cursor: pointer;"><strong>Nombre</strong></th>
                            <th style="cursor: pointer;"><strong>Email</strong></th>
                            <th style="cursor: pointer;"><strong>Fecha de creación</strong></th>
                            <th style="cursor: pointer;"><strong>Fecha de creación</strong></th>
                            <th><strong>Acciones</strong></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para insertar un nuevo usuario en la base de datos -->
<div class="modal fade" id="modal_anadir_usuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Añadir un nuevo usuario</h5>
                <button id="limpiar_modal_usuarios" style="outline:none;" type="button" class="close"
                    data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <!-- Input nombre -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <!-- Input email -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <!-- Input password -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btn_anadir_usuario" type="button" class="btn btn-primary">Añadir</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar un nuevo usuario -->

<div class="modal fade" id="modal_editar_usuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar usuario</h5>
                <button style="outline:none;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <!-- Input nombre -->
                    <input type="hidden" id="usuario_id" name="usuario_id" value="">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre</label>
                        <input type="text" class="form-control" id="edit_name" name="edit_name" required>
                    </div>
                    <!-- Input email -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="edit_email" required>
                    </div>
                    <!-- Input password -->
                    <!-- <div class="form-group">
                        <label for="exampleInputEmail1">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div> -->
                </form>
            </div>
            <div class="modal-footer">
                <button id="btn_editar_usuario" type="button" class="btn btn-primary">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para cambiar el password de un usuario -->

<div class="modal fade" id="modal_cambiar_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cambiar contraseña</h5>
                <button id="limpiar_modal_password" style="outline:none;" type="button" class="close"
                    data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <!-- Input para ingresar un nuevo password -->
                    <input type="hidden" id="password_usuario_id" name="password_usuario_id" value="">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nueva contraseña</label>
                        <input type="password" class="form-control" id="nuevo_password" name="nuevo_password"
                            required><br><i style="cursor:pointer;" id="mostrar_password"
                            class="material-icons">remove_red_eye</i>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btn_cambiar_contraseña" type="button" class="btn btn-primary">Cambiar contraseña</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#data_table_usuarios').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route ('mostrar_usuarios')}}",
        columns: [{
                data: 'name'
            },
            {
                data: 'email'
            },
            {
                data: 'created_at'
            },
            {
                data: 'updated_at'
            },
            {
                data: 'acciones'
            },
        ],
        "language": {
            "info": "_TOTAL_ Usuarios registrados",
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