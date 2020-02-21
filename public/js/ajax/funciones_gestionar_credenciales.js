// Función para abrir la ventana modal para registrar una nueva credencial de usuario
$(document).on('click', '.boton_anadir_credencial_usuario', function () {
    $("#modal_anadir_credencial_usuario").modal();
});

//Función para ingresar una nueva credencial de usuario en la base de datos
$(document).on('click', '#btn_submit_credencial_usuario', function () {
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
    var token = $('input[name=_token]').val();
    var cedula = $('input[name=cedula]').val();
    var nombre = $('input[name=nombre]').val();
    var correo_institucional = $('input[name=correo_institucional]').val();
    var usuario_medellin = $('input[name=usuario_medellin]').val();
    var password_medellin = $('input[name=password_medellin]').val();
    var estado = 0;

    // Validar si todos los campos están completos
    if (token == "" || cedula == "" || nombre == "" || correo_institucional == "" || usuario_medellin == "" || password_medellin == "") {
        Swal.fire({
            icon: 'info',
            title: 'Atención',
            text: 'Debe completar todos los campos',
        })
        return;
    }

    //Validar el correo institucional es válido
    if (regex.test($('#correo_institucional').val().trim())) {
        //
    } else {
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'El correo electrónico institucional no es válido',
        })
        return;
    }

    //Validar si el usuario de medellín es válido
    if (regex.test($('#usuario_medellin').val().trim())) {
        //
    } else {
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'El usuario Uniremington no es válido',
        })
        return;
    }

    $.ajax({
        url: 'insertar_credenciales_usuario',
        headers: { 'X-CSRF-TOKEN': token },
        type: "POST",
        data: {
            'cedula': cedula,
            'nombre': nombre,
            'correo_institucional': correo_institucional,
            'usuario_medellin': usuario_medellin,
            'password_medellin': password_medellin,
            'estado': estado,
        },
        success: function (data) {
            Swal.fire({
                icon: 'success',
                title: '¡Bien!',
                text: 'Credencial de usuario creada de forma correcta',
                timer: 2000,
                showConfirmButton: false,
            })
            $('#modal_anadir_credencial_usuario').modal('hide');
            $('#data_table_credenciales').DataTable().ajax.reload();
            $('input[name="cedula"]').val('');
            $('input[name="nombre"]').val('');
            $('input[name="correo_institucional"]').val('');
            $('input[name="usuario_medellin"]').val('');
            $('input[name="password_medellin"]').val('');
            $('input[name="password"]').val('');
        },
        error: function (data) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Algo salió mal',
            })
        }
    })
});

//Función para pasar una credencial a estado de revisión
$(document).on('click', '.btn_modal_revisar_credencial', function () {
    var token = $('input[name=_token]').val();
    var columna_cedula = $(this).parents("tr").find("td").eq(0).text();
    var columna_nombre = $(this).parents("tr").find("td").eq(1).text();
    var columna_correo_institucional = $(this).parents("tr").find("td").eq(2).text();
    var columna_usuario_medellin = $(this).parents("tr").find("td").eq(3).text();
    var columna_password_medellin = $(this).parents("tr").find("td").eq(4).text();
    var estado = 0;

    Swal.fire({
        title: '¡Ey!',
        text: "¿Realmente quieres pasar estas credenciales a revisión?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#00457e',
        cancelButtonColor: '#e3001b',
        confirmButtonText: "Si",
        cancelButtonText: "No"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: 'insertar_credenciales_revisar',
                headers: { 'X-CSRF-TOKEN': token },
                type: "POST",
                data: {
                    'cedula': columna_cedula,
                    'nombre': columna_nombre,
                    'correo_institucional': columna_correo_institucional,
                    'usuario_medellin': columna_usuario_medellin,
                    'password_medellin': columna_password_medellin,
                    'estado': estado,
                },
                success: function (data) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Bien!',
                        text: 'Usuario registrado en la lista de revisión',
                        timer: 2000,
                        showConfirmButton: false,
                    })
                    $('#data_table_revisar_credencial').DataTable().ajax.reload();
                },
                error: function (data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Algo salió mal',
                    })
                }
            })
        }
    })
});

//Cambiar estado del checkbox de la lista de credenciales en estado de revisión
$(document).on('click', '.checkbox_comprobar', function () {
    var nombre = $(this).parents("tr").find("td").eq(2).text();
    var id = $(this).parents("tr").find("td").eq(0).text();
    var token = $('input[name=_token]').val();

    if ($(this).is(':checked')) {
        // Hacer algo si el checkbox ha sido seleccionado        
        var estado = 1;
        var ruta = "cambiar_estado_credencial/" + id;
        $.ajax({
            url: ruta,
            headers: { 'X-CSRF-TOKEN': token },
            type: "PUT",
            data: {
                'estado': estado,
            },
            success: function (data) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    html: '<p style="font-size:17px">El proceso del estudiante <strong>' + nombre + '</strong> ha finalizado</p>',
                    showConfirmButton: false,
                    timer: 3000
                })
            },
            error: function (data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Algo salió mal',
                })
            }
        })
    } else {
        // Hacer algo si el checkbox ha sido deseleccionado
        var estado = 0;
        var ruta = "cambiar_estado_credencial/" + id;
        $.ajax({
            url: ruta,
            headers: { 'X-CSRF-TOKEN': token },
            type: "PUT",
            data: {
                'estado': estado,
            },
            success: function (data) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'info',
                    html: '<p style="font-size:17px">La revisión de las credenciales del estudiante <strong>' + nombre + '</strong> continúa en proceso</p>',
                    showConfirmButton: false,
                    timer: 3000
                })
            },
            error: function (data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Algo salió mal',
                })
            }
        })
    }
});