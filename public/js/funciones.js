// Función para que el botón de subir usuarios de la vista importar-usuarios
// muestre en su parte de abajo el nombre del archivo que se cargó
function cambiar() {
    var pdrs = document.getElementById('file-upload').files[0].name;
    document.getElementById('info').innerHTML = pdrs;
}

//Abrir la ventana modal de añadir un nuevo usuario
$(document).ready(function() {
    $("#boton_anadir_usuario").click(function() {
        $("#modal_anadir_usuario").modal();
    });
});

//Limpiar modal de registro de usuarios
$(document).ready(function() {
    $('#limpiar_modal').click(function() {
      $('input[name="name"]').val('');
      $('input[name="email"]').val('');
      $('input[name="password"]').val('');
    });
  });

//Función para guardar un usuario en la base de datos
$(document).on('click', '#anadir_usuario_db', function(){
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