/* Función para que el botón de subir usuarios de la vista importar-usuarios
muestre en su parte de abajo el nombre del archivo que se cargó*/
function cambiar() {
    var pdrs = document.getElementById('file-upload').files[0].name;
    document.getElementById('info').innerHTML = pdrs;
}

//Abrir la ventana modal de añadir un nuevo usuario
$(document).on('click', '.boton_anadir_usuario', function(){
    $("#modal_anadir_usuario").modal();
});

//Limpiar modal de registro de usuarios
$(document).on('click', '#limpiar_modal_usuarios', function(){
      $('input[name="name"]').val('');
      $('input[name="email"]').val('');
      $('input[name="password"]').val('');      
});

// Limpiar modal de cambio de contraseñas
$(document).on('click', '#limpiar_modal_password', function(){    
    $('input[name="nuevo_password"]').val('');      
});

//Función para guardar un usuario en la base de datos
$(document).on('click', '#btn_anadir_usuario', function(){
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
    var token = $('input[name=_token]').val();
    var name = $('input[name=name]').val();
    var email = $('input[name=email]').val();
    var password = $('input[name=password]').val();
    // Validar si todos los campos están completos
    if (token == "" || name == "" || email == "" || password == ""){
        Swal.fire({
            icon: 'info',
            title: 'Atención',
            text: 'Debe completar todos los campos',
        })
        return;
    }
    //Validar si un email es válido
    if (regex.test($('#email').val().trim())) {
        //
    } else {
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'El correo electrónico no es válido',                
        })
        return;
    }
    
    $.ajax({
        type: "POST",        
        data: {
            '_token': token,
            'name': name,
            'email': email,
            'password': password,
        },
        url: 'anadir_usuario',
        success: function(data){
            Swal.fire({
                icon: 'success',
                title: '¡Bien!',
                text: 'Usuario creado de forma correcta',
                timer: 2000,
                showConfirmButton: false,
              })
            $('#modal_anadir_usuario').modal('hide');
            $('#data_table_usuarios').DataTable().ajax.reload();            
            $('input[name="name"]').val('');
            $('input[name="email"]').val('');
            $('input[name="password"]').val('');            
        },
        error: function(data){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Algo salió mal, intenta de nuevo',                
            })
        }
    })
});

//Abrir la ventana modal de editar un nuevo usuario
/*Recordar que al dar clic en el botón del lápiz, la función recolecta todos los datos
para luego poder ser enviados por el método put al controlado*/
$(document).on('click', '.btn_modal_editar_usuario', function(){
    var columna_name = $(this).parents("tr").find("td").eq(0).text();
    var columna_email = $(this).parents("tr").find("td").eq(1).text();
    $('input[name="edit_name"]').val(columna_name);
    $('input[name="edit_email"]').val(columna_email);
    let id = this.id;
    $('input[name="usuario_id"]').val(id);
    $("#modal_editar_usuario").modal();
});

//Función para modificar un usuario en la base de datos
$(document).on('click', '#btn_editar_usuario', function(){    
    var token = $('input[name=_token]').val();
    var usuario_id = $("#usuario_id").val();
    var name = $('input[name=edit_name]').val();
    var email = $('input[name=edit_email]').val();
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
    
     // Validar si todos los campos están completos
     if (token == "" || name == "" || email == ""){
        Swal.fire({
            icon: 'info',
            title: 'Atención',
            text: 'Debe completar todos los campos',
        })
        return;
    }
    if (regex.test($('#edit_email').val().trim())) {
        //
    } else {
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'El correo electrónico no es válido',                
        })
        return;
    }

    var ruta ="editar_usuario/"+usuario_id;
    $.ajax({
        url: ruta,
        headers: {'X-CSRF-TOKEN': token},
        type: "PUT",
        data: {                    
            'name': name,
            'email': email,
        },                
        success: function(data){
            Swal.fire({
                icon: 'success',
                title: '¡Bien!',
                text: 'Usuario modificado de forma correcta',
                timer: 2000,
                showConfirmButton: false,
              })
            $('#modal_editar_usuario').modal('hide');
            $('#data_table_usuarios').DataTable().ajax.reload();
        },
        error: function(data){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Algo salió mal, intenta de nuevo',
            })
        }
    })
});

//Mostrar alerta para confirmar la eliminación de un usuario
$(document).on('click', '.btn_modal_eliminar_usuario', function(){    
    let usuario_id = this.id;
    if (usuario_id == 1){
        Swal.fire(
            '¡Ey!',
            'No puedes borrar al administrador del sistema',
            'question'
          )
    }else{
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,        
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar',
            confirmButtonText: "Si",
            cancelButtonText: "No"
          }).then((result) => {
            if (result.value) {                        
                var ruta ="eliminar_usuario/"+usuario_id;
                $.ajax({
                    url: ruta,                
                    type: "GET",
                    success: function(data){
                        Swal.fire({
                            icon: 'success',
                            title: '¡Bien!',
                            text: 'Usuario eliminado de forma correcta',
                            timer: 2000,
                            showConfirmButton: false,
                          })                    
                        $('#data_table_usuarios').DataTable().ajax.reload();
                    },
                    error: function(data){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Algo salió mal, intenta de nuevo',
                        })
                    }
                })
            }
        })
    }    
});

// Función para abrir el modal de cambiar contraseña y capturar el id del usuario
$(document).on('click', '.btn_modal_cambiar_password', function(){
    $("#modal_cambiar_password").modal();
    let id = this.id;
    $('input[name="password_usuario_id"]').val(id);
});

//Función para modificar un usuario en la base de datos
$(document).on('click', '#btn_cambiar_contraseña', function(){
    var token = $('input[name=_token]').val();
    var usuario_id = $("#password_usuario_id").val();
    var nuevo_password = $('input[name=nuevo_password]').val();
    
     // Validar si todos los campos están completos
     if (token == "" || nuevo_password == ""){
        Swal.fire({
            icon: 'info',
            title: 'Atención',
            text: 'Debe completar el campo',
        })
        return;
    }

    var ruta ="cambiar_password_usuario/"+usuario_id;
    $.ajax({
        url: ruta,
        headers: {'X-CSRF-TOKEN': token},
        type: "PUT",
        data: {                    
            'password': nuevo_password,
        },                
        success: function(data){
            Swal.fire({
                icon: 'success',
                title: '¡Bien!',
                text: 'Contraseña modificada de forma correcta',
                timer: 2000,
                showConfirmButton: false,
              })
            $('#modal_cambiar_password').modal('hide');
            $('#data_table_usuarios').DataTable().ajax.reload();
        },
        error: function(data){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Algo salió mal, intenta de nuevo',
            })
        }
    })    
});

// Función para mostrar la contraseña del input de contraseñas del modal de añadir un nuevo usuario
$(document).on('click', '#mostrar_password_modal_anadir_usuario', function(){
    var tipo = document.getElementById("password");
    if(tipo.type == "password"){
        tipo.type = "text";
    }else{
        tipo.type = "password";
    }
});

// Función para mostrar la contraseña del input de contraseñas del modal de cambiar contraseña
$(document).on('click', '#mostrar_password_modal_cambiar_password', function(){
    var tipo = document.getElementById("nuevo_password");
    if(tipo.type == "password"){
        tipo.type = "text";
    }else{
        tipo.type = "password";
    }
});



