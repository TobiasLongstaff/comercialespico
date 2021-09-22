$(document).ready(() =>
{
    var edit_cliente = false;
    obtener_clientes();

    $('#form-editar-mail').submit(function(e) 
    {
        var mail = $('#mail-general').val();

        $.post('partials/editar-mail-general.php', {mail}, function (data)
        {
            if(data == "1")
            {
                Swal.fire(
                    '¡Operación realizada exitosamente!',
                    '',
                    'success'
                )
            }
            else
            {
                $('#error-mail').html(data);
            }
        });
        e.preventDefault();
    })

    $("#form-abm-clientes").submit(function(e)
    {
        const postData =
        {
            nombre: $('#nombre-cliente').val(),
            id: $('#id-cliente').val(),
            password: $('#password-cliente').val(),
            mail: $('#mail-cliente').val()
        };

        let url = edit_cliente === false ? 'partials/agregar-cliente.php' : 'partials/editar-cliente.php';

        $.post(url, postData, function (data)
        {
            if(data == "1")
            {
                Swal.fire(
                    '¡Operación realizada exitosamente!',
                    '',
                    'success'
                )
                const form = document.getElementById("form-abm-clientes");
                form.reset();
                edit_cliente = false;
                $('#btn-agregar-nueva-cliente').val('Agregar');
                $('#btn-agregar-nueva-cliente').css('background-color', 'var(--azul)')
                obtener_clientes()
            }
            else
            {
                $('#error-login').html(data);
            }
        }); 
        e.preventDefault();   
    });

    $(document).on('click', '.eliminar-cliente', function(e)
    {
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('filaid');

        Swal.fire(
        {
            title: '¿Queres eliminar este cliente?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
        }).then((result) => 
        {
            if (result.isConfirmed) 
            {
                $.post('partials/eliminar-cliente.php', {id}, function(data)
                {
                    if(data == '1')
                    {
                        Swal.fire(
                            '¡cliente eliminado exitosamente!',
                            '',
                            'success'
                        )
                        obtener_clientes();                        
                    }
                    else
                    {
                        $('#error-login').html('Antes de eliminar un cliente es necesario eliminar todos los archivos que se encuentra dentro');
                    }

                });       
            }
        });
        e.preventDefault();
    })

    $(document).on('click', '.editar-cliente', function(e)
    {
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('filaid');

        $.post('partials/obtener-datos-cliente-editar.php', {id}, function(data)
        {
            const cliente = JSON.parse(data);
            $('#nombre-cliente').val(cliente.nombre);
            $('#mail-cliente').val(cliente.mail);
        })

        $('#btn-agregar-nueva-cliente').val('Editar');
        $('#btn-agregar-nueva-cliente').css('background-color', '#15a95b')
        edit_cliente = true;
        $('#id-cliente').val(id);
        e.preventDefault();
    })

    function obtener_clientes()
    {
        $.ajax(
        {
            url: 'partials/obtener-clientes.php',
            type: 'GET',
            success: function (response)
            {
                let clientes = JSON.parse(response);
                let plantilla = '';
                
                clientes.forEach(cliente =>
                {
                    plantilla += 
                    `
                    <tr filaId="${cliente.id}">
                        <td class="td-controles">
                            <button class="btn-editar editar-cliente"><i class="uil uil-edit-alt"></i></button>
                        </td>
                        <td class="td-controles">
                            <button class="btn-eliminar eliminar-cliente"><i class="uil uil-trash-alt"></i></button>
                        </td>
                        <td>${cliente.id}</td>
                        <td>${cliente.nombre}</td>
                        <td>${cliente.mail}</td>
                    </tr>  
                    `                           
                });
                $('#container-cliente').html(plantilla);
            }
        });
    }
});