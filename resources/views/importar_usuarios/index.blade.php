@extends('layouts.app', ['activePage' => 'importar_usuarios', 'titlePage' => __('Dashboard')])

@section('content')
<div class="content">

    <!-- Si se presentan errrores, se mostrará un mensaje en pantalla -->
    @if(session('errors'))
    @foreach($errors as $error)
    <div class="alert alert-danger alert-danger fade show" role="alert">
        <strong>{{ $error }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endforeach
    @endif

    <!--Mensaje cuando los datos fueron importados de forma correcta-->
    @if(session('succes'))
    <div class="alert alert-success alert-success fade show" role="alert">
        <strong>{{session('succes')}}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card ">
        <div class="card-header card-header-primary">
            <h4 class="card-title">{{ __('Importar Usuarios') }}</h4>
            <!-- <p class="card-category">{{ __('User information') }}</p> -->
        </div>
        <div class="card-body ">
            <p>Acá podrá importar las credenciales de los estudiantes que hacen parte de Uniremington Manizales y
                cuenten con credenciales de Uniremington Medellín.</p>
            <p>Extensiones admitidas: XLSX - XLS - CSV</p>

            <table>
                <tr>
                    <td>
                        <a href="{{ asset('docs/plantilla.xlsx')}}" class="btn btn-block btn-success"
                            download="plantila.xlsx"><i class="fas fa-file-excel"></i> Descargar plantilla</a>
                    </td>
                </tr>
                <tr>
                    <!-- Botón para cargar los archivos -->
                    <form action="{{ route ('importar.usuarios.excel')}}" method="post" enctype="multipart/form-data">
                        <td>
                            {{ csrf_field() }}
                            <!--Botón de importar usuarios-->
                            <label style="width:100%;" for="file-upload" class="btn btn-primary">
                                <i class="fas fa-cloud-upload-alt"></i> Subir archivo
                            </label>
                            <input name="file" id="file-upload" onchange='cambiar()' type="file"
                                style='display: none;' />
                        </td>
                </tr>
            </table>
            <div class="div_info" id="info"></div>
        </div>

        <div class="card-footer ml-auto mr-auto">
            <button type="submit" class="btn btn-primary">{{ __('Importar') }}</button>
        </div>
        </form>
    </div>
</div>

@endsection

@push('js')
<script>
$(document).ready(function() {
    // Javascript method's body can be found in assets/js/demos.js
    md.initDashboardPageCharts();
});

@endpush