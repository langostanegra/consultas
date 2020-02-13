// Función para que el botón de subir usuarios de la vista importar-usuarios
// muestre en su parte de abajo el nombre del archivo que se cargó
function cambiar() {
    var pdrs = document.getElementById('file-upload').files[0].name;
    document.getElementById('info').innerHTML = pdrs;
}
// Mensaje con un sweet alert del estado de la importación de los usuarios
$(document).on('click', '#alert', function(){
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Something went wrong!',
        footer: '<a href>Why do I have this issue?</a>'
      })
})

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
    $.ajax({
        type: "POST",        
        data: {
            '_token': $('input[name=_token]').val(),
            'name': $('input[name=name]').val(),
            'email': $('input[name=email]').val(),
            'password': $('input[name=password]').val(),
        },
        url: 'anadir_usuario',
        success: function(data){
            $('#modal_anadir_usuario').modal('hide');
            $('input[name="name"]').val('');
            $('input[name="email"]').val('');
            $('input[name="password"]').val('');
            Swal.fire(
                '!Bien!',
                'Usuario creado de forma correcta',
                'success'
            )
        },
        error: function(data){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
                footer: '<a href>Why do I have this issue?</a>'
            })
        }
    })
});