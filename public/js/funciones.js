// Función para que el botón de subir usuarios de la vista importar-usuarios
// muestre en su parte de abajo el nombre del archivo que se cargó
function cambiar() {
    var pdrs = document.getElementById('file-upload').files[0].name;
    document.getElementById('info').innerHTML = pdrs;
}

//Abrir la ventana modal de añadir un nuevo usuario
$(document).on('click', '.boton_anadir_usuario', function(){
    $("#modal_anadir_usuario").modal();
});

//Abrir la ventana modal de editar un nuevo usuario
$(document).on('click', '.btn_modal_editar_usuario', function(){
    var columna_name = $(this).parents("tr").find("td").eq(0).text();
    var columna_email = $(this).parents("tr").find("td").eq(1).text();
    var name = $('input[name="edit_name"]').val(columna_name);
    var email = $('input[name="edit_email"]').val(columna_email);
    let id = this.id;
    var usuario_id = $('input[name="usuario_id"]').val(id);
    $("#modal_editar_usuario").modal();
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

//Limpiar modal de registro de usuarios
$(document).ready(function() {
    $('#limpiar_modal').click(function() {
      $('input[name="name"]').val('');
      $('input[name="email"]').val('');
      $('input[name="password"]').val('');
    });
  });