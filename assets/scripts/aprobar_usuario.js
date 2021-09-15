$(document).ready(() =>
{
    $('#from-aprobar-usuario').submit(function (e)
    {
        Swal.fire({
            title: '¿Seguro que quieres aprobar esta cuenta?',
            text: "Una vez se apruebe la cuenta el usuario podrá acceder al sistema y realizar operaciones (según el tipo de usuario).",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Aprobar'
        }).then((result) => {    

            if (result.isConfirmed) 
            {           
                const postData =
                {
                    selectlist_permisos: $('#select-permisos').val(),
                    mail: $('#mail-usuario').val(),
                    hash: $('#hash-usuario').val(),
                };
                $.post('partials/aprobar-cuenta.php', postData, function (data)
                {
                    console.log(data);
                    if(data == 1)
                    {
                        Swal.fire(
                            'Usuario Aprobado!',
                            'El usuario fue aprobado correctamente recibirá un mail automático para notificarlo.',
                            'success'
                        )
                    }
                    else
                    {
                        Swal.fire(
                            'Error!',
                            'Error al aprobar el usuario compruebe que el link es correcto',
                            'error'
                        )  
                    }
                }); 
            }
        })
        e.preventDefault();  
    });
})