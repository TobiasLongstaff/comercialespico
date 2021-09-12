$(document).ready(() =>
{
    $('#form-registrarse').submit(function (e)
    {
        const postData = 
        {
            mail: $('#reg-mail').val(),
            nombre_apellido: $('#reg-nombre').val(),
            password: $('#reg-pass').val(),
            password_con: $('#reg-pass-con').val()
        };
        $.post('partials/crear-cuenta.php', postData, function (data)
        {    
            console.log(data)      
            if(data == '1')
            {
                Swal.fire(
                    '¡Cuenta creada correctamente!',
                    'Su cuenta se encuentra en periodo de aprobacion',
                    'success'
                )
                const form = document.getElementById("form-registrarse");
                form.reset();
            }
            else
            {
                $('#error-regis').html(data);
            }      

        });
        e.preventDefault();
    });
});