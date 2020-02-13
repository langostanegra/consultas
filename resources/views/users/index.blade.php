@extends('layouts.app', ['activePage' => 'user-management', 'titlePage' => __('User Management')])

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
                    <button type="button" id="boton_anadir_usuario"
                        class="btn btn-sm btn-primary">{{ __('Añadir usuario') }}</button>
                </div>
                <table id="data_table" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th style="cursor: pointer;"><strong>Nombre</strong></th>
                            <th style="cursor: pointer;"><strong>Email</strong></th>
                            <th style="cursor: pointer;"><strong>Fecha de creación</strong></th>
                            <th style="cursor: pointer;"><strong>Acciones</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>61</td>
                        </tr>
                        <tr>
                            <td>Michael Bruce</td>
                            <td>Javascript Developer</td>
                            <td>Singapore</td>
                            <td>29</td>
                        </tr>
                        <tr>
                            <td>Donna Snider</td>
                            <td>Customer Support</td>
                            <td>New York</td>
                            <td>27</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-muted">
                Usuarios registrados
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_anadir_usuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Añadir un nuevo usuario</h5>
                <button id="limpiar_modal" style="outline:none;" type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
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
                <button id="anadir_usuario_db" type="button" class="btn btn-primary">Añadir</button>
            </div>
        </div>
    </div>
</div>

@endsection