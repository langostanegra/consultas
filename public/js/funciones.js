// Función para que el botón de subir usuarios de la vista importar-usuarios
// muestre en su parte de abajo el nombre del archivo que se cargó
function cambiar() {
    var pdrs = document.getElementById('file-upload').files[0].name;
    document.getElementById('info').innerHTML = pdrs;
}
// Mensaje con un sweet alert del estado de la importación de los usuarios
$(document).on('click', '#probar', function(){
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Something went wrong!',
        footer: '<a href>Why do I have this issue?</a>'
      })
})