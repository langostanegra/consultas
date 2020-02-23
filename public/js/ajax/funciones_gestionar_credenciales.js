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
    //Capturar la fecha actual
    var fecha_inicio = new Date();
    var dd = fecha_inicio.getDate();
    var mm = fecha_inicio.getMonth() + 1;
    var yyyy = fecha_inicio.getFullYear();

    if(dd<10) {
        dd='0'+dd;
    } 
     
    if(mm<10) {
        mm='0'+mm;
    }

    fecha_inicio = yyyy+'/'+mm+'/'+dd;    
    var estado = 0;

    Swal.fire({
        html: '<p style="font-size:18px;"><strong>Estudiante: </strong> ' + columna_nombre + '</p><p style="font-size:18px;">¿Realmente quieres pasar estas credenciales a revisión?</p>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1784ff',
        cancelButtonColor: '#c5c5c5',
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
                    'fecha_inicio': fecha_inicio,
                },
                success: function (data) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Bien!',
                        text: 'Credenciales registradas en la lista de revisión',
                        timer: 2000,
                        showConfirmButton: false,
                    })
                    $('#data_table_revisar_credencial').DataTable().ajax.reload();
                },
                error: function (data) {
                    Swal.fire({
                        icon: 'error',
                        html: '<p style="font-size:18px;">El estudiante <strong> ' + columna_nombre + '</strong></p><p style="font-size:18px;">Ya se encuentra registrado en la lista de revisión</p>',
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
        var fecha_fin = new Date();
        var dd = fecha_fin.getDate();
        var mm = fecha_fin.getMonth() + 1;
        var yyyy = fecha_fin.getFullYear();
    
        if(dd<10) {
            dd='0'+dd;
        } 
         
        if(mm<10) {
            mm='0'+mm;
        }
    
        fecha_fin = yyyy+'/'+mm+'/'+dd;        
        console.log(fecha_fin);

        var estado = 1;
        var ruta = "cambiar_estado_credencial/" + id;
        $.ajax({
            url: ruta,
            headers: { 'X-CSRF-TOKEN': token },
            type: "PUT",
            data: {
                'estado': estado,
                'fecha_fin': fecha_fin,
            },
            success: function (data) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    html: '<p style="font-size:17px">El proceso del estudiante <strong>' + nombre + '</strong> ha finalizado</p>',
                    showConfirmButton: false,
                    timer: 3000
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
    } else {
        // Hacer algo si el checkbox ha sido deseleccionado
        var estado = 0;
        var fecha_inicio = null;

        var ruta = "cambiar_estado_credencial/" + id;
        $.ajax({
            url: ruta,
            headers: { 'X-CSRF-TOKEN': token },
            type: "PUT",
            data: {
                'estado': estado,
                'fecha_fin': fecha_fin,
            },
            success: function (data) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'info',
                    html: '<p style="font-size:17px">La revisión de las credenciales del estudiante <strong>' + nombre + '</strong> continúa en proceso</p>',
                    showConfirmButton: false,
                    timer: 3000
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
});

//Abrir la ventana modal de editar una credencial de usuario
/*Recordar que al dar clic en el botón del lápiz, la función recolecta todos los datos
para luego poder ser enviados por el método put al controlado*/
$(document).on('click', '.btn_modal_editar_credencial', function () {
    var columna_cedula = $(this).parents("tr").find("td").eq(0).text();
    var columna_nombre = $(this).parents("tr").find("td").eq(1).text();
    var columna_correo_institucional = $(this).parents("tr").find("td").eq(2).text();
    $('input[name="editar_cedula"]').val(columna_cedula);
    $('input[name="editar_nombre"]').val(columna_nombre);
    $('input[name="editar_correo_institucional"]').val(columna_correo_institucional);
    let id = this.id;
    $('input[name="credencial_id"]').val(id);
    $("#modal_editar_credencial_usuario").modal();
});

// Función para modificiar una credencial de usuario
$(document).on('click', '#btn_submit_editar_credencial_usuario ', function () {
    var token = $('input[name=_token]').val();
    var credencial_id = $("#credencial_id").val();
    var cedula = $('input[name=editar_cedula]').val();
    var nombre = $('input[name=editar_nombre]').val();
    var correo_institucional = $('input[name=editar_correo_institucional]').val();
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    // Validar si todos los campos están completos
    if (token == "" || credencial_id == "" || cedula == "" || nombre == "" || correo_institucional == "") {
        Swal.fire({
            icon: 'info',
            title: 'Atención',
            text: 'Debe completar todos los campos',
        })
        return;
    }

    //Validar correo institucional
    if (regex.test($('#editar_correo_institucional').val().trim())) {
        //
    } else {
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'El correo electrónico institucional9 no es válido',
        })
        return;
    }

    var ruta = "editar_credencial_usuario/" + credencial_id;
    $.ajax({
        url: ruta,
        headers: { 'X-CSRF-TOKEN': token },
        type: "PUT",
        data: {
            'cedula': cedula,
            'nombre': nombre,
            'correo_institucional': correo_institucional,
        },
        success: function (data) {
            Swal.fire({
                icon: 'success',
                title: '¡Bien!',
                text: 'Datos de usuario modificados de forma correcta',
                timer: 2000,
                showConfirmButton: false,
            })
            $('#modal_editar_credencial_usuario').modal('hide');
            $('#data_table_credenciales').DataTable().ajax.reload();
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

// Función para abrir la ventana modal que agrega una nota en la tabla de las credenciales en revisión
$(document).on('click', '.btn_modal_nota_credencial_revision', function () {
    $("#modal_nota_credencial_revision").modal();
});